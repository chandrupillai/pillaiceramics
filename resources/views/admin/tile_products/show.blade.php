@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid px-2 px-sm-3 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Product Details</h4>
            <p class="text-muted fs-7 mb-0">Viewing specs for SKU: <strong>{{ $product->sku }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.tile-products.edit', $product->id) }}" class="btn btn-primary btn-sm fw-semibold">
                <i class="bi bi-pencil-fill me-1"></i> Edit Product
            </a>
            <a href="{{ route('admin.tile-products.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 text-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-fluid rounded mb-3" style="max-height: 250px; object-fit: contain;">
                @else
                    <div class="bg-light text-muted py-5 rounded mb-3">
                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                        <span>No Image Available</span>
                    </div>
                @endif
                <h5 class="fw-bold text-dark mb-1">{{ $product->product_name }}</h5>
                <span class="badge bg-secondary mb-3">{{ $product->sku }}</span>
                <div>
                    @if($product->is_active)
                        <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactive</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Classification & Specs</h6>
                <div class="row g-3 fs-7">
                    <div class="col-md-6"><strong>Product Type:</strong> <span class="badge bg-info-subtle text-info border">{{ $product->productType->name ?? 'N/A' }}</span></div>
                    <div class="col-md-6"><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</div>
                    <div class="col-md-6"><strong>Tile Type:</strong> {{ $product->type->name ?? 'N/A' }}</div>
                    <div class="col-md-6"><strong>Tile Size:</strong> {{ $product->size->name ?? 'N/A' }}</div>
                    <div class="col-md-6"><strong>Price (per box):</strong> ₹{{ number_format($product->price, 2) }}</div>
                    <div class="col-md-6"><strong>Stock Quantity:</strong> <span class="fw-bold text-primary">{{ $product->stock_quantity }} boxes</span></div>
                    <div class="col-md-6"><strong>Box Coverage:</strong> {{ $product->box_coverage_sqft ? $product->box_coverage_sqft . ' Sq.Ft.' : 'N/A' }}</div>
                    <div class="col-md-6"><strong>Pieces Per Box:</strong> {{ $product->pieces_per_box ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt me-2 text-primary"></i>Storage & Warehouse Location</h6>
                <div class="row g-3 fs-7">
                    <div class="col-md-4"><strong>Production Company:</strong> {{ $product->productionCompany->name ?? 'N/A' }}</div>
                    <div class="col-md-4"><strong>Godown:</strong> {{ $product->godown->name ?? 'N/A' }}</div>
                    <div class="col-md-4"><strong>Rack/Location:</strong> {{ $product->location->name ?? 'N/A' }}</div>
                    <div class="col-12 mt-3">
                        <strong>Description:</strong>
                        <p class="text-muted mt-1 mb-0">{{ $product->description ?: 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection