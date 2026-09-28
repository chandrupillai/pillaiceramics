@extends('layouts.admin')

@section('title', 'Quotation Details - ' . $quotation->quotation_no)

@section('content')
@php
    // Fetch company settings dynamically from database
    $company = \App\Models\Company::first();
@endphp

<div class="container-fluid px-4 py-3">
    <!-- Action Bar (Hidden during printing) -->
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <div>
            <a href="{{ route('admin.quotations.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Back to Quotations
            </a>
            <span class="badge bg-{{ $quotation->status === 'accepted' ? 'success' : ($quotation->status === 'rejected' ? 'danger' : 'warning') }} fs-6">
                {{ strtoupper($quotation->status) }}
            </span>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary me-2">
                <i class="bi bi-printer me-1"></i> Print / Download PDF
            </button>
            
            <!-- Update Status Dropdown -->
            <div class="btn-group">
                <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Update Status
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('admin.quotations.update-status', $quotation->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="sent">
                            <button type="submit" class="dropdown-item">Mark as Sent</button>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('admin.quotations.update-status', $quotation->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="dropdown-item text-success">Mark as Accepted</button>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('admin.quotations.update-status', $quotation->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="dropdown-item text-danger">Mark as Rejected</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Printable Quotation Document -->
    <div class="card shadow border-0" id="quotation-paper">
        <div class="card-body p-5">
            
            <!-- Top Header Row -->
            <div class="row pb-4 border-bottom border-2 mb-4 align-items-start">
                
                <!-- Left Side: Large Title & Meta Information -->
                <div class="col-7">
                    <h1 class="display-6 fw-bold text-primary mb-2 text-uppercase tracking-wide">PRICE QUOTATION</h1>
                    <div class="mt-3 fs-6">
                        <p class="mb-1 text-dark"><strong>Quotation No:</strong> <span class="text-secondary">{{ $quotation->quotation_no }}</span></p>
                        <p class="mb-1 text-dark"><strong>Date:</strong> <span class="text-secondary">{{ $quotation->created_at->format('d M, Y') }}</span></p>
                        @if($quotation->valid_until)
                            <p class="mb-0 text-dark"><strong>Valid Until:</strong> <span class="text-secondary">{{ \Carbon\Carbon::parse($quotation->valid_until)->format('d M, Y') }}</span></p>
                        @endif
                    </div>
                </div>

                <!-- Right Side: Company Logo & Details (Pulled from Company Database Table) -->
                <div class="col-5 text-end">
                    <!-- Company Logo -->
                    @if($company && $company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" style="max-height: 85px; max-width: 240px;" class="mb-2 object-fit-contain">
                    @else
                        <!-- Fallback visual if company logo record does not exist -->
                        <div class="d-inline-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-building-fill text-primary fs-2"></i>
                            <span class="fs-4 fw-bold text-dark">{{ $company->company_name ?? 'COMPANY NAME' }}</span>
                        </div>
                    @endif

                    <!-- Company Text Details from Database -->
                    <h5 class="fw-bold mb-1 text-dark">{{ $company->company_name ?? 'Your Company Name' }}</h5>
                    
                    @if($company && $company->address)
                        <p class="text-muted mb-0 small">{!! nl2br(e($company->address)) !!}</p>
                    @endif

                    @if($company && $company->phone)
                        <p class="text-muted mb-0 small"><strong>Ph:</strong> {{ $company->phone }}</p>
                    @endif

                    @if($company && $company->email)
                        <p class="text-muted mb-0 small"><strong>Email:</strong> {{ $company->email }}</p>
                    @endif

                    @if($company && $company->gstin)
                        <p class="text-muted mb-0 small"><strong>GSTIN:</strong> {{ $company->gstin }}</p>
                    @endif
                </div>
            </div>

            <!-- Recipient / Customer Details -->
            <div class="row mb-4">
                <div class="col-6">
                    <h6 class="text-uppercase fw-bold text-secondary fs-7 mb-2">Quotation To:</h6>
                    <h5 class="fw-bold mb-1 text-dark">{{ $quotation->customer_name }}</h5>
                    @if($quotation->customer_phone)
                        <p class="mb-0 text-muted"><strong>Phone:</strong> {{ $quotation->customer_phone }}</p>
                    @endif
                    @if($quotation->customer_email)
                        <p class="mb-0 text-muted"><strong>Email:</strong> {{ $quotation->customer_email }}</p>
                    @endif
                    @if($quotation->customer_address)
                        <p class="mb-0 text-muted"><strong>Address:</strong> {{ $quotation->customer_address }}</p>
                    @endif
                </div>
                <div class="col-6 text-end">
                    @if($quotation->dealer)
                        <h6 class="text-uppercase fw-bold text-secondary fs-7 mb-2">Dealer Account:</h6>
                        <p class="fw-bold mb-0 text-dark">{{ $quotation->dealer->name }}</p>
                        <p class="text-muted mb-0">{{ $quotation->dealer->email }}</p>
                    @endif
                    @if($quotation->creator)
                        <p class="text-muted mt-2 mb-0 fs-7">Prepared By: {{ $quotation->creator->name }}</p>
                    @endif
                </div>
            </div>

            <!-- Quotation Line Items Table -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 40%;">Item Description</th>
                            <th class="text-center" style="width: 15%;">Boxes</th>
                            <th class="text-end" style="width: 20%;">Rate / Box</th>
                            <th class="text-end" style="width: 20%;">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotation->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-bold d-block text-dark">{{ $item->product_name }}</span>
                                    @if($item->product && $item->product->sku)
                                        <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->boxes }}</td>
                                <td class="text-end">₹{{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-end fw-bold">₹{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No line items in this quotation.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Financial Summary / Totals -->
            <div class="row justify-content-end mb-4">
                <div class="col-md-5 col-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="fw-semibold text-secondary">Subtotal:</td>
                            <td class="text-end fw-semibold">₹{{ number_format($quotation->subtotal, 2) }}</td>
                        </tr>
                        @if($quotation->discount > 0)
                            <tr>
                                <td class="fw-semibold text-danger">Discount:</td>
                                <td class="text-end text-danger">- ₹{{ number_format($quotation->discount, 2) }}</td>
                            </tr>
                        @endif
                        @if($quotation->tax_amount > 0)
                            <tr>
                                <td class="fw-semibold text-secondary">Tax / GST:</td>
                                <td class="text-end">+ ₹{{ number_format($quotation->tax_amount, 2) }}</td>
                            </tr>
                        @endif
                        <tr class="border-top border-2">
                            <td class="fw-bold fs-5">Grand Total:</td>
                            <td class="text-end fw-bold fs-5 text-primary">₹{{ number_format($quotation->grand_total, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Notes & Conditions -->
            @if($quotation->notes)
                <div class="border-top pt-3">
                    <h6 class="fw-bold text-secondary">Terms & Conditions:</h6>
                    <p class="text-muted mb-0 small">{!! nl2br(e($quotation->notes)) !!}</p>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Print Stylesheet -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #quotation-paper, #quotation-paper * {
        visibility: visible;
    }
    #quotation-paper {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: none !important;
    }
    .d-print-none {
        display: none !important;
    }
}
</style>
@endsection