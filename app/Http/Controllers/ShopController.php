<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::latest()->paginate(10);
        return view('admin.shops.index', compact('shops'));
    }

    public function create()
    {
        return view('admin.shops.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'address'     => 'required|string',
            'city'        => 'required|string|max:100',
            'state'       => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active'   => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('shops', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Shop::create($validated);

        return redirect()->route('admin.shops.index')->with('success', 'Shop created successfully.');
    }

    public function edit(Shop $shop)
    {
        return view('admin.shops.edit', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'address'     => 'required|string',
            'city'        => 'required|string|max:100',
            'state'       => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active'   => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($shop->image) {
                Storage::disk('public')->delete($shop->image);
            }
            $validated['image'] = $request->file('image')->store('shops', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $shop->update($validated);

        return redirect()->route('admin.shops.index')->with('success', 'Shop updated successfully.');
    }

    public function destroy(Shop $shop)
    {
        if ($shop->image) {
            Storage::disk('public')->delete($shop->image);
        }
        $shop->delete();

        return redirect()->route('admin.shops.index')->with('success', 'Shop deleted successfully.');
    }
}
