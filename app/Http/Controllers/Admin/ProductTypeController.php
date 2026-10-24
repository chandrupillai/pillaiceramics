<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductTypeController extends Controller
{
    public function index()
    {
        return view('admin.product-types.index');
    }

    public function fetch(Request $request)
    {
        $types = ProductType::latest()->get();

        return response()->json([
            'status' => true,
            'data'   => $types,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:product_types,name',
            'status'    => 'required|string|max:50',
            'flag'      => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $productType = ProductType::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Product type created successfully.',
            'data'    => $productType,
        ], 201);
    }

    public function show(ProductType $productType)
    {
        return response()->json([
            'status' => true,
            'data'   => $productType,
        ]);
    }

    public function update(Request $request, ProductType $productType)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:product_types,name,' . $productType->id,
            'status'    => 'required|string|max:50',
            'flag'      => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $productType->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Product type updated successfully.',
            'data'    => $productType,
        ]);
    }

    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product type deleted successfully.',
        ]);
    }
}