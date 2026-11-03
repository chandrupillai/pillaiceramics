@extends('layouts.admin')

@section('title', 'Daily Sales Management')

@push('styles')
<!-- Select2 CSS CDN -->
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
        <h4 class="fw-bold mb-1">Daily Sales Details</h4>
        <p class="text-muted fs-7 mb-0">Track product sales with pricing, optional GST calculation, automated stock subtraction, and transport data.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-3 w-100 w-md-auto" onclick="openCreateModal()">
        <i class="bi bi-plus-lg me-1"></i> Add New Sale
    </button>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<!-- Search & Filter Card -->
<div class="card card-custom bg-white shadow-sm border-0 mb-4">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" id="tableSearch" class="form-control" placeholder="Search shop name, vehicle, etc..." onkeyup="loadSales(1)">
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <th>Quantity & Price</th>
                    <th>Total Amount</th>
                    <th>Bill Shop Name</th>
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
    <!-- Pagination Footer -->
    <div class="card-footer bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 border-top">
        <span class="text-muted fs-7" id="paginationInfo">Showing 0 entries</span>
        <nav>
            <ul class="pagination pagination-sm mb-0" id="paginationLinks">
                <!-- Pagination injected via JavaScript -->
            </ul>
        </nav>
    </div>
</div>

<!-- Add / Edit Sale Modal -->
<div class="modal fade" id="saleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">Record Daily Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saleForm">
                @csrf
                <input type="hidden" id="saleId" name="sale_id">
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

                    <!-- Product Type Dropdown & Select2 Product Dropdown Wrapper -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold fs-7">Product Type <span class="text-danger">*</span></label>
                            <select name="product_type_id" id="productTypeId" class="form-select" required onchange="onProductTypeChange()">
                                <option value="">Select Type</option>
                                @foreach(\App\Models\ProductType::where('is_active', true)->get() as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product Selection Wrapper -->
                        <div class="col-md-8 d-none" id="productSelectionWrapper">
                            <label class="form-label fw-semibold fs-7">Product Name <span class="text-danger">*</span></label>
                            <select name="product_id" id="productId" class="form-select" required style="width: 100%;">
                                <option value="">Select Product...</option>
                            </select>
                            <input type="hidden" name="product_name" id="productNameHidden">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Quantity <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="quantity" id="quantity" class="form-control" placeholder="e.g. 150" required oninput="calculateTotal()">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Unit Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="unit_price" id="unitPrice" class="form-control" placeholder="e.g. 450" required oninput="calculateTotal()">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">GST Amount (Optional)</label>
                            <input type="number" step="0.01" name="gst_amount" id="gstAmount" class="form-control" placeholder="e.g. 50.00" oninput="calculateTotal()">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Total Amount (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="total_amount" id="totalAmount" class="form-control bg-light" readonly required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Bill Shop Name <span class="text-danger">*</span></label>
                            <input type="text" name="bill_shop_name" id="billShopName" class="form-control" placeholder="e.g. Sri Murugan Traders" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Vehicle Information</label>
                            <input type="text" name="vehicle_info" id="vehicleInfo" class="form-control" placeholder="e.g. TN 45 AB 1234">
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary fw-semibold px-4">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Sale Record Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 fs-7" id="viewModalBody">
                <!-- Dynamically populated -->
            </div>
            <div class="modal-footer bg-light d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary btn-sm px-3" onclick="printInvoice()">
                    <i class="bi bi-printer me-1"></i> Print / Download Invoice
                </button>
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles for Modal Invoice -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #viewModalBody, #viewModalBody * {
        visibility: visible;
    }
    #viewModalBody {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 20px;
        background: #fff;
    }
    .modal-header, .modal-footer, .btn-close, .d-print-none {
        display: none !important;
    }
}
</style>
@endsection

