@extends('layouts.admin')

@section('title', 'Daily Sales Reports')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
</style>
@endpush

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">Daily Sales Analytics & Reports</h4>
        <p class="text-muted fs-7 mb-0">Filter and analyze sales records by staff members, specific months, products, and combined criteria.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm fw-semibold px-3" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> Print Report
        </button>
    </div>
</div>

<!-- Filter Card -->
<div class="card card-custom bg-white shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <form id="reportFilterForm" class="row g-3">
            <!-- 1. Staff Wise -->
            <div class="col-md-3">
                <label class="form-label fw-semibold fs-7">Staff Member</label>
                <select name="user_id" id="filterUserId" class="form-select">
                    <option value="">All Staff Members</option>
                    @foreach($staffMembers as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }} ({{ ucfirst($staff->role) }})</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Month Wise -->
            <div class="col-md-3">
                <label class="form-label fw-semibold fs-7">Month / Year</label>
                <input type="month" name="month" id="filterMonth" class="form-control" value="{{ date('Y-m') }}">
            </div>

            <!-- 3. Product Wise -->
            <div class="col-md-4">
                <label class="form-label fw-semibold fs-7">Product Name</label>
                <select name="product_id" id="filterProductId" class="form-select" style="width: 100%;">
                    <option value="">All Products</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}">{{ $prod->product_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <button type="button" class="btn btn-light border" onclick="resetFilters()" title="Reset Filters">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-3">
                <p class="fs-7 mb-1 opacity-75">Total Quantity Sold</p>
                <h3 class="fw-bold mb-0" id="summaryQuantity">0.00</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body p-3">
                <p class="fs-7 mb-1 opacity-75">Total Transactions</p>
                <h3 class="fw-bold mb-0" id="summaryTransactions">0</h3>
            </div>
        </div>
    </div>
</div>

<!-- Report Data Table Card -->
<div class="card card-custom bg-white shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-7">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3 py-3">#</th>
                    <th>Date</th>
                    <th>Sales Person</th>
                    <th>Product & Type</th>
                    <th>Quantity</th>
                    <th>Bill Shop Name</th>
                    <th>Vehicle Info</th>
                </tr>
            </thead>
            <tbody id="reportTableBody">
                <tr>
                    <td colspan="7" class="text-center py-4">Select filters and click filter to generate report.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        $('#filterProductId').select2({
            theme: 'bootstrap-5',
            placeholder: 'Search and select product...',
            allowClear: true
        });

        // Load initial report on page load with default month
        fetchReportData();

        document.getElementById('reportFilterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetchReportData();
        });
    });

    function fetchReportData() {
        const formData = new FormData(document.getElementById('reportFilterForm'));
        const params = new URLSearchParams(formData).toString();

        const tbody = document.getElementById('reportTableBody');
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">Loading report data...</td></tr>';

        fetch(`{{ route('admin.sales.reports.fetch') }}?${params}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    document.getElementById('summaryQuantity').innerText = res.summary.total_quantity;
                    document.getElementById('summaryTransactions').innerText = res.summary.total_transactions;
                    renderReportTable(res.data);
                }
            })
            .catch(() => {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">Failed to load report data.</td></tr>';
            });
    }

    function renderReportTable(items) {
        const tbody = document.getElementById('reportTableBody');
        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">No sales records found matching the selected filters.</td></tr>';
            return;
        }

        tbody.innerHTML = items.map((item, index) => `
            <tr>
                <td class="ps-3">${index + 1}</td>
                <td><span class="fw-medium text-dark">${item.sale_date}</span></td>
                <td><span class="badge bg-light text-dark border">${item.sales_person ? item.sales_person.name : 'N/A'}</span></td>
                <td>
                    <div class="fw-semibold text-dark">${item.product ? item.product.product_name : 'N/A'}</div>
                    <span class="badge bg-info-subtle text-info border border-info-subtle fs-8">${item.product_type ? item.product_type.name : 'General'}</span>
                </td>
                <td class="fw-bold text-primary">${item.quantity}</td>
                <td>${item.bill_shop_name}</td>
                <td>${item.vehicle_info ? `<span class="text-muted"><i class="bi bi-truck me-1"></i>${item.vehicle_info}</span>` : '<span class="text-muted">N/A</span>'}</td>
            </tr>
        `).join('');
    }

    function resetFilters() {
        document.getElementById('reportFilterForm').reset();
        $('#filterProductId').val(null).trigger('change');
        document.getElementById('filterMonth').value = '{{ date("Y-m") }}';
        fetchReportData();
    }
</script>
@endpush