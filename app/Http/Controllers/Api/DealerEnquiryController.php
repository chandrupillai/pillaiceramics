<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DealerEnquiry;
use App\Models\TileProduct;
use Illuminate\Http\Request;
use Exception;

class DealerEnquiryController extends Controller
{
    /**
     * Submit single or multiple tile products as an enquiry from the dealer app.
     */
    public function store(Request $request)
    {
        try {
            // Validate array of tile product IDs sent from local storage
            $validated = $request->validate([
                'product_ids'   => 'required|array|min:1',
                'product_ids.*' => 'required|exists:tile_products,id',
                'notes'         => 'nullable|string|max:500',
            ]);

            $dealerId = auth()->id();
            $enquiries = [];

            foreach ($validated['product_ids'] as $productId) {
                $enquiries[] = DealerEnquiry::create([
                    'dealer_id'       => $dealerId,
                    'tile_product_id' => $productId,
                    'quantity'        => null, // Staff/Admin can assign quantity later
                    'notes'           => $request->input('notes'),
                    'status'          => 'pending',
                ]);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Wishlist enquiry submitted successfully.',
                'data'    => $enquiries,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation error.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to submit enquiry.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get dealer's own submitted enquiries history.
     */
    public function myEnquiries(Request $request)
    {
        try {
            $enquiries = DealerEnquiry::with(['product.category', 'product.type', 'product.size'])
                ->where('dealer_id', auth()->id())
                ->latest()
                ->paginate($request->input('per_page', 10));

            return response()->json([
                'status' => 'success',
                'data' => $enquiries->items(),
                'pagination' => [
                    'current_page' => $enquiries->currentPage(),
                    'last_page' => $enquiries->lastPage(),
                    'total' => $enquiries->total(),
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch enquiries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
