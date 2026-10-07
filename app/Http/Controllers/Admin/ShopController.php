<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    /**
     * Display a listing of all showrooms.
     */
    public function index()
    {
        $shops = Shop::latest()->paginate(10);
        return view('admin.shops.index', compact('shops'));
    }

    /**
     * Show the form for creating a new showroom.
     */
    public function create()
    {
        return view('admin.shops.create');
    }

    /**
     * Store a newly created showroom in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'address'     => 'required|string',
            'postal_code' => 'nullable|string|max:20',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Generate URL-friendly slug from showroom name
        $validated['slug'] = Str::slug($request->name);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('shops', 'public');
        }

        // Handle Checkbox for Active Status
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Shop::create($validated);

        return redirect()
            ->route('admin.shops.index')
            ->with('success', 'Showroom created successfully.');
    }

    /**
     * Show the form for editing the specified showroom.
     */
    public function edit(Shop $shop)
    {
        return view('admin.shops.edit', compact('shop'));
    }

    /**
     * Update the specified showroom in storage.
     */
    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'address'     => 'required|string',
            'postal_code' => 'nullable|string|max:20',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Update slug if showroom name changes
        if ($shop->name !== $request->name) {
            $validated['slug'] = Str::slug($request->name);
        }

        // Handle new image upload and remove previous image file
        if ($request->hasFile('image')) {
            if ($shop->image && Storage::disk('public')->exists($shop->image)) {
                Storage::disk('public')->delete($shop->image);
            }
            $validated['image'] = $request->file('image')->store('shops', 'public');
        }

        // Handle Checkbox for Active Status
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $shop->update($validated);

        return redirect()
            ->route('admin.shops.index')
            ->with('success', 'Showroom updated successfully.');
    }

    /**
     * Remove the specified showroom from storage.
     */
    public function destroy(Shop $shop)
    {
        // Delete associated image file before removing record
        if ($shop->image && Storage::disk('public')->exists($shop->image)) {
            Storage::disk('public')->delete($shop->image);
        }

        $shop->delete();

        return redirect()
            ->route('admin.shops.index')
            ->with('success', 'Showroom deleted successfully.');
    }
}