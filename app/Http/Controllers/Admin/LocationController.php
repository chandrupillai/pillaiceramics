<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        // Handle Banner Image Upload
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('locations', 'public');
        }

        // Handle Inner Page Image Upload
        if ($request->hasFile('inner_image')) {
            $validated['inner_image'] = $request->file('inner_image')->store('locations', 'public');
        }

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

        // Handle Banner Image Update
        if ($request->hasFile('banner')) {
            // Delete old banner if exists
            if ($location->banner && Storage::disk('public')->exists($location->banner)) {
                Storage::disk('public')->delete($location->banner);
            }
            $validated['banner'] = $request->file('banner')->store('locations', 'public');
        }

        // Handle Inner Page Image Update
        if ($request->hasFile('inner_image')) {
            // Delete old inner image if exists
            if ($location->inner_image && Storage::disk('public')->exists($location->inner_image)) {
                Storage::disk('public')->delete($location->inner_image);
            }
            $validated['inner_image'] = $request->file('inner_image')->store('locations', 'public');
        }

        $location->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Location updated successfully.',
            'data'    => $location,
        ]);
    }

    public function destroy(Location $location)
    {
        // Delete banner image file if exists
        if ($location->banner && Storage::disk('public')->exists($location->banner)) {
            Storage::disk('public')->delete($location->banner);
        }

        // Delete inner image file if exists
        if ($location->inner_image && Storage::disk('public')->exists($location->inner_image)) {
            Storage::disk('public')->delete($location->inner_image);
        }

        $location->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Location deleted successfully.',
        ]);
    }
}