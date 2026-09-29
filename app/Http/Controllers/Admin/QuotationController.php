<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\TileProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = Quotation::with(['dealer', 'creator']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('quotation_no', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $quotations = $query->latest()->paginate(15);
        return view('admin.quotations.index', compact('quotations'));
    }

    public function create()
    {
        $products = TileProduct::where('is_active', true)->get();
        $dealers = User::where('role', 'dealer')->get(); // Adjust role column to match your schema
        return view('admin.quotations.create', compact('products', 'dealers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string',
            'dealer_id' => 'nullable|exists:users,id',
            'valid_until' => 'nullable|date',
            'discount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.tile_product_id' => 'required|exists:tile_products,id',
            'items.*.boxes' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate Quotation Number
            $nextId = Quotation::max('id') + 1;
            $quotationNo = 'QT-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $subtotal = 0;

            $quotation = Quotation::create([
                'quotation_no' => $quotationNo,
                'dealer_id' => $validated['dealer_id'] ?? null,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_address' => $validated['customer_address'] ?? null,
                'discount' => $validated['discount'] ?? 0,
                'tax_amount' => $validated['tax_amount'] ?? 0,
                'valid_until' => $validated['valid_until'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'sent',
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['items'] as $itemData) {
                $product = TileProduct::find($itemData['tile_product_id']);
                $sqftPerBox = $product->box_coverage_sqft ?? 1;
                $totalSqft = $itemData['boxes'] * $sqftPerBox;
                $lineTotal = $itemData['boxes'] * $itemData['unit_price'];

                $subtotal += $lineTotal;

                $quotation->items()->create([
                    'tile_product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'boxes' => $itemData['boxes'],
                    'sqft_per_box' => $sqftPerBox,
                    'total_sqft' => $totalSqft,
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $lineTotal,
                ]);
            }

            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax_amount'] ?? 0;
            $grandTotal = ($subtotal - $discount) + $tax;

            $quotation->update([
                'subtotal' => $subtotal,
                'grand_total' => $grandTotal
            ]);

            DB::commit();
            return redirect()->route('admin.quotations.show', $quotation->id)->with('success', 'Quotation created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create quotation: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Quotation $quotation)
    {
        $quotation->load(['items.product', 'dealer', 'creator']);
        return view('admin.quotations.show', compact('quotation'));
    }

    public function updateStatus(Request $request, Quotation $quotation)
    {
        $request->validate([
            'status' => 'required|in:draft,sent,accepted,rejected,expired',
        ]);

        $quotation->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Quotation status updated.');
    }

    

    public function quickCreate()
    {
        $dealers = User::where('role', 'dealer')->get();
        return view('admin.quotations.quick-create', compact('dealers'));
    }

    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string',
            'dealer_id' => 'nullable|exists:users,id',
            'valid_until' => 'nullable|date',
            'discount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.boxes' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate Quotation Number (e.g., QT-2026-0001)
            $nextId = Quotation::max('id') + 1;
            $quotationNo = 'QT-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $subtotal = 0;

            $quotation = Quotation::create([
                'quotation_no' => $quotationNo,
                'dealer_id' => $validated['dealer_id'] ?? null,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_address' => $validated['customer_address'] ?? null,
                'discount' => $validated['discount'] ?? 0,
                'tax_amount' => $validated['tax_amount'] ?? 0,
                'valid_until' => $validated['valid_until'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'sent',
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['items'] as $itemData) {
                $lineTotal = $itemData['boxes'] * $itemData['unit_price'];
                $subtotal += $lineTotal;

                $quotation->items()->create([
                    'tile_product_id' => null, // Left null since it's a temporary/custom item
                    'product_name' => $itemData['product_name'],
                    'boxes' => $itemData['boxes'],
                    'sqft_per_box' => 0.00,
                    'total_sqft' => 0.00,
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $lineTotal,
                ]);
            }

            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax_amount'] ?? 0;
            $grandTotal = ($subtotal - $discount) + $tax;

            $quotation->update([
                'subtotal' => $subtotal,
                'grand_total' => $grandTotal
            ]);

            DB::commit();
            return redirect()->route('admin.quotations.show', $quotation->id)->with('success', 'Temporary quotation created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create quotation: ' . $e->getMessage())->withInput();
        }
    }
}
