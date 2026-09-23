@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">User Management</h4>
        <p class="text-muted fs-7 mb-0">Manage system users seamlessly with dynamic AJAX operations.</p>
    </div>
    <button class="btn btn-primary fw-semibold px-3" onclick="openCreateModal()">
        <i class="bi bi-plus-lg me-1"></i> Add New User
    </button>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<!-- Filter Card -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form id="filterForm" class="row g-2">
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" id="filterSearch" class="form-control border-start-0" placeholder="Search by name, email, phone...">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <select id="filterRole" class="form-select">
                    <option value="">All Roles</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    <option value="dealer">Dealer</option>
                    <option value="customer">Customer</option>
                </select>
            </div>
            <!-- Location Filter Dropdown -->
            <div class="col-12 col-md-3">
                <select id="filterLocation" class="form-select">
                    <option value="">All Locations</option>
                    @foreach($locations as $loc)
                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100 fw-semibold">Filter</button>
                <button type="button" id="resetFilter" class="btn btn-light border w-100">Reset</button>
            </div>
        </form>
    </div>
</div>

<!-- User Table -->
<div class="card card-custom bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-7">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3 py-3">User</th>
                    <th>Role</th>
                    <th>Location</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <tr>
                    <td colspan="6" class="text-center py-4">Loading data...</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-top py-3 px-3 d-flex justify-content-between align-items-center" id="paginationContainer"></div>
</div>

<!-- Add/Edit User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="userModalTitle">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userForm">
                @csrf
                <input type="hidden" id="userId" name="id">
                <div class="modal-body p-4">
                    <div id="modalError" class="alert alert-danger d-none fs-7 py-2"></div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Full Name <span class="text-danger">*</span></label>
                        <input type="text" id="userName" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Email Address <span class="text-danger">*</span></label>
                        <input type="email" id="userEmail" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Phone Number</label>
                        <input type="text" id="userPhone" name="phone" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7">Role <span class="text-danger">*</span></label>
                        <select id="userRole" name="role" class="form-select" required>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="dealer">Dealer</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>

                    <!-- Location Dropdown Select -->
                    <select id="userLocation" name="location_id" class="form-select">
                        <option value="">-- No Location Assigned --</option>
                        @if(isset($locations) && $locations->count() > 0)
                        @foreach($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }} @if(!empty($loc->city)) ({{ $loc->city }}) @endif</option>
                        @endforeach
                        @endif
                    </select>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7" id="passwordLabel">Password <span class="text-danger">*</span></label>
                        <input type="password" id="userPassword" name="password" class="form-control">
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="userActive" name="is_active" value="1" checked>
                        <label class="form-check-label fw-semibold fs-7" for="userActive">Account Active</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary fw-semibold px-4">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const userModal = new bootstrap.Modal(document.getElementById('userModal'));
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', () => {
        loadUsers();

        document.getElementById('filterForm').addEventListener('submit', (e) => {
            e.preventDefault();
            currentPage = 1;
            loadUsers();
        });

        document.getElementById('resetFilter').addEventListener('click', () => {
            document.getElementById('filterSearch').value = '';
            document.getElementById('filterRole').value = '';
            document.getElementById('filterLocation').value = '';
            currentPage = 1;
            loadUsers();
        });

        document.getElementById('userForm').addEventListener('submit', handleFormSubmit);
    });

    // Fetch and render list dynamically
    function loadUsers(page = currentPage) {
        currentPage = page;
        const search = document.getElementById('filterSearch').value;
        const role = document.getElementById('filterRole').value;
        const locationId = document.getElementById('filterLocation').value;

        fetch(`{{ route('admin.users.fetch') }}?page=${page}&search=${encodeURIComponent(search)}&role=${encodeURIComponent(role)}&location_id=${encodeURIComponent(locationId)}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    renderTable(res.data.data);
                    renderPagination(res.data);
                }
            });
    }

    function renderTable(users) {
        const tbody = document.getElementById('userTableBody');
        if (users.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No users found.</td></tr>';
            return;
        }

        tbody.innerHTML = users.map(user => `
            <tr>
                <td class="ps-3 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-secondary bg-opacity-10 text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                            ${user.name.substring(0, 2).toUpperCase()}
                        </div>
                        <div>
                            <div class="fw-semibold text-dark">${user.name}</div>
                            <div class="text-muted fs-8">${user.email}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge bg-primary">${user.role.toUpperCase()}</span></td>
                <td>
                    ${user.location 
                        ? `<span class="badge bg-info-subtle text-info border border-info-subtle"><i class="bi bi-geo-alt me-1"></i>${user.location.name}</span>` 
                        : '<span class="badge bg-light text-muted border">Unassigned</span>'
                    }
                </td>
                <td>${user.phone || 'N/A'}</td>
                <td>
                    <span class="badge ${user.is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle'} rounded-pill">
                        ${user.is_active ? 'Active' : 'Inactive'}
                    </span>
                </td>
                <td class="text-end pe-3">
                    <button onclick="openEditModal(${user.id})" class="btn btn-sm btn-light border me-1"><i class="bi bi-pencil-fill text-secondary"></i></button>
                    <button onclick="deleteUser(${user.id})" class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash-fill"></i></button>
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
        if (data.prev_page_url) {
            buttons += `<button onclick="loadUsers(${data.current_page - 1})" class="btn btn-sm btn-light border">Previous</button>`;
        }
        buttons += `<span class="mx-2 fs-7 text-muted">Page ${data.current_page} of ${data.last_page}</span>`;
        if (data.next_page_url) {
            buttons += `<button onclick="loadUsers(${data.current_page + 1})" class="btn btn-sm btn-light border">Next</button>`;
        }

        container.innerHTML = `<div><span class="text-muted fs-7">Total: ${data.total}</span></div><div>${buttons}</div>`;
    }

    function openCreateModal() {
        document.getElementById('userForm').reset();
        document.getElementById('userId').value = '';
        document.getElementById('userLocation').value = '';
        document.getElementById('userModalTitle').innerText = 'Add New User';
        document.getElementById('passwordLabel').innerHTML = 'Password <span class="text-danger">*</span>';
        document.getElementById('userPassword').required = true;
        document.getElementById('modalError').classList.add('d-none');
        userModal.show();
    }

    function openEditModal(id) {
        fetch(`{{ url('admin/users') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    const u = res.data;
                    document.getElementById('userId').value = u.id;
                    document.getElementById('userName').value = u.name;
                    document.getElementById('userEmail').value = u.email;
                    document.getElementById('userPhone').value = u.phone || '';
                    document.getElementById('userRole').value = u.role;
                    document.getElementById('userLocation').value = u.location_id || '';
                    document.getElementById('userActive').checked = !!u.is_active;
                    document.getElementById('userModalTitle').innerText = 'Edit User';
                    document.getElementById('passwordLabel').innerHTML = 'New Password <small class="text-muted fw-normal">(Leave blank to keep current)</small>';
                    document.getElementById('userPassword').required = false;
                    document.getElementById('modalError').classList.add('d-none');
                    userModal.show();
                }
            });
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('userId').value;
        const url = id ? `{{ url('admin/users') }}/${id}` : `{{ route('admin.users.store') }}`;
        const method = id ? 'PUT' : 'POST';

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        data.is_active = document.getElementById('userActive').checked ? 1 : 0;

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
                userModal.hide();
                showAlert(res.message, 'success');
                loadUsers();
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

    function deleteUser(id) {
        if (!confirm('Are you sure you want to delete this user?')) return;

        fetch(`{{ url('admin/users') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                showAlert(res.message, res.status ? 'success' : 'danger');
                if (res.status) loadUsers();
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