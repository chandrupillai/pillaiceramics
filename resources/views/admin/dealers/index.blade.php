@extends('layouts.admin')

@section('title', 'Dealer Management')

@section('content')
<div class="container-fluid py-2">

    <!-- Page Header & Actions -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-shop text-primary me-2"></i>Dealers List
            </h4>
            <p class="text-muted fs-7 mb-0">Manage wholesale dealer accounts, contacts, and assigned staff members.</p>
        </div>
        <button class="btn btn-success d-flex align-items-center gap-2 shadow-sm" id="btnCreateDealer">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Add New Dealer</span>
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
                        <input type="text" id="dealerSearch" class="form-control border-start-0 ps-0" placeholder="Search by dealer name, email, or phone...">
                    </div>
                </div>
                <div class="col-md-6 col-lg-8 text-md-end">
                    <span class="badge bg-light text-dark border px-3 py-2 fs-7 fw-normal" id="totalCountBadge">
                        Total Dealers: <strong>{{ count($dealers) }}</strong>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Dealer Data Table Card -->
    <div class="card card-custom shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dealersTable">
                    <thead class="table-light border-bottom">
                        <tr class="text-uppercase fs-8 text-secondary fw-bold">
                            <th class="ps-4" style="width: 80px;">ID</th>
                            <th>Dealer Name</th>
                            <th>Contact Info</th>
                            <th>Assigned Staff / Created By</th>
                            <th>Registered Date</th>
                            <th class="text-end pe-4" style="width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fs-7">
                        @forelse($dealers as $dealer)
                            <tr id="row-{{ $dealer->id }}" class="dealer-row">
                                <td class="ps-4 fw-bold text-secondary">#{{ $dealer->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-success-subtle text-success fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 0.85rem;">
                                            {{ strtoupper(substr($dealer->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark dealer-name">{{ $dealer->name }}</div>
                                            <small class="text-muted fs-8">Account Type: Dealer</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-dark dealer-email"><i class="bi bi-envelope text-muted me-1"></i>{{ $dealer->email }}</div>
                                    <small class="text-muted dealer-phone"><i class="bi bi-telephone text-muted me-1"></i>{{ $dealer->phone ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 fs-8">
                                        <i class="bi bi-person-check me-1"></i>{{ $dealer->creator?->name ?? 'Admin / Direct' }}
                                    </span>
                                </td>
                                <td class="text-muted">
                                    {{ $dealer->created_at ? $dealer->created_at->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary btn-edit" data-id="{{ $dealer->id }}" title="Edit Dealer">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-delete" data-id="{{ $dealer->id }}" title="Delete Dealer">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-shop-window fs-1 text-secondary d-block mb-2"></i>
                                    <span>No dealers found.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($dealers, 'hasPages') &&$dealers->hasPages())
            <div class="card-footer bg-white border-top py-3">
                {{ $dealers->links() }}
            </div>
        @endif
    </div>
</div>

<!-- ========================================================================= -->
<!-- AJAX CREATE / EDIT DEALER MODAL                                           -->
<!-- ========================================================================= -->
<div class="modal fade" id="dealerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fs-6 fw-bold" id="modalTitle">
                    <i class="bi bi-shop me-2"></i>Add New Dealer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="dealerForm">
                @csrf
                <input type="hidden" id="dealer_id" name="dealer_id">
                <div class="modal-body p-4">

                    <!-- Validation Errors Alert -->
                    <div class="alert alert-danger d-none py-2 px-3 fs-7" id="errorBox"></div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Dealer / Store Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-shop"></i></span>
                            <input type="text" class="form-control fs-7" id="name" name="name" placeholder="ABC Ceramics & Tiles" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control fs-7" id="email" name="email" placeholder="dealer@example.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control fs-7" id="phone" name="phone" placeholder="+91 9876543210">
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
                    <button type="submit" class="btn btn-success fs-7 px-4 d-flex align-items-center gap-2" id="saveBtn">
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
$(document).ready(function () {

    // Initialize Bootstrap Modal Instance
    const dealerModalEl = document.getElementById('dealerModal');
    const dealerModal = new bootstrap.Modal(dealerModalEl);

    // Setup global CSRF header for jQuery AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // -------------------------------------------------------------------------
    // 1. Client-Side Live Search
    // -------------------------------------------------------------------------
    $('#dealerSearch').on('keyup', function () {
        let value = $(this).val().toLowerCase().trim();
        let visibleRows = 0;

        $('.dealer-row').each(function () {
            let name  = $(this).find('.dealer-name').text().toLowerCase();
            let email = $(this).find('.dealer-email').text().toLowerCase();
            let phone = $(this).find('.dealer-phone').text().toLowerCase();

            if (name.includes(value) || email.includes(value) || phone.includes(value)) {
                $(this).show();
                visibleRows++;
            } else {
                $(this).hide();
            }
        });

        if (visibleRows === 0 && value !== '') {
            if ($('#searchEmptyRow').length === 0) {
                $('#dealersTable tbody').append(`
                    <tr id="searchEmptyRow">
                        <td colspan="6" class="text-center py-4 text-muted">No dealers matching "${value}".</td>
                    </tr>
                `);
            }
        } else {
            $('#searchEmptyRow').remove();
        }
    });

    // -------------------------------------------------------------------------
    // 2. Open Create Dealer Modal
    // -------------------------------------------------------------------------
    $('#btnCreateDealer').click(function () {
        $('#dealerForm')[0].reset();
        $('#dealer_id').val('');
        $('#modalTitle').html('<i class="bi bi-shop me-2"></i>Add New Dealer');
        $('#pwdRequired').removeClass('d-none');
        $('#pwdHelp').text('(Min 6 characters)');
        $('#errorBox').addClass('d-none').html('');
        dealerModal.show();
    });

    // -------------------------------------------------------------------------
    // 3. Open Edit Dealer Modal (Fetch record via AJAX)
    // -------------------------------------------------------------------------
    $(document).on('click', '.btn-edit', function () {
        let id = $(this).data('id');$('#errorBox').addClass('d-none').html('');

        $.ajax({
            url: '/admin/users/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    $('#dealer_id').val(res.data.id);
                    $('#name').val(res.data.name);
                    $('#email').val(res.data.email);
                    $('#phone').val(res.data.phone);
                    $('#password').val('');
                    
                    // Modify password requirements for editing mode
                    $('#modalTitle').html('<i class="bi bi-pencil-square me-2"></i>Edit Dealer Account');
                    $('#pwdRequired').addClass('d-none');
                    $('#pwdHelp').text('(Leave blank to keep unchanged)');
                    
                    dealerModal.show();
                }
            },
            error: function () {
                alert('Failed to load dealer details. Please refresh the page.');
            }
        });
    });

    // -------------------------------------------------------------------------
    // 4. Save/Update Dealer (Submit Form via AJAX)
    // -------------------------------------------------------------------------
    $('#dealerForm').submit(function (e) {
        e.preventDefault();

        let id = $('#dealer_id').val();
        let url = id ? '/admin/users/' + id + '/update' : '{{ route("admin.dealers.store") }}';
        
        let $saveBtn =$('#saveBtn');
        $saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');

        $.ajax({
            url: url,
            type: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                $saveBtn.prop('disabled', false).html('<i class="bi bi-check-circle-fill"></i> Save Changes');
                if (res.success) {
                    dealerModal.hide();
                    location.reload(); // Reload to refresh list & updated creator tags
                }
            },
            error: function (xhr) {
                $saveBtn.prop('disabled', false).html('<i class="bi bi-check-circle-fill"></i> Save Changes');
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul class="mb-0 ps-3">';
                    $.each(errors, function (key, value) {
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
    // 5. Delete Dealer Record via AJAX
    // -------------------------------------------------------------------------
    $(document).on('click', '.btn-delete', function () {
        if (!confirm('Are you sure you want to delete this dealer? This action cannot be undone.')) {
            return;
        }

        let id = $(this).data('id');
        let $row =$('#row-' + id);

        $.ajax({
            url: '/admin/users/' + id + '/delete',
            type: 'DELETE',
            success: function (res) {
                if (res.success) {
                    $row.fadeOut(300, function () {$(this).remove(); 
                        if ($('.dealer-row:visible').length === 0) {
                            location.reload();
                        }
                    });
                }
            },
            error: function () {
                alert('Failed to delete dealer. Please try again.');
            }
        });
    });

});
</script>
@endpush