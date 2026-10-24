@extends('layouts.admin')

@section('title', 'Product Types Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">Product Types</h4>
        <p class="text-muted fs-7 mb-0">Manage product categories like Tiles, Sanitaryware, Tile Paste, and Sinks.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-3 shadow-sm" onclick="openCreateModal()">
        <i class="bi bi-plus-lg me-1"></i> Add Product Type
    </button>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<!-- Data Table Card -->
<div class="card card-custom bg-white shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-7">
            <thead class="bg-light text-uppercase fs-8 text-secondary">
                <tr>
                    <th class="ps-3 py-3">#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Flag</th>
                    <th>Active</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody id="productTypesTableBody">
                <tr><td colspan="7" class="text-center py-4 text-muted">Loading product types...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Create / Edit Modal -->
<div class="modal fade" id="productTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white px-4 py-3">
                <h5 class="modal-title fw-bold fs-6" id="modalTitle">Add Product Type</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productTypeForm">
                @csrf
                <input type="hidden" id="productTypeId">
                <div class="modal-body p-4">
                    <div id="modalError" class="alert alert-danger d-none fs-7 py-2"></div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-secondary">Type Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="typeName" class="form-control bg-light" placeholder="e.g. Sanitaryware, Sink" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7 text-secondary">Status</label>
                            <select name="status" id="typeStatus" class="form-select bg-light">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7 text-secondary">Flag</label>
                            <input type="text" name="flag" id="typeFlag" class="form-control bg-light" placeholder="e.g. Featured">
                        </div>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="typeIsActive" value="1" checked>
                        <label class="form-check-label fw-semibold fs-7 text-secondary" for="typeIsActive">Is Active</label>
                    </div>

                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-light border px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm" id="saveBtn">Save Type</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const typeModal = new bootstrap.Modal(document.getElementById('productTypeModal'));

    document.addEventListener('DOMContentLoaded', () => {
        loadProductTypes();
        document.getElementById('productTypeForm').addEventListener('submit', handleFormSubmit);
    });

    function loadProductTypes() {
        fetch(`{{ route('admin.product-types.fetch') }}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    renderTable(res.data);
                }
            });
    }

    function renderTable(items) {
        const tbody = document.getElementById('productTypesTableBody');
        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">No product types found.</td></tr>';
            return;
        }

        tbody.innerHTML = items.map((item, index) => `
            <tr>
                <td class="ps-3">${index + 1}</td>
                <td><span class="fw-bold text-dark">${item.name}</span></td>
                <td><code class="text-muted">${item.slug}</code></td>
                <td><span class="badge bg-${item.status === 'active' ? 'success' : 'secondary'}-subtle text-${item.status === 'active' ? 'success' : 'secondary'} border">${item.status}</span></td>
                <td>${item.flag ? `<span class="badge bg-info-subtle text-info border">${item.flag}</span>` : '<span class="text-muted">N/A</span>'}</td>
                <td>
                    <span class="badge bg-${item.is_active ? 'success' : 'danger'}">${item.is_active ? 'Yes' : 'No'}</span>
                </td>
                <td class="text-end pe-3">
                    <button onclick="openEditModal(${item.id})" class="btn btn-sm btn-light border text-primary me-1"><i class="bi bi-pencil-fill"></i></button>
                    <button onclick="deleteProductType(${item.id})" class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
        `).join('');
    }

    function openCreateModal() {
        document.getElementById('productTypeForm').reset();
        document.getElementById('productTypeId').value = '';
        document.getElementById('modalTitle').innerText = 'Add Product Type';
        document.getElementById('saveBtn').innerText = 'Save Type';
        document.getElementById('modalError').classList.add('d-none');
        typeModal.show();
    }

    function openEditModal(id) {
        fetch(`{{ url('admin/product-types') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    const item = res.data;
                    document.getElementById('productTypeId').value = item.id;
                    document.getElementById('typeName').value = item.name;
                    document.getElementById('typeStatus').value = item.status;
                    document.getElementById('typeFlag').value = item.flag || '';
                    document.getElementById('typeIsActive').checked = item.is_active == 1;

                    document.getElementById('modalTitle').innerText = 'Edit Product Type';
                    document.getElementById('saveBtn').innerText = 'Update Type';
                    document.getElementById('modalError').classList.add('d-none');
                    typeModal.show();
                }
            });
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('productTypeId').value;
        const url = id ? `{{ url('admin/product-types') }}/${id}` : `{{ route('admin.product-types.store') }}`;
        const method = id ? 'PUT' : 'POST';

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        data.is_active = document.getElementById('typeIsActive').checked ? 1 : 0;

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
            typeModal.hide();
            showAlert(res.message, 'success');
            loadProductTypes();
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

    function deleteProductType(id) {
        if (!confirm('Are you sure you want to delete this product type?')) return;

        fetch(`{{ url('admin/product-types') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            showAlert(res.message, res.status ? 'success' : 'danger');
            if (res.status) loadProductTypes();
        });
    }

    function showAlert(msg, type) {
        document.getElementById('alertContainer').innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show fs-7 shadow-sm" role="alert">
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    }
</script>
@endpush