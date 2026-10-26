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
    public function wholeSalesIndex()
    {
        return view('admin.sales.wholesale-index');
    }

    public function wholeSalesFetch(Request $request)
    {
        // Group sales by bill_shop_name and sale_date for invoice-level summaries
        $sales = DailySale::with(['salesPerson', 'productType', 'product'])
            ->select('bill_shop_name', 'sale_date', 'user_id', \DB::raw('COUNT(*) as total_items'), \DB::raw('SUM(quantity) as total_quantity'), \DB::raw('MIN(id) as id'))
            ->groupBy('bill_shop_name', 'sale_date', 'user_id')
            ->latest('sale_date')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $sales,
        ]);
    }

    public function wholeSalesCreate()
    {
        $staffMembers = User::whereIn('role', ['staff'])->get();
        $productTypes = \App\Models\ProductType::where('is_active', true)->get();
        return view('admin.sales.wholesale-create', compact('staffMembers', 'productTypes'));
    }

    public function wholeSalesStore(Request $request)
    {
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'sale_date'       => 'required|date',
            'bill_shop_name'  => 'required|string|max:255',
            'vehicle_info'    => 'nullable|string|max:255',
            'items'           => 'required|array|min:1|max:25',
            'items.*.product_type_id' => 'required|exists:product_types,id',
            'items.*.product_id'      => 'required|exists:tile_products,id',
            'items.*.quantity'        => 'required|numeric|min:0.01',
        ]);

        foreach ($validated['items'] as $item) {
            $product = TileProduct::find($item['product_id']);

            DailySale::create([
                'user_id'         => $validated['user_id'],
                'sale_date'       => $validated['sale_date'],
                'bill_shop_name'  => $validated['bill_shop_name'],
                'vehicle_info'    => $validated['vehicle_info'] ?? null,
                'product_type_id' => $item['product_type_id'],
                'product_id'      => $item['product_id'],
                'quantity'        => $item['quantity'],
                'tile_size_id'    => $product->tile_size_id ?? null,
            ]);
        }

        return response()->json([
            'status'   => true,
            'message'  => 'Whole sales batch recorded successfully.',
            'redirect' => route('admin.whole-sales.index'),
        ], 201);
    }

    public function wholeSalesDestroyGroup(Request $request, $billShopName)
    {
        // Delete all rows matching this bill shop name and date
        $date = $request->get('date');
        $query = DailySale::where('bill_shop_name', $billShopName);
        if ($date) {
            $query->where('sale_date', $date);
        }
        $query->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Whole sale invoice records deleted successfully.',
        ]);
    }

    public function wholeSalesShow(Request $request, $billShopName)
    {
        $date = $request->get('date');
        $sales = DailySale::with(['salesPerson', 'productType', 'product.size'])
            ->where('bill_shop_name', $billShopName)
            ->when($date, fn($q) => $q->where('sale_date', $date))
            ->get();

        if ($sales->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Invoice not found.'], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => [
                'bill_shop_name' => $billShopName,
                'sale_date'      => $sales->first()->sale_date,
                'sales_person'   => $sales->first()->salesPerson->name ?? 'N/A',
                'vehicle_info'   => $sales->first()->vehicle_info ?? 'N/A',
                'items'          => $sales
            ]
        ]);
    }

    public function wholeSalesEdit(Request $request, $billShopName)
    {
        $date = $request->get('date');
        $sales = DailySale::with(['product', 'productType'])
            ->where('bill_shop_name', $billShopName)
            ->when($date, fn($q) => $q->where('sale_date', $date))
            ->get();

        if ($sales->isEmpty()) {
            abort(404, 'Invoice not found.');
        }

        $staffMembers = User::whereIn('role', ['staff'])->get();
        $productTypes = \App\Models\ProductType::where('is_active', true)->get();

        return view('admin.sales.wholesale-edit', compact('sales', 'billShopName', 'date', 'staffMembers', 'productTypes'));
    }

    public function wholeSalesUpdate(Request $request, $billShopName)
    {
        $oldDate = $request->get('old_date');

        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'sale_date'       => 'required|date',
            'bill_shop_name'  => 'required|string|max:255',
            'vehicle_info'    => 'nullable|string|max:255',
            'items'           => 'required|array|min:1|max:25',
            'items.*.product_type_id' => 'required|exists:product_types,id',
            'items.*.product_id'      => 'required|exists:tile_products,id',
            'items.*.quantity'        => 'required|numeric|min:0.01',
        ]);

        // 1. Delete existing records for this invoice group
        DailySale::where('bill_shop_name', $billShopName)
            ->when($oldDate, fn($q) => $q->where('sale_date', $oldDate))
            ->delete();

        // 2. Re-create the updated batch items
        foreach ($validated['items'] as $item) {
            $product = TileProduct::find($item['product_id']);

            DailySale::create([
                'user_id'         => $validated['user_id'],
                'sale_date'       => $validated['sale_date'],
                'bill_shop_name'  => $validated['bill_shop_name'],
                'vehicle_info'    => $validated['vehicle_info'] ?? null,
                'product_type_id' => $item['product_type_id'],
                'product_id'      => $item['product_id'],
                'quantity'        => $item['quantity'],
                'tile_size_id'    => $product->tile_size_id ?? null,
            ]);
        }

        return response()->json([
            'status'   => true,
            'message'  => 'Whole sale invoice updated successfully.',
            'redirect' => route('admin.whole-sales.index'),
        ]);
    }
}
