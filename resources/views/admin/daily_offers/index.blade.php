@extends('layouts.admin')

@section('title', 'Daily Offers Banner')

@section('content')
<div class="container-fluid py-2">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-card-image text-primary me-2"></i>Daily Offers & Popups
            </h4>
            <p class="text-muted fs-7 mb-0">Upload and manage promotional popups for the mobile app homepage.</p>
        </div>
        <button class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Upload New Offer</span>
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card card-custom shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr class="text-uppercase fs-8 text-secondary fw-bold">
                            <th class="ps-4" style="width: 80px;">ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Offer Date</th>
                            <th>Status</th>
                            <th class="text-end pe-4" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fs-7">
                        @forelse($offers as $offer)
                        <tr id="row-{{ $offer->id }}">
                            <td class="ps-4 fw-bold text-secondary">#{{ $offer->id }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $offer->image) }}" alt="Offer" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                            </td>
                            <td class="fw-bold text-dark">{{ $offer->title ?? 'N/A' }}</td>
                            <td class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $offer->offer_date->format('M d, Y') }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $offer->id }}" {{ $offer->status == 1 ? 'checked' : '' }}>
                                    <span class="badge {{ $offer->status == 1 ? 'bg-success' : 'bg-secondary' }} status-badge-{{ $offer->id }}">
                                        {{ $offer->status == 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-delete" data-id="{{ $offer->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-image fs-1 text-secondary d-block mb-2"></i>
                                <span>No daily offer banners created yet.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fs-6 fw-bold"><i class="bi bi-cloud-arrow-up-fill me-2"></i>Upload Daily Offer Banner</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.daily-offers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Title (Optional)</label>
                        <input type="text" class="form-control fs-7" name="title" placeholder="Special Discount Today">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Offer Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control fs-7" name="offer_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-7 text-dark">Banner Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control fs-7" name="image" accept="image/*" required>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="statusSwitch" checked>
                        <label class="form-check-label fs-7 fw-semibold" for="statusSwitch">Set as Active Banner</label>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary fs-7" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fs-7 px-4">Upload & Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Toggle Status Switch
        $('.status-toggle').change(function() {
            let id = $(this).data('id');
            $.post('/admin/daily-offers/' + id + '/toggle', function(res) {
                if (res.success) {
                    location.reload(); // Reload to refresh active badges across all rows
                }
            });
        });

        // Delete Item
        $('.btn-delete').click(function() {
            if (!confirm('Are you sure you want to delete this offer banner?')) return;
            let id = $(this).data('id');

            $.ajax({
                url: '/admin/daily-offers/' + id,
                type: 'DELETE',
                success: function(res) {
                    if (res.success) {
                        $('#row-' + id).fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                }
            });
        });
    });
</script>
@endpush