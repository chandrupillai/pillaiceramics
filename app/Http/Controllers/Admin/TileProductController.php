<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TileProduct;
use App\Models\TileCategory;
use App\Models\TileType;
use App\Models\TileSize;
use App\Models\ProductType;
use App\Models\ProductionCompany;
use App\Models\Godown;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TileProductController extends Controller
{
    public function index()
    {
        $products = TileProduct::with(['category', 'type', 'size', 'productType', 'productionCompany', 'godown', 'location'])
            ->latest()
            ->paginate(15);

        return view('admin.tile_products.index', compact('products'));
    }

    public function create()
    {
        $categories          = TileCategory::where('is_active', true)->get();
        $types               = TileType::where('is_active', true)->get();
        $sizes               = TileSize::where('is_active', true)->get();
        $productTypes        = ProductType::where('is_active', true)->get();
        $productionCompanies = ProductionCompany::all();
        $godowns             = Godown::all();
        $locations           = Location::all();

        return view('admin.tile_products.create', compact(
            'categories', 'types', 'sizes', 'productTypes', 'productionCompanies', 'godowns', 'locations'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name'          => 'required|string|max:255',
            'sku'                   => 'required|string|unique:tile_products,sku',
            'description'           => 'nullable|string',
            'tile_category_id'      => 'required|exists:tile_categories,id',
            'tile_type_id'          => 'required|exists:tile_types,id',
            'tile_size_id'          => 'required|exists:tile_sizes,id',
            'product_type_id'       => 'required|exists:product_types,id',
            'price'                 => 'required|numeric|min:0',
            'stock_quantity'        => 'required|integer|min:0',
            'box_coverage_sqft'     => 'nullable|numeric|min:0',
            'pieces_per_box'        => 'nullable|integer|min:1',
            'production_company_id' => 'nullable|exists:production_companies,id',
            'godown_id'             => 'nullable|exists:godowns,id',
            'location_id'           => 'nullable|exists:locations,id',
            'image'                 => 'nullable|image|max:2048',
            'is_active'             => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tile_products', 'public');
        }

        TileProduct::create($validated);

        return redirect()->route('admin.tile-products.index')->with('success', 'Tile product created successfully.');
    }

    public function show($id)
    {
        $product = TileProduct::with(['category', 'type', 'size', 'productType', 'productionCompany', 'godown', 'location'])->findOrFail($id);
        
        return view('admin.tile_products.show', compact('product'));
    }

    public function edit($id)
    {
        $product             = TileProduct::findOrFail($id);
        $categories          = TileCategory::where('is_active', true)->get();
        $types               = TileType::where('is_active', true)->get();
        $sizes               = TileSize::where('is_active', true)->get();
        $productTypes        = ProductType::where('is_active', true)->get();
        $productionCompanies = ProductionCompany::all();
        $godowns             = Godown::all();
        $locations           = Location::all();

        return view('admin.tile_products.edit', compact(
            'product', 'categories', 'types', 'sizes', 'productTypes', 'productionCompanies', 'godowns', 'locations'
        ));
    }

    public function update(Request $request, $id)
    {
        $product = TileProduct::findOrFail($id);

        $validated = $request->validate([
            'product_name'          => 'required|string|max:255',
            'sku'                   => 'required|string|unique:tile_products,sku,' . $id,
            'description'           => 'nullable|string',
            'tile_category_id'      => 'required|exists:tile_categories,id',
            'tile_type_id'          => 'required|exists:tile_types,id',
            'tile_size_id'          => 'required|exists:tile_sizes,id',
            'product_type_id'       => 'required|exists:product_types,id',
            'price'                 => 'required|numeric|min:0',
            'stock_quantity'        => 'required|integer|min:0',
            'box_coverage_sqft'     => 'nullable|numeric|min:0',
            'pieces_per_box'        => 'nullable|integer|min:1',
            'production_company_id' => 'nullable|exists:production_companies,id',
            'godown_id'             => 'nullable|exists:godowns,id',
            'location_id'           => 'nullable|exists:locations,id',
            'image'                 => 'nullable|image|max:2048',
            'is_active'             => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('tile_products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.tile-products.index')->with('success', 'Tile product updated successfully.');
    }

    public function destroy($id)
    {
        $product = TileProduct::findOrFail($id);
        
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.tile-products.index')->with('success', 'Tile product deleted successfully.');
    }
    public function printAll()
    {
        $products = TileProduct::with(['category', 'type', 'size', 'productType', 'productionCompany', 'godown', 'location'])
            ->latest()
            ->get();

        return view('admin.tile_products.print-all', compact('products'));
    }
}