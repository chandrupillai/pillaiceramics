<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class DealerController extends Controller
{
    /**
     * Add a new dealer from the mobile app with complete exception handling
     */
    public function store(Request $request)
    {
        try {
            // 1. Input Validation
            $validator = Validator::make($request->all(), [
                'name'         => 'required|string|max:255',
                'phone'        => 'required|string|max:20|unique:users,phone',
                'email'        => 'nullable|email|max:255|unique:users,email',
                'address'      => 'nullable|string|max:500',
                'company_name' => 'nullable|string|max:255',
                'gstin'        => 'nullable|string|max:15',
                'location_id'  => 'nullable|exists:locations,id',
                'password'     => 'nullable|string|min:6',
            ], [
                'phone.unique' => 'A user/dealer with this mobile number already exists.',
                'email.unique' => 'A user/dealer with this email address already exists.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors'  => $validator->errors()
                ], 422);
            }

            $currentUser = $request->user();

            // 2. Execute DB Operations inside a Transaction
            $dealer = DB::transaction(function () use ($request, $currentUser) {
                return User::create([
                    'name'         => trim($request->name),
                    'phone'        => trim($request->phone),
                    'email'        => $request->email ? trim($request->email) : null,
                    'address'      => $request->address ? trim($request->address) : null,
                    'company_name' => $request->company_name ? trim($request->company_name) : null,
                    'gstin'        => $request->gstin ? trim($request->gstin) : null,
                    'location_id'  => $request->location_id ?? $currentUser->location_id ?? null,
                    'role'         => 'dealer',
                    'created_by'   => $currentUser ? $currentUser->id : null,
                    'is_active'    => true,
                    'password'     => Hash::make($request->password ?? '12345678'),
                ]);
            });

            // Fallback for creator details if not available
            $createdByName = $currentUser->name ?? 'anandharaj';
            $createdByMobile = $currentUser->phone ?? '9444365536';

            return response()->json([
                'success' => true,
                'message' => 'Dealer added successfully.',
                'dealer'  => [
                    'id'                => $dealer->id,
                    'name'              => $dealer->name,
                    'phone'             => $dealer->phone,
                    'email'             => $dealer->email,
                    'address'           => $dealer->address,
                    'company_name'      => $dealer->company_name,
                    'gstin'             => $dealer->gstin,
                    'role'              => $dealer->role,
                    'created_by'        => $dealer->created_by,
                    'created_by_name'   => $createdByName,
                    'created_by_mobile' => $createdByMobile,
                ]
            ], 201);

        } catch (QueryException $e) {
            // Handle Database specific exceptions (e.g. key constraints, DB server down)
            Log::error('Database Error in Dealer Creation: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'A database error occurred while creating the dealer. Please try again.',
                'error_code' => $e->getCode()
            ], 500);

        } catch (\Throwable $e) {
            // Catch-all for any unexpected PHP errors or runtime exceptions
            Log::error('Unexpected Error in Dealer Creation: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong on the server. Please try again later.',
                'error'   => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }
}