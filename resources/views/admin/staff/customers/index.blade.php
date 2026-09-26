@php
    $type = $type ?? request('type', 'customer');
@endphp

@extends('layouts.admin')

@section('title', 'My ' . ucfirst($type) . 's')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">My {{ ucfirst($type) }}s</h4>
            <p class="text-muted small mb-0">Manage and view all {{ $type }} accounts registered under your account.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg me-1"></i> Add New {{ ucfirst($type) }}
        </button>
    </div>

    <div id="ajaxAlertContainer"></div>

    <div class="card card-custom border-0 shadow-sm">
        <div class="card-body p-4">
            
            <form action="{{ url()->current() }}" method="GET" class="row g-3 mb-4">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name or mobile..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="usersTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Owner Name</th>
                            <th>Shop Name</th>
                            <th>Mobile Number</th>
                            <th>GST / Business No</th>
                            <th>Registered Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td class="fw-bold text-dark">{{ $user->name }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $user->shop_name ?? 'N/A' }}</span></td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->gst_number ?? 'N/A' }}</td>
                                <td>{{ $user->created_at->format('d M, Y') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary btn-edit" data-id="{{ $user->id }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="noRecordsRow">
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No {{ $type }}s found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add New {{ ucfirst($type) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="addStaffUserForm">
                @csrf
                <input type="hidden" name="role" value="{{ $type }}">
                
                <div class="modal-body">
                    <div id="modalErrorContainer" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contact Person / Owner Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Rajesh Kumar" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Shop / Business Name</label>
                        <input type="text" name="shop_name" class="form-control" placeholder="e.g. Pillai Tiles">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">GST / Tax Number</label>
                        <input type="text" name="gst_number" class="form-control" placeholder="e.g. 33AAAAA0000A1Z5">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter mobile number" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email (optional)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address / Location</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Enter city/address"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="saveSpinner"></span>
                        Save {{ ucfirst($type) }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit {{ ucfirst($type) }} Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="editStaffUserForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" id="edit_user_id">
                
                <div class="modal-body">
                    <div id="editModalErrorContainer" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contact Person / Owner Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Shop / Business Name</label>
                        <input type="text" name="shop_name" id="edit_shop_name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">GST / Tax Number</label>
                        <input type="text" name="gst_number" id="edit_gst_number" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="edit_mobile_number" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" id="edit_email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address / Location</label>
                        <textarea name="address" id="edit_address" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="updateBtn">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="updateSpinner"></span>
                        Update Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const alertContainer = document.getElementById('ajaxAlertContainer');

    // ==========================================
    // 1. ADD USER VIA AJAX
    // ==========================================
    const addForm = document.getElementById('addStaffUserForm');
    const saveBtn = document.getElementById('saveBtn');
    const saveSpinner = document.getElementById('saveSpinner');
    const addErrorContainer = document.getElementById('modalErrorContainer');
    const addModalEl = document.getElementById('addModal');
    const addBsModal = bootstrap.Modal.getOrCreateInstance(addModalEl);

    if (addForm) {
        addForm.addEventListener('submit', function (e) {
            e.preventDefault();
            addErrorContainer.classList.add('d-none');
            saveBtn.disabled = true;
            saveSpinner.classList.remove('d-none');

            fetch("{{ route('admin.staff.users.store') }}", {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: new FormData(addForm)
            })
            .then(function (res) {
                return res.json().then(function (data) {
                    if (!res.ok) throw data;
                    return data;
                });
            })
            .then(function (data) {
                saveBtn.disabled = false;
                saveSpinner.classList.add('d-none');
                addForm.reset();
                addBsModal.hide();

                alertContainer.innerHTML = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle-fill me-2"></i> ' + data.message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                setTimeout(function () { window.location.reload(); }, 800);
            })
            .catch(function (err) {
                saveBtn.disabled = false;
                saveSpinner.classList.add('d-none');
                addErrorContainer.classList.remove('d-none');
                
                if (err.errors) {
                    var errList = '';
                    Object.values(err.errors).forEach(function (e) { errList += '<li>' + e[0] + '</li>'; });
                    addErrorContainer.innerHTML = '<ul>' + errList + '</ul>';
                } else {
                    addErrorContainer.innerText = 'An error occurred. Please try again.';
                }
            });
        });
    }

    // ==========================================
    // 2. FETCH USER DATA FOR EDIT MODAL
    // ==========================================
    const editModalEl = document.getElementById('editModal');
    const editBsModal = bootstrap.Modal.getOrCreateInstance(editModalEl);
    const editForm = document.getElementById('editStaffUserForm');
    const updateBtn = document.getElementById('updateBtn');
    const updateSpinner = document.getElementById('updateSpinner');
    const editErrorContainer = document.getElementById('editModalErrorContainer');

    document.querySelectorAll('.btn-edit').forEach(function (button) {
        button.addEventListener('click', function () {
            var userId = this.getAttribute('data-id');
            editErrorContainer.classList.add('d-none');

            fetch("{{ url('/admin/staff/users') }}/" + userId + "/edit", {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function (res) { return res.json(); })
            .then(function (response) {
                if (response.status === 'success') {
                    var data = response.data;
                    document.getElementById('edit_user_id').value = data.id;
                    document.getElementById('edit_name').value = data.name || '';
                    document.getElementById('edit_shop_name').value = data.shop_name || '';
                    document.getElementById('edit_gst_number').value = data.gst_number || '';
                    document.getElementById('edit_mobile_number').value = data.phone || '';
                    document.getElementById('edit_email').value = data.email || '';
                    document.getElementById('edit_address').value = data.address || '';

                    editBsModal.show();
                }
            });
        });
    });

    // ==========================================
    // 3. UPDATE USER VIA AJAX
    // ==========================================
    if (editForm) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var userId = document.getElementById('edit_user_id').value;
            editErrorContainer.classList.add('d-none');
            updateBtn.disabled = true;
            updateSpinner.classList.remove('d-none');

            fetch("{{ url('/admin/staff/users') }}/" + userId, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: new FormData(editForm)
            })
            .then(function (res) {
                return res.json().then(function (data) {
                    if (!res.ok) throw data;
                    return data;
                });
            })
            .then(function (data) {
                updateBtn.disabled = false;
                updateSpinner.classList.add('d-none');
                editBsModal.hide();

                alertContainer.innerHTML = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle-fill me-2"></i> ' + data.message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                setTimeout(function () { window.location.reload(); }, 800);
            })
            .catch(function (err) {
                updateBtn.disabled = false;
                updateSpinner.classList.add('d-none');
                editErrorContainer.classList.remove('d-none');

                if (err.errors) {
                    var errList = '';
                    Object.values(err.errors).forEach(function (e) { errList += '<li>' + e[0] + '</li>'; });
                    editErrorContainer.innerHTML = '<ul>' + errList + '</ul>';
                } else {
                    editErrorContainer.innerText = 'Update failed. Please try again.';
                }
            });
        });
    }

});
</script>
@endpush