@push('scripts')
<!-- 1. Load jQuery First -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- 2. Load Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const saleModal = new bootstrap.Modal(document.getElementById('saleModal'));
    const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', () => {
        loadSales(1);
        document.getElementById('saleForm').addEventListener('submit', handleFormSubmit);

        $('#productId').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#saleModal'),
            placeholder: 'Search and select product...',
            allowClear: true
        });

        $('#productId').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const dataName = selectedOption.data('name');
            if (dataName) {
                document.getElementById('productNameHidden').value = dataName;
            }
        });
    });

    function calculateTotal() {
        const qty = parseFloat(document.getElementById('quantity').value) || 0;
        const price = parseFloat(document.getElementById('unitPrice').value) || 0;
        const gst = parseFloat(document.getElementById('gstAmount').value) || 0;
        
        const total = (qty * price) + gst;
        document.getElementById('totalAmount').value = total.toFixed(2);
    }

    function onProductTypeChange(preselectProductId = null) {
        const typeId = document.getElementById('productTypeId').value;
        const productSelect = $('#productId');
        const wrapper = document.getElementById('productSelectionWrapper');

        productSelect.empty().append('<option value="">Loading products...</option>').trigger('change');

        if (!typeId) {
            wrapper.classList.add('d-none');
            return;
        }

        wrapper.classList.remove('d-none');

        fetch(`{{ route('admin.sales.search-products') }}?product_type_id=${typeId}`)
            .then(res => res.json())
            .then(res => {
                productSelect.empty().append('<option value="">Select Product...</option>');
                if (res.status && res.data.length > 0) {
                    res.data.forEach(prod => {
                        const displayName = prod.size ? `${prod.product_name} (${prod.size})` : prod.product_name;
                        const optionText = `${displayName} [SKU: ${prod.sku || 'N/A'}]`;
                        
                        const newOption = new Option(optionText, prod.id, false, false);
                        $(newOption).data('name', prod.product_name);
                        productSelect.append(newOption);
                    });
                }
                productSelect.trigger('change');

                if (preselectProductId) {
                    productSelect.val(preselectProductId).trigger('change');
                }
            })
            .catch(() => {
                productSelect.empty().append('<option value="">Error loading products</option>').trigger('change');
            });
    }

    function loadSales(page = 1) {
        currentPage = page;
        const search = document.getElementById('tableSearch') ? document.getElementById('tableSearch').value : '';
        
        fetch(`{{ route('admin.sales.fetch') }}?page=${page}&search=${search}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    renderTable(res.data);
                    renderPagination(res.data);
                }
            });
    }

    function renderTable(paginatedData) {
        const tbody = document.getElementById('salesTableBody');
        const items = paginatedData.data || paginatedData;

        if (!paginatedData.data) {
            if (items.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">No sales records found.</td></tr>';
                return;
            }
            tbody.innerHTML = items.map((item, index) => buildTableRow(item, index + 1)).join('');
            return;
        }

        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">No sales records found.</td></tr>';
            return;
        }

        tbody.innerHTML = items.map((item, index) => {
            const rowNumber = (paginatedData.current_page - 1) * paginatedData.per_page + index + 1;
            return buildTableRow(item, rowNumber);
        }).join('');
    }

    function buildTableRow(item, rowNumber) {
        return `
            <tr>
                <td class="ps-3">${rowNumber}</td>
                <td><span class="fw-medium text-dark">${item.sale_date}</span></td>
                <td><span class="badge bg-light text-dark border">${item.sales_person ? item.sales_person.name : 'N/A'}</span></td>
                <td>
                    <div class="fw-semibold text-dark">${item.product ? item.product.product_name : (item.product_name || 'N/A')}</div>
                    <span class="badge bg-info-subtle text-info border border-info-subtle fs-8">${item.product_type ? item.product_type.name : 'General'}</span>
                </td>
                <td>${item.quantity} Qty @ ₹${item.unit_price}</td>
                <td><span class="fw-bold text-success">₹${item.total_amount}</span></td>
                <td>${item.bill_shop_name}</td>
                <td class="text-end pe-3">
                    <div class="btn-group btn-group-sm">
                        <button onclick="viewSale(${item.id})" class="btn btn-outline-primary" title="View Details"><i class="bi bi-eye-fill"></i></button>
                        <button onclick="editSale(${item.id})" class="btn btn-outline-secondary" title="Edit Sale"><i class="bi bi-pencil-fill"></i></button>
                        <button onclick="deleteSale(${item.id})" class="btn btn-outline-danger" title="Delete Sale"><i class="bi bi-trash-fill"></i></button>
                    </div>
                </td>
            </tr>
        `;
    }

    function renderPagination(paginatedData) {
        const infoElem = document.getElementById('paginationInfo');
        const paginationUL = document.getElementById('paginationLinks');

        if (!paginatedData.links || !paginatedData.total) {
            if (infoElem) infoElem.innerText = `Showing ${paginatedData.length || 0} entries`;
            if (paginationUL) paginationUL.innerHTML = '';
            return;
        }

        if (infoElem) {
            infoElem.innerText = `Showing ${paginatedData.from || 0} to ${paginatedData.to || 0} of ${paginatedData.total} entries`;
        }

        let linksHtml = '';
        paginatedData.links.forEach(link => {
            let activeClass = link.active ? 'active' : '';
            let disabledClass = !link.url ? 'disabled' : '';
            let pageLabel = link.label.replace('&laquo;', '«').replace('&raquo;', '»');

            linksHtml += `
                <li class="page-item ${activeClass} ${disabledClass}">
                    <a class="page-link" href="#" onclick="${link.url ? `loadSales(${new URL(link.url).searchParams.get('page')})` : 'return false;'}">${pageLabel}</a>
                </li>
            `;
        });

        if (paginationUL) paginationUL.innerHTML = linksHtml;
    }

    function openCreateModal() {
        document.getElementById('saleForm').reset();
        document.getElementById('saleId').value = '';
        document.getElementById('modalTitle').innerText = 'Record Daily Sale';
        document.getElementById('saveBtn').innerText = 'Save Record';
        document.getElementById('productSelectionWrapper').classList.add('d-none');
        $('#productId').empty().append('<option value="">Select Product...</option>').trigger('change');
        document.getElementById('saleDate').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalError').classList.add('d-none');
        saleModal.show();
    }

    function viewSale(id) {
        fetch(`{{ url('admin/daily-sales') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    const item = res.data;
                    document.getElementById('viewModalBody').innerHTML = `
                        <div class="text-center mb-3">
                            <h4 class="fw-bold text-primary mb-1">Maharaja Tiles</h4>
                            <p class="text-muted small mb-0">Daily Sales Receipt</p>
                        </div>
                        <div class="row mb-3 border-bottom pb-3">
                            <div class="col-6"><strong>Sale Date:</strong> ${item.sale_date}</div>
                            <div class="col-6 text-end"><strong>Sales Person:</strong> ${item.sales_person ? item.sales_person.name : 'N/A'}</div>
                            <div class="col-6 mt-2"><strong>Shop Name:</strong> ${item.bill_shop_name}</div>
                            <div class="col-6 mt-2 text-end"><strong>Vehicle Info:</strong> ${item.vehicle_info || 'N/A'}</div>
                        </div>
                        <p><strong>Product Type:</strong> ${item.product_type ? item.product_type.name : 'N/A'}</p>
                        <p><strong>Product Name:</strong> ${item.product ? item.product.product_name : (item.product_name || 'N/A')}</p>
                        <p><strong>Quantity:</strong> ${item.quantity}</p>
                        <p><strong>Unit Price:</strong> ₹${parseFloat(item.unit_price || 0).toFixed(2)}</p>
                        <p><strong>GST Amount:</strong> ₹${parseFloat(item.gst_amount || 0).toFixed(2)}</p>
                        <hr>
                        <p class="fs-6 fw-bold text-success">Total Amount: ₹${parseFloat(item.total_amount || 0).toFixed(2)}</p>
                    `;
                    viewModal.show();
                }
            });
    }

    function printInvoice() {
        window.print();
    }

    async function editSale(id) {
        try {
            const url = `{{ route('admin.sales.edit', ':id') }}`.replace(':id', id);
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const res = await response.json();

            if (res.status && res.data) {
                const item = res.data;
                document.getElementById('saleId').value = item.id || '';
                document.getElementById('userId').value = item.user_id || '';
                document.getElementById('saleDate').value = item.sale_date || '';
                document.getElementById('quantity').value = item.quantity || '';
                document.getElementById('unitPrice').value = item.unit_price || '';
                document.getElementById('gstAmount').value = item.gst_amount || '';
                document.getElementById('totalAmount').value = item.total_amount || '';
                document.getElementById('billShopName').value = item.bill_shop_name || '';
                document.getElementById('vehicleInfo').value = item.vehicle_info || '';
                document.getElementById('productNameHidden').value = item.product_name || '';

                document.getElementById('modalTitle').innerText = 'Edit Daily Sale';
                document.getElementById('saveBtn').innerText = 'Update Record';
                document.getElementById('modalError').classList.add('d-none');

                const wrapper = document.getElementById('productSelectionWrapper');
                if (wrapper) wrapper.classList.remove('d-none');
                
                document.getElementById('productTypeId').value = item.product_type_id || '';

                if (item.product_type_id && item.product_id) {
                    await loadProductsForEdit(item.product_type_id, item.product_id);
                }

                saleModal.show();
            } else {
                alert('Could not retrieve sale details.');
            }
        } catch (error) {
            console.error('Error opening edit modal:', error);
            alert('Failed to load sale record details for editing.');
        }
    }

    function loadProductsForEdit(typeId, preselectProductId) {
        return new Promise((resolve, reject) => {
            const productSelect = $('#productId');
            productSelect.empty().append('<option value="">Loading products...</option>').trigger('change');

            fetch(`{{ route('admin.sales.search-products') }}?product_type_id=${typeId}`)
                .then(res => res.json())
                .then(res => {
                    productSelect.empty().append('<option value="">Select Product...</option>');
                    if (res.status && res.data && res.data.length > 0) {
                        res.data.forEach(prod => {
                            const displayName = prod.size ? `${prod.product_name} (${prod.size})` : prod.product_name;
                            const optionText = `${displayName} [SKU: ${prod.sku || 'N/A'}]`;
                            
                            const newOption = new Option(optionText, prod.id, false, false);
                            $(newOption).data('name', prod.product_name);
                            productSelect.append(newOption);
                        });
                    }
                    productSelect.val(preselectProductId).trigger('change');
                    resolve();
                })
                .catch(err => {
                    productSelect.empty().append('<option value="">Error loading products</option>').trigger('change');
                    reject(err);
                });
        });
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const saleId = document.getElementById('saleId').value;
        const formData = new FormData(e.target);

        const hiddenName = document.getElementById('productNameHidden').value;
        if (hiddenName) {
            formData.set('product_name', hiddenName);
        }

        const data = Object.fromEntries(formData.entries());
        const url = saleId ? `{{ url('admin/daily-sales') }}/${saleId}` : `{{ route('admin.sales.store') }}`;
        const method = saleId ? 'PUT' : 'POST';

        fetch(url, {
                method: method,
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
                loadSales(currentPage);
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
                if (res.status) loadSales(currentPage);
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