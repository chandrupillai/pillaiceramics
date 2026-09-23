<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TileSize;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TileSizeController extends Controller
{
    public function index()
    {
        $sizes = TileSize::latest()->get();
        return view('admin.tile_sizes.index', compact('sizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tile_sizes', 'name')],
            'width_mm' => 'nullable|numeric|min:0',
            'height_mm' => 'nullable|numeric|min:0',
            'unit' => 'required|string|in:mm,cm,inch,ft',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $size = TileSize::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'width_mm' => $validated['width_mm'] ?? null,
            'height_mm' => $validated['height_mm'] ?? null,
            'unit' => $validated['unit'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tile size created successfully.',
            'data' => $size,
        ]);
    }

    public function edit(TileSize $tileSize)
    {
        return response()->json([
            'success' => true,
            'data' => $tileSize,
        ]);
    }

    public function update(Request $request, TileSize $tileSize)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tile_sizes', 'name')->ignore($tileSize->id),
            ],
            'width_mm' => 'nullable|numeric|min:0',
            'height_mm' => 'nullable|numeric|min:0',
            'unit' => 'required|string|in:mm,cm,inch,ft',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $tileSize->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'width_mm' => $validated['width_mm'] ?? null,
            'height_mm' => $validated['height_mm'] ?? null,
            'unit' => $validated['unit'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tile size updated successfully.',
            'data' => $tileSize,
        ]);
    }

    public function destroy(TileSize $tileSize)
    {
        $tileSize->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tile size deleted successfully.',
        ]);
    }
}