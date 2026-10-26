@extends('layouts.admin')

@section('title', 'Edit Whole Sale Invoice')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Whole Sale Invoice</h4>
        <p class="text-muted fs-7 mb-0">Modify invoice details and product items for <strong>{{ $billShopName }}</strong>.</p>
    </div>
    <a href="{{ route('admin.whole-sales.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Back to Whole Sales
    </a>
</div>

<div id="alertContainer"></div>

<form id="wholeSaleEditForm">
    @csrf
    @method('PUT')
    <input type="hidden" name="old_date" value="{{ $date }}">

    <!-- Invoice Header Card -->
    <div class="card card-custom bg-white shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-receipt me-2 text-primary"></i>Invoice & Transport Details</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold fs-7">Sales Person <span class="text-danger">*</span></label>
                    <select name="user_id" class="form-select" required>
                        <option value="">Select Sales Person</option>
                        @foreach($staffMembers as $staff)
                            <option value="{{ $staff->id }}" {{ $sales->first()->user_id == $staff->id ? 'selected' : '' }}>{{ $staff->name }} ({{ ucfirst($staff->role) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold fs-7">Sale Date <span class="text-danger">*</span></label>
                    <input type="date" name="sale_date" class="form-control" value="{{ $sales->first()->sale_date }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold fs-7">Bill Shop Name <span class="text-danger">*</span></label>
                    <input type="text" name="bill_shop_name" class="form-control" value="{{ $billShopName }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold fs-7">Vehicle Info</label>
                    <input type="text" name="vehicle_info" class="form-control" value="{{ $sales->first()->vehicle_info }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Items Table Card -->
    <div class="card card-custom bg-white shadow-sm border-0 mb-4">
        <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0"><i class="bi bi-boxes me-2 text-primary"></i>Products List</h6>
            <button type="button" class="btn btn-sm btn-primary fw-semibold" onclick="addRow()">
                <i class="bi bi-plus-lg me-1"></i> Add Row
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 fs-7">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="ps-3" style="width: 5%;">#</th>
                            <th style="width: 25%;">Product Type <span class="text-danger">*</span></th>
                            <th style="width: 45%;">Product Name / SKU <span class="text-danger">*</span></th>
                            <th style="width: 20%;">Quantity <span class="text-danger">*</span></th>
                            <th class="text-end pe-3" style="width: 5%;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="salesRowsContainer">
                        <!-- Populated via JS -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
            <span class="text-muted fs-7" id="rowCountText">Showing 0 items</span>
            <button type="submit" class="btn btn-success fw-semibold px-4">
                <i class="bi bi-check-circle me-1"></i> Update Whole Sale Invoice
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let rowIndex = 0;
    const maxRows = 25;
    const productTypes = @json($productTypes);
    const existingSales = @json($sales);

    document.addEventListener('DOMContentLoaded', () => {
        if (existingSales.length > 0) {
            existingSales.forEach(sale => {
                addRow(sale.product_type_id, sale.product_id, sale.quantity);
            });
        } else {
            addRow();
        }

        document.getElementById('wholeSaleEditForm').addEventListener('submit', handleFormSubmit);
    });

    function addRow(preselectTypeId = '', preselectProductId = '', quantity = '') {
        const tbody = document.getElementById('salesRowsContainer');
        const currentRows = tbody.querySelectorAll('tr').length;

        if (currentRows >= maxRows) {
            alert('Maximum limit of 25 rows reached.');
            return;
        }

        const tr = document.createElement('tr');
        tr.dataset.index = rowIndex;
        tr.innerHTML = `
            <td class="ps-3 row-number">${currentRows + 1}</td>
            <td>
                <select name="items[${rowIndex}][product_type_id]" class="form-select form-select-sm product-type-select" required onchange="onRowTypeChange(this, ${rowIndex})">
                    <option value="">Select Type</option>
                    ${productTypes.map(t => `<option value="${t.id}" ${t.id == preselectTypeId ? 'selected' : ''}>${t.name}</option>`).join('')}
                </select>
            </td>
            <td>
                <select name="items[${rowIndex}][product_id]" class="form-select form-select-sm product-select" id="product_select_${rowIndex}" required style="width: 100%;">
                    <option value="">Select Product...</option>
                </select>
            </td>
            <td>
                <input type="number" step="0.01" name="items[${rowIndex}][quantity]" class="form-control form-control-sm" value="${quantity}" placeholder="Qty" required>
            </td>
            <td class="text-end pe-3">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);

        const productSelect = $(`#product_select_${rowIndex}`);
        productSelect.select2({
            theme: 'bootstrap-5',
            placeholder: 'Search product...',
            allowClear: true
        });

        if (preselectTypeId) {
            loadProductsForEditRow(preselectTypeId, rowIndex, preselectProductId);
        }

        rowIndex++;
        updateRowNumbers();
    }

    function loadProductsForEditRow(typeId, idx, preselectProductId) {
        const productSelect = $(`#product_select_${idx}`);
        productSelect.empty().append('<option value="">Loading products...</option>').trigger('change');

        fetch(`{{ route('admin.sales.search-products') }}?product_type_id=${typeId}`)
            .then(res => res.json())
            .then(res => {
                productSelect.empty().append('<option value="">Select Product...</option>');
                if (res.status && res.data.length > 0) {
                    res.data.forEach(prod => {
                        const displayName = prod.size ? `${prod.product_name} (${prod.size})` : prod.product_name;
                        const optionText = `${displayName} [SKU: ${prod.sku || 'N/A'}]`;
                        productSelect.append(new Option(optionText, prod.id, false, false));
                    });
                }
                productSelect.val(preselectProductId).trigger('change');
            });
    }

    function removeRow(btn) {
        const tbody = document.getElementById('salesRowsContainer');
        if (tbody.querySelectorAll('tr').length <= 1) {
            alert('At least one product row is required.');
            return;
        }
        btn.closest('tr').remove();
        updateRowNumbers();
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('#salesRowsContainer tr');
        rows.forEach((row, idx) => {
            row.querySelector('.row-number').innerText = idx + 1;
        });
        document.getElementById('rowCountText').innerText = `Showing ${rows.length} item(s)`;
    }

    function onRowTypeChange(selectElem, idx) {
        loadProductsForEditRow(selectElem.value, idx, '');
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const formData = new FormData(e.target);

        const data = {
            old_date: formData.get('old_date'),
            user_id: formData.get('user_id'),
            sale_date: formData.get('sale_date'),
            bill_shop_name: formData.get('bill_shop_name'),
            vehicle_info: formData.get('vehicle_info'),
            items: []
        };

        const rows = document.querySelectorAll('#salesRowsContainer tr');
        rows.forEach(row => {
            const index = row.dataset.index;
            data.items.push({
                product_type_id: row.querySelector(`[name="items[${index}][product_type_id]"]`).value,
                product_id: row.querySelector(`[name="items[${index}][product_id]"]`).value,
                quantity: row.querySelector(`[name="items[${index}][quantity]"]`).value,
            });
        });

        fetch(`{{ route('admin.whole-sales.update', $billShopName) }}`, {
            method: 'PUT',
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
            window.location.href = res.redirect;
        })
        .catch(err => {
            alert(err.message || 'Validation error while updating wholesale invoice.');
        });
    }
</script>
@endpush