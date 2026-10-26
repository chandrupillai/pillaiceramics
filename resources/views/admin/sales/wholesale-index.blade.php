@extends('layouts.admin')

@section('title', 'Whole Sales Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">Whole Sales Invoices</h4>
        <p class="text-muted fs-7 mb-0">Manage multi-product wholesale bills and transport orders.</p>
    </div>
    <a href="{{ route('admin.whole-sales.create') }}" class="btn btn-primary fw-semibold px-3">
        <i class="bi bi-plus-lg me-1"></i> Add Whole Sale
    </a>
</div>

<div id="alertContainer"></div>

<div class="card card-custom bg-white shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-7">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3 py-3">#</th>
                    <th>Date</th>
                    <th>Bill Shop Name</th>
                    <th>Sales Person</th>
                    <th>Total Items</th>
                    <th>Total Qty</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody id="wholeSalesTableBody">
                <tr>
                    <td colspan="7" class="text-center py-4">Loading whole sales records...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- View Whole Sale Invoice Modal -->
<div class="modal fade" id="viewWholeSaleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Whole Sale Invoice Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 fs-7" id="viewModalBody">
                Loading...
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        loadWholeSales();
    });

    function loadWholeSales() {
        fetch(`{{ route('admin.whole-sales.fetch') }}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    renderTable(res.data);
                }
            });
    }

    function renderTable(items) {
        const tbody = document.getElementById('wholeSalesTableBody');
        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">No whole sales invoices found.</td></tr>';
            return;
        }

        tbody.innerHTML = items.map((item, index) => `
            <tr>
            <td class="ps-3">${index + 1}</td>
            <td><span class="fw-medium text-dark">${item.sale_date}</span></td>
            <td><span class="fw-bold text-primary">${item.bill_shop_name}</span></td>
            <td><span class="badge bg-light text-dark border">${item.sales_person ? item.sales_person.name : 'N/A'}</span></td>
            <td><span class="badge bg-info-subtle text-info border border-info-subtle">${item.total_items} Items</span></td>
            <td class="fw-bold">${item.total_quantity}</td>
            <td class="text-end pe-3">
                <div class="btn-group btn-group-sm">
                    <button onclick="viewWholeSale('${encodeURIComponent(item.bill_shop_name)}', '${item.sale_date}')" class="btn btn-outline-primary" title="View Invoice"><i class="bi bi-eye-fill"></i></button>
                    <a href="{{ url('admin/whole-sales') }}/${encodeURIComponent(item.bill_shop_name)}/edit?date=${item.sale_date}" class="btn btn-outline-secondary" title="Edit Invoice"><i class="bi bi-pencil-fill"></i></a>
                    <button onclick="deleteWholeSale('${item.bill_shop_name}', '${item.sale_date}')" class="btn btn-outline-danger" title="Delete Invoice"><i class="bi bi-trash-fill"></i></button>
                </div>
            </td>
        </tr>
        `).join('');
    }

    function deleteWholeSale(shopName, date) {
        if (!confirm(`Are you sure you want to delete the whole sale invoice for "${shopName}"?`)) return;

        fetch(`{{ url('admin/whole-sales') }}/${encodeURIComponent(shopName)}?date=${date}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                showAlert(res.message, res.status ? 'success' : 'danger');
                if (res.status) loadWholeSales();
            });
    }

    function showAlert(msg, type) {
        document.getElementById('alertContainer').innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show fs-7" role="alert">
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    }
    const viewModal = new bootstrap.Modal(document.getElementById('viewWholeSaleModal'));

    function viewWholeSale(encodedShopName, date) {
        fetch(`{{ url('admin/whole-sales') }}/${encodedShopName}/show?date=${date}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    const data = res.data;
                    document.getElementById('viewModalBody').innerHTML = `
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Bill Shop Name:</strong> ${data.bill_shop_name}</div>
                            <div class="col-md-6"><strong>Sale Date:</strong> ${data.sale_date}</div>
                            <div class="col-md-6 mt-2"><strong>Sales Person:</strong> ${data.sales_person}</div>
                            <div class="col-md-6 mt-2"><strong>Vehicle Info:</strong> ${data.vehicle_info}</div>
                        </div>
                        <hr>
                        <h6 class="fw-bold mb-2">Purchased Items</h6>
                        <table class="table table-bordered table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product Type</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.items.map((item, idx) => `
                                    <tr>
                                        <td>${idx + 1}</td>
                                        <td>${item.product_type ? item.product_type.name : 'N/A'}</td>
                                        <td>${item.product ? item.product.product_name : 'N/A'}</td>
                                        <td><span class="fw-bold text-primary">${item.quantity}</span></td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                    viewModal.show();
                }
            });
    }
</script>
@endpush