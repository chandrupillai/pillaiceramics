@extends('layouts.admin') {{-- Replace with your admin layout blade --}}

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Tile Product Details</h2>
        <div>
            <a href="{{ route('admin.tile-products.edit', $tileProduct->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.tile-products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Products
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Product Image & Quick Status -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    @if($tileProduct->image)
                        <img src="{{ asset('storage/' . $tileProduct->image) }}" alt="{{ $tileProduct->product_name }}" class="img-fluid rounded mb-3" style="max-height: 280px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded mb-3" style="height: 250px;">
                            <span class="text-muted"><i class="fas fa-image fa-3x"></i><br>No Image Available</span>
                        </div>
                    @endif
                    
                    <h5 class="fw-bold mb-1">{{ $tileProduct->product_name }}</h5>
                    <p class="text-muted mb-2">SKU: <code>{{ $tileProduct->sku }}</code></p>
                    
                    <div>
                        @if($tileProduct->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Specifications & Inventory Details -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 35%;">Category</th>
                                    <td>{{ $tileProduct->category->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>{{ $tileProduct->type->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Size</th>
                                    <td>{{ $tileProduct->size->name ?? $tileProduct->size->size_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td class="fw-bold text-success">₹{{ number_format($tileProduct->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Stock Quantity</th>
                                    <td>
                                        <span class="badge {{ $tileProduct->stock_quantity > 10 ? 'bg-info' : 'bg-danger' }}">
                                            {{ $tileProduct->stock_quantity }} Available
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Box Coverage (Sq.Ft)</th>
                                    <td>{{ $tileProduct->box_coverage_sqft ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Pieces Per Box</th>
                                    <td>{{ $tileProduct->pieces_per_box ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td>{{ $tileProduct->location->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Godown</th>
                                    <td>{{ $tileProduct->godown->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{!! nl2br(e($tileProduct->description ?? 'No description provided.')) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection