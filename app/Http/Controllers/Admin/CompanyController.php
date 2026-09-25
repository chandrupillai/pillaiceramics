<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Exception;

class CompanyController extends Controller
{
    protected CompanyRepositoryInterface $companyRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    /**
     * Display Company Edit / Create Form
     */
    public function index()
    {
        try {
            $company = $this->companyRepo->getFirstCompany();
            return view('admin.company.index', compact('company'));
        } catch (Exception $e) {
            return back()->with('error', 'Unable to fetch company details: ' . $e->getMessage());
        }
    }

    /**
     * Store or Update Company Details
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'logo'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $data = $request->only(['name', 'email', 'phone', 'address']);
            $existingCompany = $this->companyRepo->getFirstCompany();

            // Handle logo upload to public/images/
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($existingCompany && $existingCompany->logo && File::exists(public_path($existingCompany->logo))) {
                    File::delete(public_path($existingCompany->logo));
                }

                $file = $request->file('logo');
                $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();

                // Save to public/images folder
                $file->move(public_path('images'), $filename);
                $data['logo'] = 'images/' . $filename;
            }

            $this->companyRepo->updateOrCreateCompany($data);

            return redirect()->back()->with('success', 'Company details saved successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to save company details: ' . $e->getMessage())->withInput();
        }
    }
}
