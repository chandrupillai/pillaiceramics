<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Location;
use Auth;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Load Single Page View
    public function index()
    {
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        return view('admin.users.index', compact('locations'));
    }

    // Fetch Paginated JSON Data (AJAX)
    public function fetch(Request $request): JsonResponse
    {
        $users = $this->userRepository->getFilteredUsers($request);
        return response()->json([
            'status' => true,
            'data' => $users
        ]);
    }

    // Store User via AJAX
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->createUser($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'User created successfully.',
            'data' => $user
        ], 201);
    }

    // Get Single User Details for Modal (AJAX)
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    // Update User via AJAX
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $updatedUser = $this->userRepository->updateUser($user, $request->validated());

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully.',
            'data' => $updatedUser
        ]);
    }

    // Delete User via AJAX
    public function destroy(User $user): JsonResponse
    {
        if (auth()->id() === $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot delete your own account.'
            ], 422);
        }

        $this->userRepository->deleteUser($user);

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully.'
        ]);
    }
    /**
     * Display a listing of staff members.
     */
    public function indexStaff(Request $request)
    {
        $user = Auth::user();
        $role = strtolower($user->role ?? '');
        $isAdmin = in_array($role, ['super_admin', 'superadmin', 'admin']) || !empty($user->is_admin);

        // Restrict access: Only admins can view the staff list
        if (!$isAdmin) {
            abort(403, 'Unauthorized access.');
        }

        $staff = User::whereIn('role', ['staff', 'Staff'])
            ->latest()
            ->paginate(10);

        return view('admin.staff.index', compact('staff'));
    }

    /**
     * Display a listing of dealers.
     */
    public function indexDealers(Request $request)
    {
        $user = Auth::user();
        $role = strtolower($user->role ?? '');
        $isAdmin = in_array($role, ['super_admin', 'superadmin', 'admin']) || !empty($user->is_admin);
        $isStaff = $role === 'staff';

        $query = User::whereIn('role', ['dealer', 'Dealer']);

        if ($isStaff) {
            // Staff sees only dealers they created
            $query->where('created_by', $user->id);
        } elseif (!$isAdmin) {
            abort(403, 'Unauthorized access.');
        }

        $dealers = $query->with('creator:id,name')
            ->latest()
            ->paginate(10);

        return view('admin.dealers.index', compact('dealers'));
    }
}
