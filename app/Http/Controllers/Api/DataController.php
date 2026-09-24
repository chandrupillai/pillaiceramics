<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Location;
use App\Models\TileCategory;
use App\Models\TileSize;
use App\Models\TileType;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

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
}