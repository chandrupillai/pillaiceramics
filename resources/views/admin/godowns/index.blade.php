@extends('layouts.admin')

@section('title', 'Godown Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">Godown Management</h4>
        <p class="text-muted fs-7 mb-0">Manage warehouses and godown locations seamlessly.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-3" onclick="openCreateModal()">
        <i class="bi bi-plus-lg me-1"></i> Add New Godown
    </button>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<!-- Filter Card -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form id="filterForm" class="row g-2">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" id="filterSearch" class="form-control border-start-0" placeholder="Search by name, code, incharge...">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <select id="filterLocation" class="form-select">
                    <option value="">All Locations</option>
                    @if(isset($locations) &&$locations->count() > 0)
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100 fw-semibold">Filter</button>
                <button type="button" id="resetFilter" class="btn btn-light border w-100">Reset</button>
            </div>
        </form>
    </div>
</div>

<!-- Godown Table -->
<div class="card card-custom bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-7">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3 py-3">Godown Name</th>
                    <th>Code</th>
                    <th>Location</th>
                    <th>Incharge Person</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody id="godownTableBody">
                <tr><td colspan="6" class="text-center py-4">Loading data...</td></tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-top py-3 px-3 d-flex justify-content-between align-items-center" id="paginationContainer"></div>
</div>

<!-- Add/Edit Godown Modal -->
<div class="modal fade" id="godownModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="godownModalTitle">Add New Godown</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="godownForm">
                @csrf
                <input type="hidden" id="godownId" name="id">
                <div class="modal-body p-4">
                    <div id="modalError" class="alert alert-danger d-none fs-7 py-2"></div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Assigned Location <span class="text-danger">*</span></label>
                        <select id="godownLocation" name="location_id" class="form-select" required>
                            <option value="">-- Select Location --</option>
                            @if(isset($locations) &&$locations->count() > 0)
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->name }} @if(!empty($loc->city)) ({{$loc->city }}) @endif</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Godown Name <span class="text-danger">*</span></label>
                        <input type="text" id="godownName" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Godown Code <span class="text-danger">*</span></label>
                        <input type="text" id="godownCode" name="code" class="form-control" required placeholder="e.g. GD-NORTH-01">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Incharge Person</label>
                        <input type="text" id="godownInchargePerson" name="incharge_person" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Contact Number</label>
                        <input type="text" id="godownContactNumber" name="contact_number" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Address</label>
                        <textarea id="godownAddress" name="address" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="godownActive" name="is_active" value="1" checked>
                        <label class="form-check-label fw-semibold fs-7" for="godownActive">Active Status</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary fw-semibold px-4">Save Godown</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const godownModal = new bootstrap.Modal(document.getElementById('godownModal'));
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', () => {
        loadGodowns();

        document.getElementById('filterForm').addEventListener('submit', (e) => {
            e.preventDefault();
            currentPage = 1;
            loadGodowns();
        });

        document.getElementById('resetFilter').addEventListener('click', () => {
            document.getElementById('filterSearch').value = '';
            document.getElementById('filterLocation').value = '';
            currentPage = 1;
            loadGodowns();
        });

        document.getElementById('godownForm').addEventListener('submit', handleFormSubmit);
    });

    function loadGodowns(page = currentPage) {
        currentPage = page;
        const search = document.getElementById('filterSearch').value;
        const locationId = document.getElementById('filterLocation').value;

        fetch(`{{ route('admin.godowns.fetch') }}?page=${page}&search=${encodeURIComponent(search)}&location_id=${encodeURIComponent(locationId)}`)
            .then(res => res.json())
            .then(res => {
                if(res.status) {
                    renderTable(res.data.data);
                    renderPagination(res.data);
                }
            });
    }

    function renderTable(godowns) {
        const tbody = document.getElementById('godownTableBody');
        if (godowns.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No godowns found.</td></tr>';
            return;
        }

        tbody.innerHTML = godowns.map(g => `
            <tr>
                <td class="ps-3 py-3">
                    <div class="fw-semibold text-dark">${g.name}</div>
                    <div class="text-muted fs-8">${g.address || 'No address specified'}</div>
                </td>
                <td><span class="badge bg-secondary-subtle text-secondary border">${g.code}</span></td>
                <td>
                    ${g.location 
                        ? `<span class="badge bg-info-subtle text-info border border-info-subtle"><i class="bi bi-geo-alt me-1"></i>${g.location.name}</span>` 
                        : '<span class="badge bg-light text-muted border">Unassigned</span>'
                    }
                </td>
                <td>
                    <div>${g.incharge_person || 'N/A'}</div>
                    <div class="text-muted fs-8">${g.contact_number || ''}</div>
                </td>
                <td>
                    <span class="badge ${g.is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle'} rounded-pill">
                        ${g.is_active ? 'Active' : 'Inactive'}
                    </span>
                </td>
                <td class="text-end pe-3">
                    <button onclick="openEditModal(${g.id})" class="btn btn-sm btn-light border me-1"><i class="bi bi-pencil-fill text-secondary"></i></button>
                    <button onclick="deleteGodown(${g.id})" class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
        `).join('');
    }

    function renderPagination(data) {
        const container = document.getElementById('paginationContainer');
        if (data.total <= data.per_page) {
            container.innerHTML = `<span class="text-muted fs-7">Showing ${data.total} entries</span>`;
            return;
        }

        let buttons = '';
        if(data.prev_page_url) {
            buttons += `<button onclick="loadGodowns(${data.current_page - 1})" class="btn btn-sm btn-light border">Previous</button>`;
        }
        buttons += `<span class="mx-2 fs-7 text-muted">Page ${data.current_page} of ${data.last_page}</span>`;
        if(data.next_page_url) {
            buttons += `<button onclick="loadGodowns(${data.current_page + 1})" class="btn btn-sm btn-light border">Next</button>`;
        }

        container.innerHTML = `<div><span class="text-muted fs-7">Total: ${data.total}</span></div><div>${buttons}</div>`;
    }

    function openCreateModal() {
        document.getElementById('godownForm').reset();
        document.getElementById('godownId').value = '';
        document.getElementById('godownLocation').value = '';
        document.getElementById('godownModalTitle').innerText = 'Add New Godown';
        document.getElementById('modalError').classList.add('d-none');
        godownModal.show();
    }

    function openEditModal(id) {
        fetch(`{{ url('admin/godowns') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if(res.status) {
                    const g = res.data;
                    document.getElementById('godownId').value = g.id;
                    document.getElementById('godownLocation').value = g.location_id;
                    document.getElementById('godownName').value = g.name;
                    document.getElementById('godownCode').value = g.code;
                    document.getElementById('godownInchargePerson').value = g.incharge_person || '';
                    document.getElementById('godownContactNumber').value = g.contact_number || '';
                    document.getElementById('godownAddress').value = g.address || '';
                    document.getElementById('godownActive').checked = !!g.is_active;
                    document.getElementById('godownModalTitle').innerText = 'Edit Godown';
                    document.getElementById('modalError').classList.add('d-none');
                    godownModal.show();
                }
            });
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('godownId').value;
        const url = id ? `{{ url('admin/godowns') }}/${id}` : `{{ route('admin.godowns.store') }}`;
        const method = id ? 'PUT' : 'POST';

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        data.is_active = document.getElementById('godownActive').checked ? 1 : 0;

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
            godownModal.hide();
            showAlert(res.message, 'success');
            loadGodowns();
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

    function deleteGodown(id) {
        if(!confirm('Are you sure you want to delete this godown?')) return;

        fetch(`{{ url('admin/godowns') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            showAlert(res.message, res.status ? 'success' : 'danger');
            if(res.status) loadGodowns();
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