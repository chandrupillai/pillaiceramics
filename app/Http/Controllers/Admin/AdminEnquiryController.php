<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealerEnquiry;
use Illuminate\Http\Request;
use Exception;

class AdminEnquiryController extends Controller
{
    /**
     * List all dealer enquiries for Admin / Staff.
     */
    public function index(Request $request)
    {
        try {
            $query = DealerEnquiry::with(['dealer', 'product', 'updatedByStaff']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('dealer_id')) {
                $query->where('dealer_id', $request->dealer_id);
            }

            $enquiries = $query->latest()->paginate(15);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'data' => $enquiries]);
            }

            return view('admin.enquiries.index', compact('enquiries'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve enquiries.');
        }
    }

    /**
     * Update Enquiry Status by Staff.
     */
    public function updateStatus(Request $request, DealerEnquiry $enquiry)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,processing,completed,cancelled',
            ]);

            $enquiry->update([
                'status' => $validated['status'],
                'updated_by' => auth()->id(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Enquiry status updated successfully.',
                    'data' => $enquiry
                ]);
            }

            return redirect()->back()->with('success', 'Enquiry status updated to ' . $validated['status']);

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return redirect()->back()->with('error', 'Failed to update status.');
        }
    }
}