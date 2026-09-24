<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Location;
use App\Models\TileCategory;
use App\Models\TileProduct;
use App\Models\TileSize;
use App\Models\TileType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TileProductController extends Controller
{
    // Render the view or return JSON for AJAX requests
    public function index(Request $request)
    {
        try {
            $query = TileProduct::with(['category', 'type', 'size', 'location', 'godown']);

            // Filters
            if ($request->filled('category_id')) {
                $query->where('tile_category_id', $request->category_id);
            }
            if ($request->filled('type_id')) {
                $query->where('tile_type_id', $request->type_id);
            }
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            }

            $products = $query->latest()->paginate(10);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $products,
                ], 200);
            }

            // Load relational dropdowns for filters/forms
            $categories = TileCategory::where('is_active', true)->get();
            $types = TileType::where('is_active', true)->get();
            $sizes = TileSize::where('is_active', true)->get();
            $locations = Location::where('is_active', true)->get();
            $godowns = Godown::where('is_active', true)->get();

            return view('admin.tile_products.index', compact('products', 'categories', 'types', 'sizes', 'locations', 'godowns'));

        } catch (Exception $e) {
            Log::error('TileProductController@index Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to retrieve products.');
        }
    }

    public function create()
    {
        try {
            $categories = TileCategory::where('is_active', true)->get();
            $types = TileType::where('is_active', true)->get();
            $sizes = TileSize::where('is_active', true)->get();
            $locations = Location::where('is_active', true)->get();
            $godowns = Godown::where('is_active', true)->get();

            if (view()->exists('admin.tile_products.create')) {
                return view('admin.tile_products.create', compact('categories', 'types', 'sizes', 'locations', 'godowns'));
            }

            return redirect()->route('admin.tile-products.index', ['action' => 'create']);

        } catch (Exception $e) {  dd( $e->getMessage());
            Log::error('TileProductController@create Error: ' . $e->getMessage());
            return redirect()->route('admin.tile-products.index')->with('error', 'Failed to load create form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'sku' => 'required|string|max:100|unique:tile_products,sku',
                'tile_category_id' => 'required|exists:tile_categories,id',
                'tile_type_id' => 'required|exists:tile_types,id',
                'tile_size_id' => 'required|exists:tile_sizes,id',
                'location_id' => 'nullable|exists:locations,id',
                'godown_id' => 'nullable|exists:godowns,id',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'box_coverage_sqft' => 'nullable|string|max:50',
                'pieces_per_box' => 'nullable|integer|min:1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'description' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('tile_products', 'public');
            }

            $product = TileProduct::create([
                'product_name' => $validated['product_name'],
                'sku' => strtoupper($validated['sku']),
                'slug' => Str::slug($validated['product_name'] . '-' . $validated['sku']),
                'tile_category_id' => $validated['tile_category_id'],
                'tile_type_id' => $validated['tile_type_id'],
                'tile_size_id' => $validated['tile_size_id'],
                'location_id' => $validated['location_id'] ?? null,
                'godown_id' => $validated['godown_id'] ?? null,
                'price' => $validated['price'],
                'stock_quantity' => $validated['stock_quantity'],
                'box_coverage_sqft' => $validated['box_coverage_sqft'] ?? null,
                'pieces_per_box' => $validated['pieces_per_box'] ?? null,
                'image' => $imagePath,
                'description' => $validated['description'] ?? null,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product created successfully!',
                    'data' => $product
                ], 201);
            }

            return redirect()->route('admin.tile-products.index')->with('success', 'Product created successfully!');

        } catch (Exception $e) {
            Log::error('TileProductController@store Error: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create product.',
                    'error' => $e->getMessage()
                ], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function edit(TileProduct $tileProduct)
    {
        try {
            $categories = TileCategory::where('is_active', true)->get();
            $types = TileType::where('is_active', true)->get();
            $sizes = TileSize::where('is_active', true)->get();
            $locations = Location::where('is_active', true)->get();
            $godowns = Godown::where('is_active', true)->get();

            if (request()->ajax()) {
                $tileProduct->load(['category', 'type', 'size', 'location', 'godown']);
                return response()->json([
                    'success' => true,
                    'data' => $tileProduct,
                    'image_url' => $tileProduct->image ? asset('storage/' . $tileProduct->image) : null,
                ], 200);
            }

            if (view()->exists('admin.tile_products.edit')) {
                return view('admin.tile_products.edit', compact('tileProduct', 'categories', 'types', 'sizes', 'locations', 'godowns'));
            }

            return redirect()->route('admin.tile-products.index');

        } catch (Exception $e) {
            Log::error('TileProductController@edit Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load product details.');
        }
    }

    public function update(Request $request, TileProduct $tileProduct)
    {
        try {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'sku' => ['required', 'string', 'max:100', Rule::unique('tile_products', 'sku')->ignore($tileProduct->id)],
                'tile_category_id' => 'required|exists:tile_categories,id',
                'tile_type_id' => 'required|exists:tile_types,id',
                'tile_size_id' => 'required|exists:tile_sizes,id',
                'location_id' => 'nullable|exists:locations,id',
                'godown_id' => 'nullable|exists:godowns,id',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'box_coverage_sqft' => 'nullable|string|max:50',
                'pieces_per_box' => 'nullable|integer|min:1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'description' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            $imagePath = $tileProduct->image;
            if ($request->hasFile('image')) {
                if ($tileProduct->image && Storage::disk('public')->exists($tileProduct->image)) {
                    Storage::disk('public')->delete($tileProduct->image);
                }
                $imagePath = $request->file('image')->store('tile_products', 'public');
            }

            $tileProduct->update([
                'product_name' => $validated['product_name'],
                'sku' => strtoupper($validated['sku']),
                'slug' => Str::slug($validated['product_name'] . '-' . $validated['sku']),
                'tile_category_id' => $validated['tile_category_id'],
                'tile_type_id' => $validated['tile_type_id'],
                'tile_size_id' => $validated['tile_size_id'],
                'location_id' => $validated['location_id'] ?? null,
                'godown_id' => $validated['godown_id'] ?? null,
                'price' => $validated['price'],
                'stock_quantity' => $validated['stock_quantity'],
                'box_coverage_sqft' => $validated['box_coverage_sqft'] ?? null,
                'pieces_per_box' => $validated['pieces_per_box'] ?? null,
                'image' => $imagePath,
                'description' => $validated['description'] ?? null,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product updated successfully!',
                    'data' => $tileProduct
                ], 200);
            }

            return redirect()->route('admin.tile-products.index')->with('success', 'Product updated successfully!');

        } catch (Exception $e) {
            Log::error('TileProductController@update Error: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update product.',
                    'error' => $e->getMessage()
                ], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to update product.');
        }
    }

    public function destroy(TileProduct $tileProduct)
    {
        try {
            if ($tileProduct->image && Storage::disk('public')->exists($tileProduct->image)) {
                Storage::disk('public')->delete($tileProduct->image);
            }

            $tileProduct->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product deleted successfully!'
                ], 200);
            }

            return redirect()->route('admin.tile-products.index')->with('success', 'Product deleted successfully!');

        } catch (Exception $e) {
            Log::error('TileProductController@destroy Error: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete product.',
                    'error' => $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete product.');
        }
    }
}