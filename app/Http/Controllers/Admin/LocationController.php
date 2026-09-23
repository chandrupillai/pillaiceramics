<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function index()
    {
        return view('admin.locations.index');
    }

    public function fetch(Request $request)
    {
        $locations = Location::latest()->get();

        return response()->json([
            'status' => true,
            'data'   => $locations,
        ]);
    }

    public function store(StoreLocationRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $location = Location::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Location created successfully.',
            'data'    => $location,
        ], 201);
    }

    public function show(Location $location)
    {
        return response()->json([
            'status' => true,
            'data'   => $location,
        ]);
    }

    public function update(UpdateLocationRequest $request, Location $location)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $location->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Location updated successfully.',
            'data'    => $location,
        ]);
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Location deleted successfully.',
        ]);
    }
}