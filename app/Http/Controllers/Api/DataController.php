<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Location;
use App\Models\TileCategory;
use App\Models\TileSize;
use App\Models\TileType;
use App\Models\User;
use App\Models\TileProduct;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\TileProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyOffer;

class DataController extends Controller
{

    protected CompanyRepositoryInterface $companyRepository;
    protected TileProductRepositoryInterface $productRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository, TileProductRepositoryInterface $productRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->productRepository = $productRepository;
    }
    // List Users
    public function users()
    {
        try {
            $users = User::select('id', 'name', 'phone', 'is_active', 'role', 'created_at')
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $users,
            ], 200);
        } catch (Exception $e) {
            Log::error('DataController@users Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch users.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // List Active Locations with Godowns Count
    public function locations()
    {
        try {
            $locations = Location::where('is_active', true)
                ->withCount('godowns')
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $locations,
            ], 200);
        } catch (Exception $e) {
            Log::error('DataController@locations Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch locations.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // List Active Godowns with Location details
    public function godowns()
    {
        try {
            $godowns = Godown::with('location:id,name')
                ->where('is_active', true)
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $godowns,
            ], 200);
        } catch (Exception $e) {
            Log::error('DataController@godowns Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch godowns.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // List Active Tile Categories
    public function categories()
    {
        try {
            $categories = TileCategory::where('is_active', true)
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $categories,
            ], 200);
        } catch (Exception $e) {
            Log::error('DataController@categories Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // List Active Tile Types
    public function types()
    {
        try {
            $types = TileType::where('is_active', true)
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $types,
            ], 200);
        } catch (Exception $e) {
            Log::error('DataController@types Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch types.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // List Active Tile Sizes
    public function sizes()
    {
        try {
            $sizes = TileSize::where('is_active', true)
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $sizes,
            ], 200);
        } catch (Exception $e) {
            Log::error('DataController@sizes Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch sizes.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    public function products(Request $request, $id = null)
    {
        try {
            $query = TileProduct::with([
                'category:id,name',
                'type:id,name',
                'size:id,name,width_mm,height_mm,unit',
                'location:id,name',
                'godown:id,name'
            ])
                ->where('is_active', true)
                ->whereNotNull('image')         // Exclude NULL images
                ->where('image', '!=', '');     // Exclude empty string images

            // Capture ID from route param (/products/{id}) OR query string (/products?id=1)
            $targetId = $id ?? $request->input('id') ?? $request->input('product_id');

            if ($targetId) {
                $ids = is_array($targetId) ? $targetId : explode(',', $targetId);
                $query->whereIn('id', array_map('trim', $ids));
            }

            // Optional filtering by category, type, or size
            if ($request->filled('category_id')) {
                $query->where('tile_category_id', $request->category_id);
            }
            if ($request->filled('type_id')) {
                $query->where('tile_type_id', $request->type_id);
            }
            if ($request->filled('size_id')) {
                $query->where('tile_size_id', $request->size_id);
            }

            $products = $query->latest()->get()->map(function ($product) {
                // Build absolute image URL using storage/public path
                $imageUrl = filter_var($product->image, FILTER_VALIDATE_URL)
                    ? $product->image
                    : asset('storage/' . $product->image);

                return [
                    'id'                => $product->id,
                    'product_name'      => $product->product_name,
                    'sku'               => $product->sku,
                    'price'             => $product->price,
                    'stock_quantity'    => $product->stock_quantity,
                    'box_coverage_sqft' => $product->box_coverage_sqft,
                    'pieces_per_box'    => $product->pieces_per_box,
                    'image_url'         => $imageUrl,
                    'category'          => $product->category ? $product->category->name : null,
                    'type'              => $product->type ? $product->type->name : null,
                    'size'              => $product->size ? $product->size->name : null,
                    'location'          => $product->location ? $product->location->name : null,
                    'godown'            => $product->godown ? $product->godown->name : null,
                    'description'       => $product->description,
                    'display_front'     => $product->display_front
                ];
            });

            // If a specific ID was requested but not found
            if ($products->isEmpty() && $targetId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products with images found matching the requested ID.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'count'   => $products->count(),
                'data'    => $products,
            ], 200);
        } catch (Exception $e) {
            Log::error('DataController@products Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // List Active Godowns with Location details
    public function company()
    {
        try {
            // Fetch dynamic company details from DB via Repository
            $company = $this->companyRepository->getFirstCompany();

            if (!$company) {
                return response()->json([
                    'success' => false,
                    'message' => 'Company details not found',
                ], 404);
            }

            // Resolve logo path to full URL
            // If stored in public/images/ (e.g. 'images/logo_123.png')
            $logoUrl = $company->logo
                ? asset($company->logo)
                : asset('images/logo.png');

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'      => $company->id,
                    'name'    => $company->name,
                    'email'   => $company->email,
                    'phone'   => $company->phone,
                    'address' => $company->address,
                    'logo'    => $logoUrl,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch company details: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user(); // Get logged-in user via Auth token

        // Validate incoming request
        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
        ]);

        // Fill and save updated user data
        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data'    => $user->only(['id', 'name', 'email', 'phone', 'bio']),
        ], 200);
    }

    public function getAllProductsStock()
    {
        try {
            $products = $this->productRepository->getAllWithStockLocations();

            $formattedProducts = $products->map(function ($product) {
                // Map godowns & location details
                $locationsStock = $product->godowns->map(function ($godown) {
                    return [
                        'godown_id'    => $godown->id,
                        'godown_name'  => $godown->name,
                        'location'     => $godown->location->name ?? 'N/A',
                        'quantity'     => $godown->pivot->quantity ?? 0,
                        'boxes'        => $godown->pivot->boxes ?? 0,
                    ];
                });

                // Image URL resolution
                $imageUrl = $product->primary_image
                    ? asset($product->primary_image)
                    : asset('images/default-product.png');

                return [
                    'product_id'     => $product->id,
                    'product_name'   => $product->name,
                    'product_code'   => $product->code ?? null,
                    'image'          => $imageUrl,
                    'total_quantity' => $locationsStock->sum('quantity'),
                    'locations'      => $locationsStock,
                ];
            });

            return response()->json([
                'success' => true,
                'count'   => $formattedProducts->count(),
                'data'    => $formattedProducts,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products stock list: ' . $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Get single product stock details by ID API
     * 
     * GET /api/products/{id}
     */
    public function getProductById(int $id)
    {
        try {
            $product = $this->productRepository->getProductStockLocations($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found with ID: ' . $id,
                ], 404);
            }

            // Map location and godown stock breakdown
            $locationsStock = $product->godowns->map(function ($godown) {
                return [
                    'godown_id'    => $godown->id,
                    'godown_name'  => $godown->name,
                    'location'     => $godown->location->name ?? 'N/A',
                    'quantity'     => $godown->pivot->quantity ?? 0,
                    'boxes'        => $godown->pivot->boxes ?? 0,
                ];
            });

            // Resolve full image URL or fallback image
            $imageUrl = $product->primary_image
                ? asset($product->primary_image)
                : asset('images/default-product.png');

            return response()->json([
                'success' => true,
                'data'    => [
                    'product_id'     => $product->id,
                    'product_name'   => $product->name,
                    'product_code'   => $product->code ?? null,
                    'image'          => $imageUrl,
                    'total_quantity' => $locationsStock->sum('quantity'),
                    'locations'      => $locationsStock,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product details: ' . $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Get paginated/filtered list of dealers created by the authenticated user.
     */
    public function dealersList(Request $request)
    {
        try {
            $user = $request->user() ?? Auth::user();

            if (!$user) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            $search   = $request->input('search');
            $userRole = strtolower($user->role ?? '');

            // -----------------------------------------------------------------
            // 1. Base Query
            // -----------------------------------------------------------------
            $query = User::select([
                'id',
                'name',
                'shop_name',
                'gst_number',
                'phone',
                'email',
                'address',
                'created_by',
                'created_at',
            ])->whereIn('role', ['dealer', 'Dealer']);

            // -----------------------------------------------------------------
            // 2. Role-Based Access Control
            // -----------------------------------------------------------------
            if (in_array($userRole, ['super_admin', 'superadmin', 'admin']) || !empty($user->is_admin)) {
                // Admin sees all dealers
            } elseif (in_array($userRole, ['staff', 'sales_person'])) {
                // Staff sees only their created dealers
                $query->where('created_by', $user->id);
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Unauthorized access.',
                ], 403);
            }

            // -----------------------------------------------------------------
            // 3. Search Filter
            // -----------------------------------------------------------------
            $query->when($search, function ($q, $search) {
                return $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('shop_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('gst_number', 'like', "%{$search}%");
                });
            });

            // Fetch all matching records without pagination
            $dealers = $query->latest()->get();

            return response()->json([
                'status'  => 'success',
                'message' => 'Dealers list retrieved successfully.',
                'total'   => $dealers->count(),
                'data'    => $dealers,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to fetch dealers list.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    // =========================================================================
    // API ENDPOINT (For Mobile App)
    // =========================================================================
    public function getActiveDailyOffer(Request $request)
    {
        try {
            // Fetch the latest active offer strictly where status = 1 (ignoring date)
            $offer = DailyOffer::where('status', 1)
                ->latest('id') // or ->latest('offer_date')
                ->first();

            // If status is 0 (or no active offer exists), return null
            if (!$offer) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'No active offer available.',
                    'data'    => null,
                ], 200);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Daily offer retrieved successfully.',
                'data'    => [
                    'id'         => $offer->id,
                    'title'      => $offer->title,
                    'image'      => asset('storage/' . $offer->image),
                    'status'     => (int) $offer->status,
                    'offer_date' => $offer->offer_date ? $offer->offer_date->format('Y-m-d') : null,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to fetch daily offer.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
