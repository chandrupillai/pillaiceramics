<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Location;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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

    // List Active Godowns with Location details
    public function company()
    {
        $companyDetails = [
        'name' => 'Pillai Ceramics',
        'logo' => asset('images/logo.png'), // Resolves to http://your-domain.com/images/logo.png
    ];

    return response()->json([
        'success' => true,
        'data'    => $companyDetails,
    ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user(); // Get logged-in user via Auth token

        // Validate incoming request
        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
        ]);

        // Fill and save updated user data
        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data'    => $user->only(['id', 'name', 'email', 'phone', 'bio']),
        ], 200);
    }
}