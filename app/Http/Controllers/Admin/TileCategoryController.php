<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TileCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TileCategoryController extends Controller
{
    /**
     * Display a listing of tile categories.
     */
    public function index()
    {
        $categories = TileCategory::latest()->get();
        return view('admin.tile_categories.index', compact('categories'));
    }

    /**
     * Store a newly created tile category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tile_categories,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $category = TileCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tile category created successfully.',
            'data' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified tile category via AJAX.
     */
    public function edit(TileCategory $tileCategory)
    {
        return response()->json([
            'success' => true,
            'data' => $tileCategory,
        ]);
    }

    /**
     * Update the specified tile category in storage.
     */
    public function update(Request $request, TileCategory $tileCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tile_categories', 'name')->ignore($tileCategory->id),
            ],
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $tileCategory->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tile category updated successfully.',
            'data' => $tileCategory,
        ]);
    }

    /**
     * Remove the specified tile category from storage.
     */
    public function destroy(TileCategory $tileCategory)
    {
        $tileCategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tile category deleted successfully.',
        ]);
    }
}