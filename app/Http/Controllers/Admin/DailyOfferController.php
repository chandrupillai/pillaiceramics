<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class DailyOfferController extends Controller
{
    // =========================================================================
    // 1. API ENDPOINT (For Mobile App)
    // =========================================================================
    public function getActiveDailyOffer(Request $request)
    {
        try {
            // Get today's active offer (status = 1)
            $today = now()->format('Y-m-d');

            $offer = DailyOffer::where('status', 1)
                ->whereDate('offer_date', '<=', $today)
                ->orderBy('offer_date', 'desc')
                ->first();

            if (!$offer) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'No active offer available today.',
                    'data'    => null,
                ], 200);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Daily offer retrieved successfully.',
                'data'    => [
                    'id'         => $offer->id,
                    'title'      => $offer->title,
                    'image'      => asset('storage/' . $offer->image),
                    'status'     => $offer->status,
                    'offer_date' => $offer->offer_date->format('Y-m-d'),
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to fetch daily offer.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // =========================================================================
    // 2. ADMIN PANEL (Blade View & CRUD)
    // =========================================================================
    public function index()
    {
        $offers = DailyOffer::latest('offer_date')->get();
        return view('admin.daily_offers.index', compact('offers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'offer_date' => 'required|date',
            'title'      => 'nullable|string|max:255',
        ]);

        try {
            $imagePath = $request->file('image')->store('daily_offers', 'public');

            // If new offer is set to active (1), optionally deactivate older active ones
            if ($request->has('status') && $request->status == 1) {
                DailyOffer::where('status', 1)->update(['status' => 0]);
            }

            DailyOffer::create([
                'title'      => $request->title,
                'image'      => $imagePath,
                'offer_date' => $request->offer_date,
                'status'     => $request->has('status') ? 1 : 0,
            ]);

            return back()->with('success', 'Daily offer added successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error creating offer: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $offer = DailyOffer::findOrFail($id);
        
        // If enabling this offer, turn off others to ensure only 1 is active
        if ($offer->status == 0) {
            DailyOffer::where('status', 1)->update(['status' => 0]);
            $offer->status = 1;
        } else {
            $offer->status = 0;
        }

        $offer->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status'  => $offer->status
        ]);
    }

    public function destroy($id)
    {
        $offer = DailyOffer::findOrFail($id);
        
        if (Storage::disk('public')->exists($offer->image)) {
            Storage::disk('public')->delete($offer->image);
        }

        $offer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Daily offer deleted successfully.'
        ]);
    }
}