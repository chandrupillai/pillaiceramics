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

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => [
                'id'            => $user->id,
                'name'          => $user->name,
                'mobile_number' => $user->phone,
                'role'=> $user->role,
                'location'=>$user->location_id 
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