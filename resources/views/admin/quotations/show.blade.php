@extends('layouts.admin')

@section('title', 'Quotation - ' . $quotation->quotation_no)

@section('content')
@php
    $company = \App\Models\Company::first();
@endphp

<div class="container-fluid px-4 py-3">
    <!-- Action Bar (Hidden when printing) -->
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
        </div>
    </div>

    <!-- Printable Quotation Page -->
    <div class="quotation-card card shadow-sm border-0 position-relative" id="quotation-paper">
        <!-- Top Right Accent Shape -->
        <div class="top-accent-shape"></div>

        <div class="card-body p-4 p-md-5">
            
            <!-- Brand Header -->
            <div class="row align-items-center mb-4">
                <div class="col-7">
                    <div class="d-flex align-items-center gap-3">
                        @if($company && $company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="company-logo">
                        @else
                            <div class="brand-text">
                                <h1 class="fw-bold mb-0 text-primary-dark">PILLAI</h1>
                                <h4 class="fw-semibold tracking-wider text-dark mb-0">CERAMICS</h4>
                                <small class="text-muted border-top border-secondary pt-1 d-inline-block">TILES FOR A BETTER TOMORROW</small>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-5 text-end">
                    <div class="company-tagline small text-secondary fw-semibold">
                        <i class="bi bi-grid-3x3-gap-fill text-primary me-1"></i> Premium Tiles &nbsp;|&nbsp; Modern Designs &nbsp;|&nbsp; Lasting Quality
                    </div>
                </div>
            </div>

            <!-- Quotation Title Banner -->
            <div class="quotation-banner d-flex justify-content-between align-items-center mb-4 px-4 py-2">
                <h2 class="fw-extrabold text-primary-dark m-0 tracking-wide">QUOTATION</h2>
                <div class="text-end small fw-semibold text-dark">
                    <div><strong>Date :</strong> {{ $quotation->created_at ? $quotation->created_at->format('d-m-Y') : date('d-m-Y') }}</div>
                    <div><strong>Quotation No. :</strong> {{ $quotation->quotation_no }}</div>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="customer-info mb-4">
                <table class="table table-borderless table-sm w-auto mb-0">
                    <tr>
                        <th class="ps-0 pe-3 text-muted">Customer Name</th>
                        <td class="pe-2">:</td>
                        <td class="fw-bold text-dark">{{ $quotation->customer_name }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0 pe-3 text-muted">Mobile No.</th>
                        <td class="pe-2">:</td>
                        <td class="text-dark">{{ $quotation->customer_phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0 pe-3 text-muted">Address</th>
                        <td class="pe-2">:</td>
                        <td class="text-dark">{{ $quotation->customer_address ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <!-- Quotation Line Items Table -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle quotation-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No.</th>
                            <th style="width: 38%;">Product Details</th>
                            <th class="text-center" style="width: 17%;">Size (cm / mm)</th>
                            <th class="text-center" style="width: 12%;">Box Rate (₹)</th>
                            <th class="text-center" style="width: 13%;">Quantity (Boxes / Pcs)</th>
                            <th class="text-end" style="width: 15%;">Total Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotation->items as $index => $item)
                            <tr>
                                <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Image Thumbnail -->
                                        <div class="product-thumb-wrapper">
                                            @if(isset($item->product) && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="Tile Image" class="product-thumb">
                                            @else
                                                <div class="product-thumb-placeholder">
                                                    <i class="bi bi-tile-map text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark mb-1">{{ $item->product_name }}</strong>
                                            @if($item->total_sqft > 0)
                                                <small class="text-muted d-block">Total Coverage: {{ $item->total_sqft }} Sq.Ft (approx.)</small>
                                            @endif
                                            @if(isset($item->pieces_count))
                                                <small class="text-muted d-block">Total Pieces: {{ $item->pieces_count }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center small">
                                    {{ $item->product->size_dimensions ?? ($item->size ?? 'Standard') }}
                                </td>
                                <td class="text-center fw-semibold">₹{{ number_format($item->unit_price, 0) }}</td>
                                <td class="text-center fw-semibold">
                                    {{ $item->boxes }} {{ $item->unit_type ?? ($item->boxes > 1 ? 'boxes' : 'box') }}
                                </td>
                                <td class="text-end fw-bold text-dark">₹{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No items found in this quotation.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Grand Total Bar -->
            <div class="row justify-content-end mb-4">
                <div class="col-md-5">
                    <div class="grand-total-box d-flex justify-content-between align-items-center px-4 py-2">
                        <span class="fs-5 fw-bold text-white">Grand Total</span>
                        <span class="fs-4 fw-extrabold text-white">₹{{ number_format($quotation->grand_total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Section: Terms and Thank You Details -->
            <div class="row mt-4 pt-3 border-top border-light">
                <!-- Terms & Conditions -->
                <div class="col-md-7 mb-3">
                    <h6 class="fw-bold text-primary-dark mb-2">
                        <i class="bi bi-file-text me-1"></i> Terms & Conditions:
                    </h6>
                    <ul class="terms-list small text-muted ps-3 mb-0">
                        <li>Quotation is valid for 15 days from the date of issue.</li>
                        <li>Prices are box rate as mentioned above.</li>
                        <li>Delivery and transportation charges will be extra, if applicable.</li>
                        <li>Any change in quantity or product will be subject to revised quotation.</li>
                        <li>Tiles can be returned only in unused and original condition.</li>
                    </ul>
                </div>

                <!-- Thank You & Contact Details -->
                <div class="col-md-5 text-end d-flex flex-column justify-content-between">
                    <div>
                        <p class="small text-muted mb-2">We look forward to your valuable order and the opportunity to serve you.</p>
                        <h6 class="fw-bold text-dark mb-1">Thank you!</h6>
                        <small class="text-muted">Best Regards,</small>
                        <h5 class="fw-bold text-primary-dark mb-2">{{ $company->company_name ?? 'Pillai Ceramics' }}</h5>
                    </div>

                    <div class="contact-details small text-muted mt-3">
                        <div class="mb-1"><i class="bi bi-telephone-fill text-primary me-2"></i> {{ $company->phone ?? '99420 78593' }}</div>
                        <div><i class="bi bi-geo-alt-fill text-primary me-2"></i> {{ $company->address ?? 'Pillai Ceramics' }}</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Slogan Banner -->
            <div class="bottom-slogan text-end mt-4 pt-2">
                <span class="fst-italic text-primary fs-5 fw-bold">Beautiful Spaces Start with Better Tiles</span>
            </div>

        </div>

        <!-- Bottom Right Accent Graphic -->
        <div class="bottom-accent-shape"></div>
    </div>
</div>

<!-- Custom CSS Styling -->
<style>
:root {
    --brand-blue: #005691;
    --brand-dark-blue: #003366;
    --brand-light-blue: #eef6fc;
}

.quotation-card {
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
}

/* Header & Accent Graphics */
.top-accent-shape {
    position: absolute;
    top: 0;
    right: 0;
    width: 160px;
    height: 60px;
    background: linear-gradient(135deg, transparent 50%, var(--brand-blue) 50%);
    z-index: 1;
}

.bottom-accent-shape {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 200px;
    height: 80px;
    background: linear-gradient(135deg, transparent 60%, var(--brand-dark-blue) 60%);
    z-index: 1;
}

.text-primary-dark {
    color: var(--brand-dark-blue) !important;
}

.company-logo {
    max-height: 70px;
    max-width: 220px;
    object-fit: contain;
}

/* Banner */
.quotation-banner {
    background-color: var(--brand-light-blue);
    border-left: 5px solid var(--brand-blue);
    border-radius: 4px;
}

/* Customer Details */
.customer-info th {
    font-weight: 600;
}

/* Quotation Table Styling */
.quotation-table {
    border-color: #dee2e6;
}

.quotation-table thead {
    background-color: var(--brand-blue);
    color: #ffffff;
}

.quotation-table thead th {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    border: none;
    padding: 10px;
}

.product-thumb-wrapper {
    width: 55px;
    height: 55px;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
    flex-shrink: 0;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-thumb-placeholder {
    font-size: 1.5rem;
}

/* Grand Total */
.grand-total-box {
    background-color: var(--brand-blue);
    border-radius: 6px;
}

/* Terms */
.terms-list {
    line-height: 1.6;
}

/* Print Optimization */
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

@media print {
    /* Set page size to A4 with tight margins */
    @page {
        size: A4 portrait;
        margin: 5mm;
    }

    /* Hide surrounding layout elements */
    body * {
        visibility: hidden;
    }
    
    body, html {
        height: 100%;
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
    }

    /* Target quotation paper and fit everything on 1 page */
    #quotation-paper, #quotation-paper * {
        visibility: visible;
    }

    #quotation-paper {
        position: absolute;
        left: 0;
        top: 0;
        width: 100% !important;
        max-height: 100vh !important;
        padding: 15px !important; /* Reduced padding from p-5 */
        box-shadow: none !important;
        border: none !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
        overflow: hidden;
    }

    /* Compact spacing for single page fitting */
    .quotation-banner {
        margin-bottom: 10px !important;
        padding: 4px 12px !important;
    }

    .customer-info {
        margin-bottom: 10px !important;
    }

    .table-responsive {
        margin-bottom: 10px !important;
    }

    /* Compact table padding */
    .quotation-table th, 
    .quotation-table td {
        padding: 4px 8px !important;
        font-size: 0.8rem !important;
    }

    /* Compact image thumbnails */
    .product-thumb-wrapper {
        width: 35px !important;
        height: 35px !important;
    }

    /* Hide background accent shapes to clean up page height */
    .top-accent-shape, 
    .bottom-accent-shape {
        display: none !important;
    }

    /* Prevent page breaks across all sections */
    tr, td, th, .row, .card-body {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    /* Hide action buttons and navigation */
    .d-print-none {
        display: none !important;
    }
}
</style>
@endsection