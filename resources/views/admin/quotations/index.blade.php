@extends('layouts.admin')

@section('title', 'Quotations List')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quotations</h1>
        <a href="{{ route('admin.quotations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Create Quotation
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">All Quotations</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Quotation No</th>
                            <th>Customer / Dealer</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotations ?? [] as $quotation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $quotation->quotation_number }}</td>
                                <td>{{ $quotation->customer_name }}</td>
                                <td>₹{{ number_format($quotation->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ ucfirst($quotation->status) }}</span>
                                </td>
                                <td>{{ $quotation->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.quotations.show', $quotation->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No quotations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection