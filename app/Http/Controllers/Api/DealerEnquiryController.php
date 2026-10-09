<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DealerEnquiry;
use App\Models\TileProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class DealerEnquiryController extends Controller
{
    /**
     * Store new dealer enquiry (POST /enquiries)
     * Handles single or array of product IDs and prevents duplicate entries for the same day.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_ids'   => 'required|array|min:1',
                'product_ids.*' => 'required|exists:tile_products,id',
                'notes'         => 'nullable|string|max:500',
            ]);

            $dealerId  = Auth::id() ?? $request->user()?->id;
            $todayDate = Carbon::today()->toDateString();
            $createdEnquiries = [];

            foreach ($validated['product_ids'] as $productId) {
                // Find or create enquiry record
                $enquiry = DealerEnquiry::firstOrCreate(
                    [
                        'dealer_id'       => $dealerId,
                        'tile_product_id' => $productId,
                    ],
                    [
                        'quantity'   => null,
                        'notes'      => $request->input('notes'),
                        'status'     => 'pending',
                        'created_at' => now(),
                    ]
                );

                // If record existed from a prior date, create a new entry for today
                if (!$enquiry->wasRecentlyCreated && $enquiry->created_at->toDateString() !== $todayDate) {
                    $enquiry = DealerEnquiry::create([
                        'dealer_id'       => $dealerId,
                        'tile_product_id' => $productId,
                        'quantity'        => null,
                        'notes'           => $request->input('notes'),
                        'status'          => 'pending',
                    ]);
                }

                $createdEnquiries[] = $enquiry;
            }

            return response()->json([
                'success' => true,
                'message' => 'Enquiry submitted successfully.',
                'data'    => $createdEnquiries,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors'  => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit enquiry.',
                'error'   => [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine()
                ]
            ], 500);
        }
    }

    /**
     * Get authenticated dealer's submitted enquiry list (GET /my-enquiries)
     */
    public function myEnquiries(Request $request)
    {
        try {
            $user = $request->user() ?? Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            $query = DealerEnquiry::with([
                'dealer:id,name,phone',
                'product:id,product_name,sku,price,image,tile_category_id,tile_type_id,tile_size_id',
                'product.category:id,name',
                'product.type:id,name',
                'product.size:id,name'
            ]);

            // Normalize user role string
            $userRole = strtolower($user->role ?? '');

            // -----------------------------------------------------------------
            // Role-Based Enquiries Querying
            // -----------------------------------------------------------------

            // 1. Super Admin / Admin -> See ALL enquiries across all dealers
            if (in_array($userRole, ['super_admin', 'superadmin', 'admin']) || !empty($user->is_admin)) {
                // No filter applied - retrieves all records
            }
            // 2. Staff -> See enquiries for dealers assigned to this staff member
            elseif ($userRole === 'staff') {
                // Fetch dealer IDs linked to this staff member
                // Adjust column name ('staff_id' or 'assigned_staff_id') according to your schema
                $assignedDealerIds = \App\Models\User::where('staff_id', $user->id)
                    ->orWhere('assigned_staff_id', $user->id)
                    ->pluck('id')
                    ->toArray();

                $query->whereIn('dealer_id', $assignedDealerIds);
            }
            // 3. Dealer -> See ONLY their own enquiries
            else {
                $query->where('dealer_id', $user->id);
            }

            $enquiries = $query->latest()->paginate($request->input('per_page', 10));

            // Format a clean, non-bloated API response
            $formattedData = collect($enquiries->items())->map(function ($enquiry) {
                return [
                    'id'           => $enquiry->id,
                    'dealer_id'    => $enquiry->dealer_id,
                    'dealer_name'  => $enquiry->dealer?->name ?? 'N/A',
                    'dealer_phone' => $enquiry->dealer?->phone ?? null,
                    'status'       => $enquiry->status,
                    'quantity'     => $enquiry->quantity,
                    'notes'        => $enquiry->notes,
                    'created_at'   => $enquiry->created_at->toDateTimeString(),
                    'product_id'   => $enquiry->tile_product_id,
                    'product_name' => $enquiry->product?->product_name,
                    'sku'          => $enquiry->product?->sku,
                    'price'        => $enquiry->product?->price,
                    'image_url'    => $enquiry->product?->image
                        ? asset('storage/' . $enquiry->product->image)
                        : asset('images/default-product.png'),
                    'category'     => $enquiry->product?->category?->name,
                    'type'         => $enquiry->product?->type?->name,
                    'size'         => $enquiry->product?->size?->name,
                ];
            });

            return response()->json([
                'success'    => true,
                'message'    => 'Enquiries retrieved successfully.',
                'role_type'  => $userRole ?: 'dealer',
                'data'       => $formattedData,
                'pagination' => [
                    'current_page' => $enquiries->currentPage(),
                    'last_page'    => $enquiries->lastPage(),
                    'per_page'     => $enquiries->perPage(),
                    'total'        => $enquiries->total(),
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch enquiries.',
                'error'   => [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine()
                ]
            ], 500);
        }
    }

    /**
     * Get grouped enquiries for admin listing (Optional / Additional API route support)
     */
    public function index()
    {
        try {
            $groupedRaw = DealerEnquiry::select(
                DB::raw('DATE(created_at) as enquiry_date'),
                'dealer_id',
                'notes',
                'status',
                'updated_by',
                DB::raw('GROUP_CONCAT(id) as enquiry_ids'),
                DB::raw('GROUP_CONCAT(tile_product_id) as product_ids'),
                DB::raw('MAX(created_at) as created_at')
            )
                ->with(['dealer', 'updatedByStaff'])
                ->groupBy('enquiry_date', 'dealer_id', 'notes', 'status', 'updated_by')
                ->latest('created_at')
                ->paginate(15);

            $groupedRaw->getCollection()->transform(function ($item) {
                $productIds = !empty($item->product_ids) ? explode(',', $item->product_ids) : [];
                $item->products = TileProduct::whereIn('id', array_unique($productIds))->get();
                $item->enquiry_id_list = !empty($item->enquiry_ids) ? array_map('intval', explode(',', $item->enquiry_ids)) : [];
                return $item;
            });

            return response()->json([
                'success' => true,
                'message' => 'Grouped enquiries fetched successfully.',
                'data'    => $groupedRaw
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve enquiries.',
                'error'   => [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine()
                ]
            ], 500);
        }
    }

    /**
     * Group status update action
     */
    public function updateStatusGroup(Request $request)
    {
        try {
            $request->validate([
                'enquiry_ids'   => 'required|array',
                'enquiry_ids.*' => 'integer',
                'status'        => 'required|string',
            ]);

            $updatedCount = DealerEnquiry::whereIn('id', $request->enquiry_ids)->update([
                'status'     => $request->status,
                'updated_by' => Auth::id() ?? $request->user()?->id,
            ]);

            if ($updatedCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No matching enquiry records were found to update.'
                ], 404);
            }

            return response()->json([
                'success'       => true,
                'message'       => 'Group status updated successfully.',
                'updated_count' => $updatedCount
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors'  => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.',
                'error'   => [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine()
                ]
            ], 500);
        }
    }

    /**
     * Bulk deletion action
     */
    public function destroyGroup(Request $request)
    {
        try {
            $request->validate([
                'enquiry_ids'   => 'required|array',
                'enquiry_ids.*' => 'integer',
            ]);

            $deletedCount = DealerEnquiry::whereIn('id', $request->enquiry_ids)->delete();

            if ($deletedCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No records were found to delete.'
                ], 404);
            }

            return response()->json([
                'success'       => true,
                'message'       => "Deleted {$deletedCount} enquiry record(s) successfully.",
                'deleted_count' => $deletedCount
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors'  => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete group enquiries.',
                'error'   => [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine()
                ]
            ], 500);
        }
    }
}
