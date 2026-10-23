@extends('layouts.admin')

@section('title', 'Daily Sales Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">Daily Sales Details</h4>
        <p class="text-muted fs-7 mb-0">Track product sales with auto-suggestions, product types, billing shops, and vehicle transport data.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-3" onclick="openCreateModal()">
        <i class="bi bi-plus-lg me-1"></i> Add New Sale
    </button>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<!-- Data Table Card -->
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
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody id="salesTableBody">
                <tr>
                    <td colspan="8" class="text-center py-4">Loading sales records...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Sale Modal -->
<div class="modal fade" id="saleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Record Daily Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saleForm">
                @csrf
                <input type="hidden" name="product_id" id="productId">
                <div class="modal-body p-4">
                    <div id="modalError" class="alert alert-danger d-none fs-7 py-2"></div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Sales Person <span class="text-danger">*</span></label>
                            <select name="user_id" id="userId" class="form-select" required>
                                <option value="">Select Sales Person</option>
                                @foreach($staffMembers as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }} ({{ ucfirst($staff->role) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Sale Date <span class="text-danger">*</span></label>
                            <input type="date" name="sale_date" id="saleDate" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Product Name & Size Auto-suggestion & Type -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-8 position-relative">
                            <label class="form-label fw-semibold fs-7">Product Name & Size (Auto-suggestion) <span class="text-danger">*</span></label>
                            <input type="text" name="product_id_display" id="productNameInput" class="form-control" placeholder="Type to search product name or size..." autocomplete="off" required>

                            <!-- Custom Suggestions Dropdown List -->
                            <div id="productSuggestions" class="shadow-sm border rounded bg-white w-100 position-absolute start-0 mt-1 d-none" style="max-height: 220px; overflow-y: auto; z-index: 1080;"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold fs-7">Product Type <span class="text-danger">*</span></label>
                            <select name="product_type" id="productType" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="Tiles">Tiles</option>
                                <option value="Paste">Paste</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Quantity <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="quantity" id="quantity" class="form-control" placeholder="e.g. 150" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Bill Shop Name <span class="text-danger">*</span></label>
                            <input type="text" name="bill_shop_name" id="billShopName" class="form-control" placeholder="e.g. Sri Murugan Traders" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Vehicle Information</label>
                        <input type="text" name="vehicle_info" id="vehicleInfo" class="form-control" placeholder="e.g. TN 45 AB 1234 (Mini Truck)">
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-semibold px-4">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const saleModal = new bootstrap.Modal(document.getElementById('saleModal'));

    document.addEventListener('DOMContentLoaded', () => {
        loadSales();
        document.getElementById('saleForm').addEventListener('submit', handleFormSubmit);

        // Product Auto-suggestion Handler
        const searchInput = document.getElementById('productNameInput');
        const suggestionsBox = document.getElementById('productSuggestions');

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length < 2) {
                suggestionsBox.classList.remove('show');
                return;
            }

            fetch(`{{ route('admin.sales.search-products') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(res => {
                    if (res.status && res.data.length > 0) {
                        suggestionsBox.innerHTML = res.data.map(prod => {
                            const displayName = prod.size ? `${prod.product_name} (${prod.size})` : prod.product_name;
                            return `
                                <button type="button" class="dropdown-item py-2" onclick="selectProduct('${prod.id}', '${prod.product_name.replace(/'/g, "\\'")}', '${prod.size ? prod.size.replace(/'/g, "\\'") : ''}', '${prod.product_type || ''}')">
                                    <div class="fw-semibold">${displayName}</div>
                                    <small class="text-muted">Type: ${prod.product_type || 'General'}</small>
                                </button>
                            `;
                        }).join('');
                        suggestionsBox.classList.add('show');
                    } else {
                        suggestionsBox.classList.remove('show');
                    }
                });
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.classList.remove('show');
            }
        });
    });

    function selectProduct(id, name, size, type) {
        document.getElementById('productId').value = id;
        const fullName = size ? `${name} (${size})` : name;
        document.getElementById('productNameInput').value = fullName;
        if (type) {
            document.getElementById('productType').value = type;
        }
        document.getElementById('productSuggestions').classList.remove('show');
    }

    function getLocalDateString() {
        const d = new Date();
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function loadSales() {
        fetch(`{{ route('admin.sales.fetch') }}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    renderTable(res.data);
                }
            });
    }

    function renderTable(items) {
        const tbody = document.getElementById('salesTableBody');
        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">No sales records found.</td></tr>';
            return;
        }

        tbody.innerHTML = items.map((item, index) => `
            <tr>
                <td class="ps-3">${index + 1}</td>
                <td><span class="fw-medium text-dark">${item.sale_date}</span></td>
                <td><span class="badge bg-light text-dark border">${item.sales_person ? item.sales_person.name : 'N/A'}</span></td>
                <td>
                    <div class="fw-semibold text-dark">${item.product_name}</div>
                    <span class="badge bg-info-subtle text-info border border-info-subtle fs-8">${item.product_type || 'General'}</span>
                </td>
                <td>${item.quantity}</td>
                <td>${item.bill_shop_name}</td>
                <td>${item.vehicle_info ? `<span class="text-muted"><i class="bi bi-truck me-1"></i>${item.vehicle_info}</span>` : '<span class="text-muted">N/A</span>'}</td>
                <td class="text-end pe-3">
                    <button onclick="deleteSale(${item.id})" class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
        `).join('');
    }

    function openCreateModal() {
        document.getElementById('saleForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('saleDate').value = getLocalDateString();
        document.getElementById('modalError').classList.add('d-none');
        saleModal.show();
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        fetch(`{{ route('admin.sales.store') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(async res => {
                const body = await res.json();
                if (!res.ok) throw body;
                return body;
            })
            .then(res => {
                saleModal.hide();
                showAlert(res.message, 'success');
                loadSales();
            })
            .catch(err => {
                const errorDiv = document.getElementById('modalError');
                errorDiv.classList.remove('d-none');
                if (err.errors) {
                    errorDiv.innerHTML = Object.values(err.errors).flat().join('<br>');
                } else {
                    errorDiv.innerText = err.message || 'Something went wrong.';
                }
            });
    }

    function deleteSale(id) {
        if (!confirm('Are you sure you want to delete this sale record?')) return;

        fetch(`{{ url('admin/daily-sales') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                showAlert(res.message, res.status ? 'success' : 'danger');
                if (res.status) loadSales();
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
</script>
@endpush