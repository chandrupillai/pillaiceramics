<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailySale;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TileProduct;

class DailySaleController extends Controller
{
    public function index()
    {
        $staffMembers = User::whereIn('role', ['admin', 'staff', 'super_admin'])->get();
        return view('admin.sales.index', compact('staffMembers'));
    }

    public function fetch(Request $request)
    {
        $sales = DailySale::with('salesPerson')->latest()->get();

        return response()->json([
            'status' => true,
            'data'   => $sales,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'product_id'     => 'required|string|max:255',
            'sale_date'      => 'required|date',
            'quantity'       => 'required|numeric|min:0.01',
            'bill_shop_name' => 'required|string|max:255',
            'vehicle_info'   => 'nullable|string|max:255',
        ]);

        $sale = DailySale::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Daily sale recorded successfully.',
            'data'    => $sale->load('salesPerson'),
        ], 201);
    }

    public function destroy($id)
    {
        $sale = DailySale::findOrFail($id);
        $sale->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Sale record deleted successfully.',
        ]);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('q');
        
        // Search by both product name and size
        $products = TileProduct::where('product_name', 'LIKE', "%{$query}%")
            ->orWhere('size', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'product_name', 'size', 'tile_type_id as product_type']);

        return response()->json([
            'status' => true,
            'data'   => $products,
        ]);
    }
}