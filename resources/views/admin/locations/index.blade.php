@extends('layouts.admin')

@section('title', 'Locations Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">Locations Management</h4>
        <p class="text-muted fs-7 mb-0">Manage business branches, shop locations, addresses, and status without page reloads.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-3" onclick="openCreateModal()">
        <i class="bi bi-plus-lg me-1"></i> Add Location
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
                    <th>Location Name</th>
                    <th>City / State</th>
                    <th>Phone / Email</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody id="locationTableBody">
                <tr><td colspan="7" class="text-center py-4">Loading locations...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add / Edit Location Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="locationModalTitle">Add New Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="locationForm">
                @csrf
                <input type="hidden" id="locationId" name="id">
                <div class="modal-body p-4">
                    <div id="modalError" class="alert alert-danger d-none fs-7 py-2"></div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Location / Branch Name <span class="text-danger">*</span></label>
                            <input type="text" id="locationName" name="name" class="form-control" placeholder="e.g. Trichy Main Branch" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">City <span class="text-danger">*</span></label>
                            <input type="text" id="locationCity" name="city" class="form-control" placeholder="e.g. Tiruchirappalli" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">State</label>
                            <input type="text" id="locationState" name="state" class="form-control" placeholder="e.g. Tamil Nadu">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Postal Code</label>
                            <input type="text" id="locationPostalCode" name="postal_code" class="form-control" placeholder="e.g. 620001">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Street Address <span class="text-danger">*</span></label>
                        <input type="text" id="locationAddress" name="address" class="form-control" placeholder="e.g. 12, West Boulevard Road" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Phone Number</label>
                            <input type="text" id="locationPhone" name="phone" class="form-control" placeholder="e.g. +91 9876543210">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold fs-7">Email Address</label>
                            <input type="email" id="locationEmail" name="email" class="form-control" placeholder="e.g. trichy@example.com">
                        </div>
                    </div>

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="locationActive" name="is_active" value="1" checked>
                        <label class="form-check-label fw-semibold fs-7" for="locationActive">Location Active</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary fw-semibold px-4">Save Location</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const locationModal = new bootstrap.Modal(document.getElementById('locationModal'));

    document.addEventListener('DOMContentLoaded', () => {
        loadLocations();
        document.getElementById('locationForm').addEventListener('submit', handleFormSubmit);
    });

    function loadLocations() {
        fetch(`{{ route('admin.locations.fetch') }}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    renderTable(res.data);
                }
            });
    }

    function renderTable(items) {
        const tbody = document.getElementById('locationTableBody');
        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">No locations found.</td></tr>';
            return;
        }

        tbody.innerHTML = items.map((item, index) => `
            <tr>
                <td class="ps-3">${index + 1}</td>
                <td>
                    <div class="fw-semibold text-dark">${item.name}</div>
                    <span class="badge bg-light text-secondary fs-8">${item.slug}</span>
                </td>
                <td>${item.city}${item.state ? ', ' + item.state : ''}</td>
                <td>
                    <div class="fs-8">
                        ${item.phone ? `<div><i class="bi bi-telephone me-1 text-muted"></i>${item.phone}</div>` : ''}
                        ${item.email ? `<div><i class="bi bi-envelope me-1 text-muted"></i>${item.email}</div>` : ''}
                        ${!item.phone && !item.email ? '<span class="text-muted">N/A</span>' : ''}
                    </div>
                </td>
                <td><span class="text-muted fs-8">${item.address}</span></td>
                <td>
                    <span class="badge ${item.is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle'} rounded-pill">
                        ${item.is_active ? 'Active' : 'Inactive'}
                    </span>
                </td>
                <td class="text-end pe-3">
                    <button onclick="openEditModal(${item.id})" class="btn btn-sm btn-light border me-1"><i class="bi bi-pencil-fill text-secondary"></i></button>
                    <button onclick="deleteLocation(${item.id})" class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
        `).join('');
    }

    function openCreateModal() {
        document.getElementById('locationForm').reset();
        document.getElementById('locationId').value = '';
        document.getElementById('locationModalTitle').innerText = 'Add New Location';
        document.getElementById('modalError').classList.add('d-none');
        locationModal.show();
    }

    function openEditModal(id) {
        fetch(`{{ url('admin/locations') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    const item = res.data;
                    document.getElementById('locationId').value = item.id;
                    document.getElementById('locationName').value = item.name;
                    document.getElementById('locationCity').value = item.city;
                    document.getElementById('locationState').value = item.state || '';
                    document.getElementById('locationPostalCode').value = item.postal_code || '';
                    document.getElementById('locationAddress').value = item.address;
                    document.getElementById('locationPhone').value = item.phone || '';
                    document.getElementById('locationEmail').value = item.email || '';
                    document.getElementById('locationActive').checked = !!item.is_active;

                    document.getElementById('locationModalTitle').innerText = 'Edit Location';
                    document.getElementById('modalError').classList.add('d-none');
                    locationModal.show();
                }
            });
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('locationId').value;
        const url = id ? `{{ url('admin/locations') }}/${id}` : `{{ route('admin.locations.store') }}`;
        const method = id ? 'PUT' : 'POST';

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        data.is_active = document.getElementById('locationActive').checked ? 1 : 0;

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
            locationModal.hide();
            showAlert(res.message, 'success');
            loadLocations();
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

    function deleteLocation(id) {
        if (!confirm('Are you sure you want to delete this location?')) return;

        fetch(`{{ url('admin/locations') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            showAlert(res.message, res.status ? 'success' : 'danger');
            if (res.status) loadLocations();
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