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
        $search = $request->get('search');

        $query = DailySale::with(['salesPerson', 'productType', 'product'])
            ->when($search, function ($q, $s) {
                $q->where('bill_shop_name', 'LIKE', "%{$s}%")
                    ->orWhere('vehicle_info', 'LIKE', "%{$s}%")
                    ->orWhereHas('product', function ($sub) use ($s) {
                        $sub->where('product_name', 'LIKE', "%{$s}%");
                    });
            });

        // Paginate results so pagination links and metadata are generated
        $sales = $query->latest('sale_date')->paginate(10);

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
            'unit_price'      => 'required|numeric|min:0',
            'gst_amount'      => 'nullable|numeric|min:0',
            'total_amount'    => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {
            $product = TileProduct::lockForUpdate()->find($validated['product_id']);
            if ($product && $product->tile_size_id) {
                $validated['tile_size_id'] = $product->tile_size_id;
            }

            if ($product) {
                if ($product->stock_quantity < $validated['quantity']) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Insufficient stock available. Current stock: ' . $product->stock_quantity
                    ], 422);
                }
                
                // Directly decrement stock on database
                DB::table('tile_products')
                    ->where('id', $validated['product_id'])
                    ->decrement('stock_quantity', $validated['quantity']);
            }

            $sale = DailySale::create($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Daily sale recorded successfully and stock updated.',
                'data'    => $sale->load(['salesPerson', 'productType', 'product']),
            ], 201);
        });
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
            'unit_price'      => 'required|numeric|min:0',
            'gst_amount'      => 'nullable|numeric|min:0',
            'total_amount'    => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request, $sale, $validated) {
            $oldProductId = $sale->product_id;
            $oldQuantity = $sale->quantity;

            $product = TileProduct::lockForUpdate()->find($validated['product_id']);
            if ($product && $product->tile_size_id) {
                $validated['tile_size_id'] = $product->tile_size_id;
            }

            // Revert old stock if product or quantity changed
            if ($oldProductId == $validated['product_id']) {
                $diff = $validated['quantity'] - $oldQuantity; // positive means more stock taken
                if ($product->stock_quantity < $diff) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Insufficient stock available for update. Current stock: ' . $product->stock_quantity
                    ], 422);
                }
                
                DB::table('tile_products')
                    ->where('id', $validated['product_id'])
                    ->decrement('stock_quantity', $diff);
            } else {
                // Return stock to old product
                DB::table('tile_products')
                    ->where('id', $oldProductId)
                    ->increment('stock_quantity', $oldQuantity);

                // Deduct from new product
                if ($product->stock_quantity < $validated['quantity']) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Insufficient stock available. Current stock: ' . $product->stock_quantity
                    ], 422);
                }
                
                DB::table('tile_products')
                    ->where('id', $validated['product_id'])
                    ->decrement('stock_quantity', $validated['quantity']);
            }

            $sale->update($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Daily sale updated successfully and stock adjusted.',
                'data'    => $sale->load(['salesPerson', 'productType', 'product']),
            ]);
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $sale = DailySale::findOrFail($id);
            
            // Return stock back upon deletion using direct increment
            DB::table('tile_products')
                ->where('id', $sale->product_id)
                ->increment('stock_quantity', $sale->quantity);

            $sale->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Sale record deleted and stock restored successfully.',
            ]);
        });
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

    // ==========================================
    // WHOLE SALES METHODS (Restored & Updated)
    // ==========================================

    public function wholeSalesIndex()
    {
        return view('admin.sales.wholesale-index');
    }

    public function wholeSalesFetch(Request $request)
    {
        $sales = DailySale::with(['salesPerson', 'productType', 'product'])
            ->select(
                'bill_shop_name', 
                'sale_date', 
                'user_id', 
                \DB::raw('COUNT(*) as total_items'), 
                \DB::raw('SUM(quantity) as total_quantity'), 
                \DB::raw('SUM(total_amount) as total_invoice_amount'),
                \DB::raw('MIN(id) as id')
            )
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
            'items.*.unit_price'      => 'required|numeric|min:0',
            'items.*.gst_amount'      => 'nullable|numeric|min:0',
            'items.*.total_amount'    => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {
            foreach ($validated['items'] as $item) {
                $product = TileProduct::lockForUpdate()->find($item['product_id']);

                if ($product) {
                    if ($product->stock_quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for product: {$product->product_name}. Available: {$product->stock_quantity}");
                    }
                    
                    DB::table('tile_products')
                        ->where('id', $item['product_id'])
                        ->decrement('stock_quantity', $item['quantity']);
                }

                DailySale::create([
                    'user_id'         => $validated['user_id'],
                    'sale_date'       => $validated['sale_date'],
                    'bill_shop_name'  => $validated['bill_shop_name'],
                    'vehicle_info'    => $validated['vehicle_info'] ?? null,
                    'product_type_id' => $item['product_type_id'],
                    'product_id'      => $item['product_id'],
                    'quantity'        => $item['quantity'],
                    'unit_price'      => $item['unit_price'],
                    'gst_amount'      => $item['gst_amount'] ?? 0,
                    'total_amount'    => $item['total_amount'],
                    'tile_size_id'    => $product->tile_size_id ?? null,
                ]);
            }

            return response()->json([
                'status'   => true,
                'message'  => 'Whole sales batch recorded successfully and stock updated.',
                'redirect' => route('admin.whole-sales.index'),
            ], 201);
        });
    }

    public function wholeSalesDestroyGroup(Request $request, $billShopName)
    {
        return DB::transaction(function () use ($request, $billShopName) {
            $date = $request->get('date');
            $query = DailySale::where('bill_shop_name', $billShopName);
            if ($date) {
                $query->where('sale_date', $date);
            }
            $sales = $query->get();

            foreach ($sales as $sale) {
                DB::table('tile_products')
                    ->where('id', $sale->product_id)
                    ->increment('stock_quantity', $sale->quantity);

                $sale->delete();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Whole sale invoice records deleted and stock restored successfully.',
            ]);
        });
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
            'items.*.unit_price'      => 'required|numeric|min:0',
            'items.*.gst_amount'      => 'nullable|numeric|min:0',
            'items.*.total_amount'    => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request, $oldDate, $billShopName, $validated) {
            $existingSales = DailySale::where('bill_shop_name', $billShopName)
                ->when($oldDate, fn($q) => $q->where('sale_date', $oldDate))
                ->get();

            // Revert stock for existing items before updating
            foreach ($existingSales as $sale) {
                DB::table('tile_products')
                    ->where('id', $sale->product_id)
                    ->increment('stock_quantity', $sale->quantity);

                $sale->delete();
            }

            // Create new items and deduct stock
            foreach ($validated['items'] as $item) {
                $product = TileProduct::lockForUpdate()->find($item['product_id']);

                if ($product) {
                    if ($product->stock_quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for product: {$product->product_name}. Available: {$product->stock_quantity}");
                    }
                    
                    DB::table('tile_products')
                        ->where('id', $item['product_id'])
                        ->decrement('stock_quantity', $item['quantity']);
                }

                DailySale::create([
                    'user_id'         => $validated['user_id'],
                    'sale_date'       => $validated['sale_date'],
                    'bill_shop_name'  => $validated['bill_shop_name'],
                    'vehicle_info'    => $validated['vehicle_info'] ?? null,
                    'product_type_id' => $item['product_type_id'],
                    'product_id'      => $item['product_id'],
                    'quantity'        => $item['quantity'],
                    'unit_price'      => $item['unit_price'],
                    'gst_amount'      => $item['gst_amount'] ?? 0,
                    'total_amount'    => $item['total_amount'],
                    'tile_size_id'    => $product->tile_size_id ?? null,
                ]);
            }

            return response()->json([
                'status'   => true,
                'message'  => 'Whole sale invoice updated successfully and stock adjusted.',
                'redirect' => route('admin.whole-sales.index'),
            ]);
        });
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
        $search = $request->get('search');

        $query = DailySale::with(['salesPerson', 'productType', 'product'])
            ->when($request->get('user_id'), function ($q, $userId) {
                $q->where('user_id', $userId);
            })
            ->when($request->get('month'), function ($q, $month) {
                $dateParts = explode('-', $month);
                if (count($dateParts) === 2) {
                    $q->whereYear('sale_date', $dateParts[0])
                        ->whereMonth('sale_date', $dateParts[1]);
                }
            })
            ->when($request->get('product_id'), function ($q, $productId) {
                $q->where('product_id', $productId);
            })
            ->when($search, function ($q, $s) {
                $q->where(function ($sub) use ($s) {
                    $sub->where('bill_shop_name', 'LIKE', "%{$s}%")
                        ->orWhere('vehicle_info', 'LIKE', "%{$s}%");
                });
            });

        // Use get() instead of paginate() so the response format matches the report view expectations
        $sales = $query->latest('sale_date')->get();

        $totalQuantity = $sales->sum('quantity');
        $totalTransactions = $sales->count();

        return response()->json([
            'status' => true,
            'summary' => [
                'total_quantity'     => number_format($totalQuantity, 2),
                'total_transactions' => $totalTransactions,
            ],
            'data'   => $sales,
        ]);
    }
}