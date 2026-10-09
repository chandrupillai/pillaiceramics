<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DealerEnquiry;
use App\Models\TileProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
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

            $userRole = strtolower($user->role ?? '');

            // -----------------------------------------------------------------
            // 1. Base Query with Grouping (1 Row Per Date + Dealer + Notes)
            // -----------------------------------------------------------------
            $query = DealerEnquiry::select(
                DB::raw('DATE(created_at) as enquiry_date'),
                'dealer_id',
                'notes',
                'status',
                DB::raw('MAX(created_at) as created_at'),
                DB::raw('GROUP_CONCAT(id) as enquiry_ids')
            );

            // -----------------------------------------------------------------
            // 2. Exact Role-Based Access Control Filtering
            // -----------------------------------------------------------------
            // Case A: Super Admin / Admin -> See ALL enquiries across all dealers
            if (in_array($userRole, ['super_admin', 'superadmin', 'admin']) || !empty($user->is_admin)) {
                // No dealer_id condition applied
            }
            // Case B: Staff -> See enquiries ONLY for dealers created by this staff member
            elseif ($userRole === 'staff') {
                $assignedDealerIds = User::where('created_by', $user->id)
                    ->pluck('id')
                    ->toArray();

                $query->whereIn('dealer_id', $assignedDealerIds);
            }
            // Case C: Dealer -> See ONLY their own enquiries
            else {
                $query->where('dealer_id', $user->id);
            }

            // Apply grouping criteria and retrieve paginated results
            $groupedEnquiries = $query->groupBy(DB::raw('DATE(created_at)'), 'dealer_id', 'notes', 'status')
                ->orderBy(DB::raw('MAX(created_at)'), 'desc')
                ->paginate($request->input('per_page', 10));

            // -----------------------------------------------------------------
            // 3. Eager-Load Full Relationships for Grouped Products & Dealer
            // -----------------------------------------------------------------
            $formattedData = collect($groupedEnquiries->items())->map(function ($group) {
                $enquiryIds = explode(',', $group->enquiry_ids);

                // Fetch individual enquiry records & associated nested product data
                $items = DealerEnquiry::with([
                    'dealer:id,name,phone',
                    'product:id,product_name,sku,price,image,tile_category_id,tile_type_id,tile_size_id',
                    'product.category:id,name',
                    'product.type:id,name',
                    'product.size:id,name',
                ])->whereIn('id', $enquiryIds)->get();

                $firstItem = $items->first();

                return [
                    'enquiry_date' => $group->enquiry_date,
                    'dealer_id'    => $group->dealer_id,
                    'dealer_name'  => $firstItem?->dealer?->name ?? 'N/A',
                    'dealer_phone' => $firstItem?->dealer?->phone ?? null,
                    'status'       => $group->status,
                    'notes'        => $group->notes,
                    'created_at'   => $group->created_at,
                    'total_items'  => $items->count(),
                    'products'     => $items->map(function ($item) {
                        return [
                            'enquiry_id'   => $item->id,
                            'product_id'   => $item->tile_product_id,
                            'quantity'     => $item->quantity,
                            'product_name' => $item->product?->product_name,
                            'sku'          => $item->product?->sku,
                            'price'        => $item->product?->price,
                            'image_url'    => $item->product?->image
                                ? asset('storage/' . $item->product->image)
                                : asset('images/default-product.png'),
                            'category'     => $item->product?->category?->name,
                            'type'         => $item->product?->type?->name,
                            'size'         => $item->product?->size?->name,
                        ];
                    }),
                ];
            });

            return response()->json([
                'success'    => true,
                'message'    => 'Enquiries retrieved successfully.',
                'role_type'  => $userRole ?: 'dealer',
                'data'       => $formattedData,
                'pagination' => [
                    'current_page' => $groupedEnquiries->currentPage(),
                    'last_page'    => $groupedEnquiries->lastPage(),
                    'per_page'     => $groupedEnquiries->perPage(),
                    'total'        => $groupedEnquiries->total(),
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch enquiries.',
                'error'   => [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ],
            ], 500);
        }
    }

    /**
     * Get grouped enquiries for admin listing (Optional / Additional API route support)
     */
    public function index()
    {
        try {
            // Group raw records by date, dealer, and notes to show in 1 row
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

            // Dynamically assign product models and ID list array
            $groupedRaw->getCollection()->transform(function ($item) {
                $productIds = !empty($item->product_ids) ? explode(',', $item->product_ids) : [];
                $item->products = TileProduct::whereIn('id', array_unique($productIds))->get();
                $item->enquiry_id_list = !empty($item->enquiry_ids) ? array_map('intval', explode(',', $item->enquiry_ids)) : [];
                return $item;
            });

            $enquiries = $groupedRaw;

            // Render Blade View instead of returning JSON
            return view('admin.dealer_enquiries.index', compact('enquiries'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load enquiries: ' . $e->getMessage());
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
