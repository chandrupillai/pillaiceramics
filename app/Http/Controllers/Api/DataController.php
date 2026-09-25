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
            $users = User::select('id', 'name', 'mobile_number', 'is_active', 'created_at')
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
    public function products(Request $request)
    {
        try {
            $query = TileProduct::with([
                'category:id,name',
                'type:id,name',
                'size:id,name,width_mm,height_mm,unit',
                'location:id,name',
                'godown:id,name'
            ])->where('is_active', true);

            // Filter by ID or comma-separated IDs (e.g., ?id=1 or ?id=1,2,3)
            if ($request->filled('id') || $request->filled('product_id')) {
                $idInput = $request->input('id') ?? $request->input('product_id');
                $ids = is_array($idInput) ? $idInput : explode(',', $idInput);
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
                // Updated to fetch directly from public/images/ asset path
                $imageUrl = $product->image
                    ? asset($product->image)
                    : asset('images/default-product.png');

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
                ];
            });

            // Return 404 if specific ID was searched but not found
            if ($products->isEmpty() && ($request->filled('id') || $request->filled('product_id'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products found matching the requested ID.',
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
}
