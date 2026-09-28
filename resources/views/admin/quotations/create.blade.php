@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Create New Quotation</h3>
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary">Back to Quotations</a>
    </div>

    <form action="{{ route('admin.quotations.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Customer / Dealer Details -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">Recipient Details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Link to Dealer (Optional)</label>
                            <select name="dealer_id" class="form-select">
                                <option value="">-- Direct Customer --</option>
                                @foreach($dealers as $dealer)
                                    <option value="{{ $dealer->id }}">{{ $dealer->name }} ({{ $dealer->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer/Business Name *</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="customer_phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="customer_email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="customer_address" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Valid Until Date</label>
                            <input type="date" name="valid_until" class="form-control" value="{{ date('Y-m-d', strtotime('+15 days')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items & Financials -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                        <span>Tile Items</span>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-item-btn">+ Add Item</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0" id="items-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40%;">Product</th>
                                        <th style="width: 20%;">Boxes</th>
                                        <th style="width: 25%;">Box Rate (₹)</th>
                                        <th style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="items[0][tile_product_id]" class="form-select product-select" required>
                                                <option value="">Select Tile Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                        {{ $product->product_name }} (SKU: {{ $product->sku }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][boxes]" class="form-control boxes-input" value="1" min="1" required>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" name="items[0][unit_price]" class="form-control price-input" value="0.00" required>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger remove-row-btn">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Amount (₹)</label>
                                <input type="number" step="0.01" name="discount" class="form-control" value="0.00">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tax / GST (₹)</label>
                                <input type="number" step="0.01" name="tax_amount" class="form-control" value="0.00">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Terms & Notes</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Transportation extra, valid for 15 days."></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Generate & Save Quotation</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    // Add new product row
    document.getElementById('add-item-btn').addEventListener('click', function() {
        const tbody = document.querySelector('#items-table tbody');
        const firstRow = tbody.querySelector('tr');
        const newRow = firstRow.cloneNode(true);

        // Update inputs name indices
        newRow.querySelectorAll('input, select').forEach(input => {
            let name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, '[' + itemIndex + ']'));
            }
            if (input.classList.contains('boxes-input')) input.value = 1;
            if (input.classList.contains('price-input')) input.value = '0.00';
            if (input.tagName === 'SELECT') input.selectedIndex = 0;
        });

        tbody.appendChild(newRow);
        itemIndex++;
    });

    // Auto populate default price on product selection
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || '0.00';
            const row = e.target.closest('tr');
            row.querySelector('.price-input').value = price;
        }
    });

    // Remove row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row-btn')) {
            const tbody = document.querySelector('#items-table tbody');
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