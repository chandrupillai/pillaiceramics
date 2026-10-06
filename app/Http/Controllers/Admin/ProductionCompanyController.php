<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductionCompany;
use Illuminate\Http\Request;

class ProductionCompanyController extends Controller
{
    public function index()
    {
        $companies = ProductionCompany::latest()->paginate(10);
        return view('admin.production-companies.index', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        ProductionCompany::create([
            'name'      => $request->name,
            'location'  => $request->location,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Production company added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $company = ProductionCompany::findOrFail($id);
        $company->update([
            'name'      => $request->name,
            'location'  => $request->location,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Production company updated successfully.');
    }

    public function destroy($id)
    {
        $company = ProductionCompany::findOrFail($id);
        $company->delete();

        return redirect()->back()->with('success', 'Production company deleted successfully.');
    }
}
