<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StaffCustomerController extends Controller
{
    /**
     * Display a listing of dealers or customers.
     */
    public function index(Request $request, $type = null)
    {
        $type = $type ?? $request->route('type') ?? $request->get('type', 'customer');

        $query = User::where('role', $type);

        if (Auth::user()->role === 'staff') {
            $query->where('created_by', Auth::id());
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.staff.customers.index', compact('users', 'type'));
    }

    /**
     * Store a new dealer or customer via AJAX.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'phone' => 'required|digits_between:10,12|unique:users,phone',
            'email'         => 'nullable|email|unique:users,email',
            'role'          => 'required|in:dealer,customer',
            'address'       => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name'          => $request->name,
            'phone' => $request->phone,
            'email'         => $request->email,
            'role'          => $request->role,
            'address'       => $request->address,
            'created_by'    => Auth::id(),
            'password'      => bcrypt('12345678'),
            'shop_name'     => $request->shop_name,
            'gst_number'    => $request->gst_number,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => ucfirst($request->role) . ' created successfully!',
            'data'    => $user
        ], 200);
    }
    /**
     * Fetch user details for AJAX Edit Modal.
     */
    public function edit(User $user)
    {
        // Authorization check: Staff can only edit their created records
        if (Auth::user()->role === 'staff' && $user->created_by !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $user
        ]);
    }

    /**
     * Update user details via AJAX.
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->role === 'staff' && $user->created_by !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'shop_name'     => 'nullable|string|max:255',
            'gst_number'    => 'nullable|string|max:20',
            'phone' => 'required|digits_between:10,12|unique:users,phone,' . $user->id,
            'email'         => 'nullable|email|unique:users,email,' . $user->id,
            'address'       => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update([
            'name'          => $request->name,
            'shop_name'     => $request->shop_name,
            'gst_number'    => $request->gst_number,
            'phone' => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => ucfirst($user->role) . ' updated successfully!',
            'data'    => $user
        ]);
    }
}
