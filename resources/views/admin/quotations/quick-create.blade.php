@extends('layouts.admin')

@section('title', 'Create Quick / Temporary Quotation')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Create Temporary Quotation</h2>
            <p class="text-muted mb-0">Manually type custom tile/product names and box counts for quick estimates.</p>
        </div>
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Quotations
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.quotations.quick-store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Customer & Recipient Details -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 fw-bold border-bottom">
                        <i class="bi bi-person-lines-fill text-primary me-2"></i> Recipient Information
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Link to Dealer (Optional)</label>
                            <select name="dealer_id" class="form-select">
                                <option value="">-- Direct Customer / Retail --</option>
                                @foreach($dealers as $dealer)
                                    <option value="{{ $dealer->id }}" {{ old('dealer_id') == $dealer->id ? 'selected' : '' }}>
                                        {{ $dealer->name }} ({{$dealer->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Customer / Business Name *</label>
                            <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="e.g. John Doe / ABC Builders" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Phone Number</label>
                            <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" placeholder="e.g. +91 98765 43210">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Email Address</label>
                            <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" placeholder="customer@example.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Delivery Address</label>
                            <textarea name="customer_address" class="form-control" rows="2" placeholder="Full address or location">{{ old('customer_address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Valid Until Date</label>
                            <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until', date('Y-m-d', strtotime('+15 days'))) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Products & Totals -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                        <span class="fw-bold"><i class="bi bi-box-seam text-primary me-2"></i> Custom Products & Items</span>
                        <button type="button" class="btn btn-sm btn-primary" id="add-row-btn">
                            <i class="bi bi-plus-circle me-1"></i> Add Another Item
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0" id="quick-items-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 45%;">Custom Product Description *</th>
                                        <th style="width: 20%;">Total Boxes *</th>
                                        <th style="width: 25%;">Box Rate (₹) *</th>
                                        <th style="width: 10%;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" name="items[0][product_name]" class="form-control" placeholder="e.g. 600x1200mm Glossy Vitrified Tile" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][boxes]" class="form-control boxes-calc" value="1" min="1" required>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" name="items[0][unit_price]" class="form-control price-calc" value="0.00" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Financial Adjustments & Terms -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small fw-semibold">Discount Amount (₹)</label>
                                <input type="number" step="0.01" name="discount" class="form-control" value="{{ old('discount', '0.00') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small fw-semibold">Tax / GST Amount (₹)</label>
                                <input type="number" step="0.01" name="tax_amount" class="form-control" value="{{ old('tax_amount', '0.00') }}">
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label text-secondary small fw-semibold">Terms, Conditions & Notes</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="e.g. Transportation charges extra at actuals. Payment 100% advance.">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold fs-6">
                            <i class="bi bi-check-circle me-1"></i> Save & Generate Temporary Quotation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Dynamic Row Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIndex = 1;

    // Add row
    document.getElementById('add-row-btn').addEventListener('click', function() {
        const tbody = document.querySelector('#quick-items-table tbody');
        const newRow = document.createElement('tr');
        
        newRow.innerHTML = `
            <td>
                <input type="text" name="items[${rowIndex}][product_name]" class="form-control" placeholder="e.g. 300x600mm Wall Tile - Matte" required>
            </td>
            <td>
                <input type="number" name="items[${rowIndex}][boxes]" class="form-control boxes-calc" value="1" min="1" required>
            </td>
            <td>
                <input type="number" step="0.01" name="items[${rowIndex}][unit_price]" class="form-control price-calc" value="0.00" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        rowIndex++;
    });

    // Remove row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row-btn')) {
            const tbody = document.querySelector('#quick-items-table tbody');
            if (tbody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
            } else {
                alert('At least one product item is required.');
            }
        }
    });
});
</script>
@endsection