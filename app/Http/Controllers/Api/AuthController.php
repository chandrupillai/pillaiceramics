<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found with this mobile number.'
            ], 404);
        }

        // Optional: Check active status
        if (isset($user->is_active) && !$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Account is inactive. Please contact admin.'
            ], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        // Default creator details
        $createdByName = 'anandharaj';
        $createdByMobile = '9444365536';

        // Check created_by column and fetch the creator user
        if (!empty($user->created_by)) {
            $creator = User::find($user->created_by);
            if ($creator) {
                $createdByName = $creator->name ?? 'anandharaj';
                $createdByMobile = $creator->phone ?? $creator->mobile_number ?? '9444365536';
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => [
                'id'                => $user->id,
                'name'              => $user->name,
                'mobile_number'     => $user->phone,
                'role'              => $user->role,
                'location'          => $user->location_id,
                'created_by'        => $user->created_by,
                'created_by_name'   => $createdByName,
                'created_by_mobile' => $createdByMobile,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.'
        ]);
    }
}
