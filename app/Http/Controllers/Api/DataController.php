<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Location;
use App\Models\User;

class DataController extends Controller
{
    // List Users
    public function users()
    {
        $users = User::select('id', 'name', 'mobile_number', 'is_active', 'created_at')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $users,
        ]);
    }

    // List Active Locations with Godowns Count
    public function locations()
    {
        $locations = Location::where('is_active', true)
            ->withCount('godowns')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $locations,
        ]);
    }

    // List Active Godowns with Location details
    public function godowns()
    {
        $godowns = Godown::with('location:id,name')
            ->where('is_active', true)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $godowns,
        ]);
    }
}