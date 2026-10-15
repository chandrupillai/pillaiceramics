@extends('layouts.admin')

@section('title', 'Staff Management')

@section('content')
<div class="container-fluid py-2">

    <!-- Page Header & Actions -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-shield-lock-fill text-primary me-2"></i>Staff Members
            </h4>
            <p class="text-muted fs-7 mb-0">Manage system staff accounts, credentials, access roles, and profiles.</p>
        </div>
        <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" id="btnCreateStaff">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Add New Staff</span>
        </button>
    </div>

    <!-- Filter & Search Card -->
    <div class="card card-custom mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="staffSearch" class="form-control border-start-0 ps-0" placeholder="Search by name, email, or phone...">
                    </div>
                </div>
                <div class="col-md-6 col-lg-8 text-md-end">
                    <span class="badge bg-light text-dark border px-3 py-2 fs-7 fw-normal" id="totalCountBadge">
                        Total Staff: <strong>{{ count($staff) }}</strong>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Data Table Card -->
    <div class="card card-custom shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="staffTable">
                    <thead class="table-light border-bottom">
                        <tr class="text-uppercase fs-8 text-secondary fw-bold">
                            <th class="ps-4" style="width: 80px;">ID</th>
                            <th>Staff Member</th>
                            <th>Contact Info</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                            <th class="text-end pe-4" style="width: 170px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fs-7">
                        @forelse($staff as $member)
                        <tr id="row-{{ $member->id }}" class="staff-row">
                            <td class="ps-4 fw-bold text-secondary">#{{ $member->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if(optional($member->profile)->photo)
                                    <img src="{{ asset('storage/' . $member->profile->photo) }}" alt="{{ $member->name }}" class="rounded-circle object-fit-cover" style="width: 36px; height: 36px;">
                                    @else
                                    <div class="bg-primary-subtle text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 0.85rem;">
                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                    </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark staff-name">{{ $member->name }}</div>
                                        <small class="text-muted fs-8">Role: {{ ucfirst($member->role ?? 'Staff') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark staff-email"><i class="bi bi-envelope text-muted me-1"></i>{{ $member->email }}</div>
                                <small class="text-muted staff-phone"><i class="bi bi-telephone text-muted me-1"></i>{{ $member->phone ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 fs-8">
                                    <i class="bi bi-person-check me-1"></i>{{ $member->creator?->name ?? 'System Admin' }}
                                </span>
                            </td>
                            <td class="text-muted">
                                {{ $member->created_at ? $member->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <!-- Digital Visiting Card Button -->
                                    <a href="{{ route('staff.digital-card', $member->slug) }}"
                                        target="_blank"
                                        class="btn btn-outline-info"
                                        title="View Digital Visiting Card">
                                        <i class="bi bi-person-badge-fill"></i>
                                    </a>
                                    <button type="button"
                                        onclick="toggleLeadership('{{ $member->id }}', this)"
                                        class="btn btn-sm {{ $member->show_in_leadership ? 'btn-success' : 'btn-outline-secondary' }}">
                                        <i class="fas fa-star"></i>

                                    </button>
                                    <!-- EDIT BUTTON -->
                                    <button type="button" class="btn btn-outline-primary btn-edit" data-id="{{ $member->id }}" title="Edit Staff">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- DELETE BUTTON -->
                                    <button type="button" class="btn btn-outline-danger btn-delete" data-id="{{ $member->id }}" title="Delete Staff">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="noDataRow">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-1 text-secondary d-block mb-2"></i>
                                <span>No staff members found.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($staff, 'hasPages') && $staff->hasPages())
        <div class="card-footer bg-white border-top py-3">
            {{ $staff->links() }}
        </div>
        @endif
    </div>
</div>

<!-- ========================================================================= -->
<!-- AJAX CREATE / EDIT STAFF MODAL                                            -->
<!-- ========================================================================= -->
<div class="modal fade" id="staffModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fs-6 fw-bold" id="modalTitle">
                    <i class="bi bi-person-plus-fill me-2"></i>Add New Staff
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="staffForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="staff_id" name="staff_id">
                <div class="modal-body p-4">

                    <!-- Validation Errors Alert -->
                    <div class="alert alert-danger d-none py-2 px-3 fs-7" id="errorBox"></div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control fs-7" id="name" name="name" placeholder="John Doe" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control fs-7" id="email" name="email" placeholder="staff@pillaiceramics.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control fs-7" id="phone" name="phone" placeholder="+91 9876543210">
                        </div>
                    </div>

                    <!-- NEW: Bio Field -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Bio / Professional Summary</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light align-items-start pt-2"><i class="bi bi-card-text"></i></span>
                            <textarea class="form-control fs-7" id="bio" name="bio" rows="3" placeholder="Enter brief professional bio..."></textarea>
                        </div>
                    </div>

                    <!-- NEW: Photo Upload Field -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Profile Photo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-image"></i></span>
                            <input type="file" class="form-control fs-7" id="photo" name="photo" accept="image/*">
                        </div>
                        <div id="photoPreviewContainer" class="mt-2 d-none">
                            <small class="text-muted d-block mb-1">Current Photo:</small>
                            <img id="currentPhotoPreview" src="" alt="Photo" class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">
                            Password <span id="pwdRequired" class="text-danger">*</span>
                            <small class="text-muted fw-normal" id="pwdHelp">(Min 6 characters)</small>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control fs-7" id="password" name="password" placeholder="••••••••">
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary fs-7" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fs-7 px-4 d-flex align-items-center gap-2" id="saveBtn">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include jQuery for AJAX operations -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {

        // Initialize Bootstrap Modal Instance
        const staffModalEl = document.getElementById('staffModal');
        const staffModal = new bootstrap.Modal(staffModalEl);

        // Setup global CSRF header for jQuery AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // -------------------------------------------------------------------------
        // 1. Client-Side Live Search
        // -------------------------------------------------------------------------
        $('#staffSearch').on('keyup', function() {
            let value = $(this).val().toLowerCase().trim();
            let visibleRows = 0;

            $('.staff-row').each(function() {
                let name = $(this).find('.staff-name').text().toLowerCase();
                let email = $(this).find('.staff-email').text().toLowerCase();
                let phone = $(this).find('.staff-phone').text().toLowerCase();

                if (name.includes(value) || email.includes(value) || phone.includes(value)) {
                    $(this).show();
                    visibleRows++;
                } else {
                    $(this).hide();
                }
            });

            if (visibleRows === 0 && value !== '') {
                if ($('#searchEmptyRow').length === 0) {
                    $('#staffTable tbody').append(`
                    <tr id="searchEmptyRow">
                        <td colspan="6" class="text-center py-4 text-muted">No staff members matching "${value}".</td>
                    </tr>
                `);
                }
            } else {
                $('#searchEmptyRow').remove();
            }
        });

        // -------------------------------------------------------------------------
        // 2. Open Create Staff Modal
        // -------------------------------------------------------------------------
        $('#btnCreateStaff').click(function() {
            $('#staffForm')[0].reset();
            $('#staff_id').val('');
            $('#modalTitle').html('<i class="bi bi-person-plus-fill me-2"></i>Add New Staff');
            $('#pwdRequired').removeClass('d-none');
            $('#pwdHelp').text('(Min 6 characters)');
            $('#photoPreviewContainer').addClass('d-none');
            $('#currentPhotoPreview').attr('src', '');
            $('#errorBox').addClass('d-none').html('');
            staffModal.show();
        });

        // -------------------------------------------------------------------------
        // 3. Open Edit Staff Modal (Fetch record via AJAX)
        // -------------------------------------------------------------------------
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $('#errorBox').addClass('d-none').html('');
            $('#staffForm')[0].reset();

            $.ajax({
                url: '/admin/users/' + id + '/edit',
                type: 'GET',
                success: function(res) {
                    if (res.success) {
                        $('#staff_id').val(res.data.id);
                        $('#name').val(res.data.name);
                        $('#email').val(res.data.email);
                        $('#phone').val(res.data.phone);
                        $('#bio').val(res.data.profile ? res.data.profile.bio : '');
                        $('#password').val('');

                        // Show photo preview if exists in profile
                        if (res.data.profile && res.data.profile.photo) {
                            $('#currentPhotoPreview').attr('src', '/storage/' + res.data.profile.photo);
                            $('#photoPreviewContainer').removeClass('d-none');
                        } else {
                            $('#photoPreviewContainer').addClass('d-none');
                        }

                        // Modify password requirements for editing mode
                        $('#modalTitle').html('<i class="bi bi-pencil-square me-2"></i>Edit Staff Member');
                        $('#pwdRequired').addClass('d-none');
                        $('#pwdHelp').text('(Leave blank to keep unchanged)');

                        staffModal.show();
                    }
                },
                error: function() {
                    alert('Failed to load staff details. Please refresh the page.');
                }
            });
        });

        // -------------------------------------------------------------------------
        // 4. Save/Update Staff (Submit Form via AJAX with FormData for File Upload)
        // -------------------------------------------------------------------------
        $('#staffForm').submit(function(e) {
            e.preventDefault();

            let id = $('#staff_id').val();
            let url = id ? '/admin/staff/' + id + '/update' : '{{ route("admin.staff.store") }}';

            // Use FormData object to support file upload & bio
            let formData = new FormData(this);

            let $saveBtn = $('#saveBtn');
            $saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false, // Required for FormData
                contentType: false, // Required for FormData
                success: function(res) {
                    $saveBtn.prop('disabled', false).html('<i class="bi bi-check-circle-fill"></i> Save Changes');
                    if (res.success) {
                        staffModal.hide();
                        location.reload(); // Reload to refresh grid & profile data
                    }
                },
                error: function(xhr) {
                    $saveBtn.prop('disabled', false).html('<i class="bi bi-check-circle-fill"></i> Save Changes');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorHtml = '<ul class="mb-0 ps-3">';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul>';
                        $('#errorBox').removeClass('d-none').html(errorHtml);
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });

        // -------------------------------------------------------------------------
        // 5. Delete Staff Record via AJAX
        // -------------------------------------------------------------------------
        $(document).on('click', '.btn-delete', function() {
            if (!confirm('Are you sure you want to delete this staff member? This action cannot be undone.')) {
                return;
            }

            let id = $(this).data('id');
            let $row = $('#row-' + id);

            $.ajax({
                url: '/admin/users/' + id + '/delete',
                type: 'DELETE',
                success: function(res) {
                    if (res.success) {
                        $row.fadeOut(300, function() {
                            $(this).remove();
                            if ($('.staff-row:visible').length === 0) {
                                location.reload();
                            }
                        });
                    }
                },
                error: function() {
                    alert('Failed to delete user. Please try again.');
                }
            });
        });

    });

    function toggleLeadership(userId, buttonElement) {
        $.ajax({
            url: '/admin/users/' + userId + '/toggle-leadership',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    let btn = $(buttonElement);
                    if (response.show_in_leadership == 1) {
                        btn.removeClass('btn-outline-secondary').addClass('btn-success');
                        btn.find('.status-text').text('Shown on Leadership');
                    } else {
                        btn.removeClass('btn-success').addClass('btn-outline-secondary');
                        btn.find('.status-text').text('Hidden');
                    }
                }
            },
            error: function(xhr) {
                alert('Failed to update status.');
            }
        });
    }
</script>
@endpush