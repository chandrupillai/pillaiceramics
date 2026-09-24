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

class DataController extends Controller
{
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

            // Optional filtering by category, type, or size
            if ($request->has('category_id')) {
                $query->where('tile_category_id', $request->category_id);
            }
            if ($request->has('type_id')) {
                $query->where('tile_type_id', $request->type_id);
            }
            if ($request->has('size_id')) {
                $query->where('tile_size_id', $request->size_id);
            }

            $products = $query->latest()->get()->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'stock_quantity' => $product->stock_quantity,
                    'box_coverage_sqft' => $product->box_coverage_sqft,
                    'pieces_per_box' => $product->pieces_per_box,
                    'image_url' => $product->image ? asset('storage/' . $product->image) : null,
                    'category' => $product->category ? $product->category->name : null,
                    'type' => $product->type ? $product->type->name : null,
                    'size' => $product->size ? $product->size->name : null,
                    'location' => $product->location ? $product->location->name : null,
                    'godown' => $product->godown ? $product->godown->name : null,
                    'description' => $product->description,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $products,
            ], 200);
        } catch (Exception $e) {
            Log::error('DataController@products Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // List Active Godowns with Location details
    public function company()
    {
        $companyDetails = [
            'name' => 'Pillai Ceramics',
            'logo' => asset('images/logo.png'), // Resolves to http://your-domain.com/images/logo.png
        ];

        return response()->json([
            'success' => true,
            'data'    => $companyDetails,
        ], 200);
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
}
