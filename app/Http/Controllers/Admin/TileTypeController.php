<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TileType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TileTypeController extends Controller
{
    /**
     * Display a listing of tile types / finishes.
     */
    public function index()
    {
        $types = TileType::latest()->get();
        return view('admin.tile_types.index', compact('types'));
    }

    /**
     * Store a newly created tile type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tile_types,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $type = TileType::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tile type created successfully.',
            'data' => $type,
        ]);
    }

    /**
     * Show data for editing the specified tile type via AJAX.
     */
    public function edit(TileType $tileType)
    {
        return response()->json([
            'success' => true,
            'data' => $tileType,
        ]);
    }

    /**
     * Update the specified tile type in storage.
     */
    public function update(Request $request, TileType $tileType)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tile_types', 'name')->ignore($tileType->id),
            ],
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $tileType->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tile type updated successfully.',
            'data' => $tileType,
        ]);
    }

    /**
     * Remove the specified tile type from storage.
     */
    public function destroy(TileType $tileType)
    {
        $tileType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tile type deleted successfully.',
        ]);
    }
}