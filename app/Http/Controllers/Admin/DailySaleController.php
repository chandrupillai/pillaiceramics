<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailySale;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TileProduct;
use DB;

class DailySaleController extends Controller
{
    public function index()
    {
        $staffMembers = User::whereIn('role', ['staff'])->get();
        return view('admin.sales.index', compact('staffMembers'));
    }

    public function fetch(Request $request)
    {
        $sales = DailySale::with(['salesPerson', 'productType', 'product'])->latest()->get();

        return response()->json([
            'status' => true,
            'data'   => $sales,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'product_type_id' => 'required|exists:product_types,id',
            'product_id'      => 'required|exists:tile_products,id',
            'sale_date'       => 'required|date',
            'quantity'        => 'required|numeric|min:0.01',
            'bill_shop_name'  => 'required|string|max:255',
            'vehicle_info'    => 'nullable|string|max:255',
        ]);

        // Automatically fetch and attach the tile_size_id from the selected product if available
        $product = TileProduct::find($validated['product_id']);
        if ($product && $product->tile_size_id) {
            $validated['tile_size_id'] = $product->tile_size_id;
        }

        $sale = DailySale::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Daily sale recorded successfully.',
            'data'    => $sale->load(['salesPerson', 'productType', 'product']),
        ], 201);
    }

    public function show($id)
    {
        $sale = DailySale::with(['salesPerson', 'productType', 'product.size'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $sale,
        ]);
    }

    public function edit($id)
    {
        $sale = DailySale::with(['salesPerson', 'productType', 'product'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $sale,
        ]);
    }

    public function update(Request $request, $id)
    {
        $sale = DailySale::findOrFail($id);

        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'product_type_id' => 'required|exists:product_types,id',
            'product_id'      => 'required|exists:tile_products,id',
            'sale_date'       => 'required|date',
            'quantity'        => 'required|numeric|min:0.01',
            'bill_shop_name'  => 'required|string|max:255',
            'vehicle_info'    => 'nullable|string|max:255',
        ]);

        $product = TileProduct::find($validated['product_id']);
        if ($product && $product->tile_size_id) {
            $validated['tile_size_id'] = $product->tile_size_id;
        }

        $sale->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Daily sale updated successfully.',
            'data'    => $sale->load(['salesPerson', 'productType', 'product']),
        ]);
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
        $productTypeId = $request->get('product_type_id');

        $productsQuery = DB::table('tile_products')
            ->leftJoin('tile_sizes', 'tile_products.tile_size_id', '=', 'tile_sizes.id')
            ->select(
                'tile_products.id',
                'tile_products.product_name',
                'tile_products.sku',
                'tile_sizes.name as size'
            );

        if ($productTypeId) {
            $productsQuery->where('tile_products.product_type_id', $productTypeId);
        }

        if ($query) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('tile_products.product_name', 'LIKE', "%{$query}%")
                    ->orWhere('tile_products.sku', 'LIKE', "%{$query}%")
                    ->orWhere('tile_sizes.name', 'LIKE', "%{$query}%");
            });
        }

        $products = $productsQuery->get();

        return response()->json([
            'status' => true,
            'data'   => $products,
        ]);
    }

    public function reports()
    {
        $staffMembers = User::whereIn('role', ['staff'])->get();
        $products = TileProduct::select('id', 'product_name')->get();
        $productTypes = \App\Models\ProductType::where('is_active', true)->get();

        return view('admin.sales.reports', compact('staffMembers', 'products', 'productTypes'));
    }

    public function fetchReports(Request $request)
    {
        $query = DailySale::with(['salesPerson', 'productType', 'product.size']);

        // 1. Staff Wise Filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // 2. Month / Date Range Filter (Format expected: YYYY-MM or YYYY-MM-DD)
        if ($request->filled('month')) {
            $dateParts = explode('-', $request->month); // e.g. [2026, 10]
            if (count($dateParts) === 2) {
                $query->whereYear('sale_date', $dateParts[0])
                    ->whereMonth('sale_date', $dateParts[1]);
            }
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('sale_date', [$request->start_date, $request->end_date]);
        }

        // 3. Product Wise Filter
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // 4. Product Type Filter (Secondary option)
        if ($request->filled('product_type_id')) {
            $query->where('product_type_id', $request->product_type_id);
        }

        $sales = $query->latest('sale_date')->get();

        // Calculate summary metrics
        $totalQuantity = $sales->sum('quantity');
        $totalTransactions = $sales->count();

        return response()->json([
            'status' => true,
            'summary' => [
                'total_quantity' => number_format($totalQuantity, 2),
                'total_transactions' => $totalTransactions,
            ],
            'data'   => $sales,
        ]);
    }
}
