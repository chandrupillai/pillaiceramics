@extends('layouts.admin')

@section('title', 'Dealer Enquiries')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-shop-window text-primary me-2"></i> Dealer Product Enquiries
            </h4>
            <p class="text-muted fs-7 mb-0">Manage incoming dealer product requests, quantities, and status updates.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fs-7 mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-7">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">#ID</th>
                        <th>Dealer Name</th>
                        <th>Tile Product</th>
                        <th>Quantity</th>
                        <th>Notes</th>
                        <th>Updated By</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $enquiry)
                        <tr>
                            <td class="ps-3 fw-bold text-secondary">#{{ $enquiry->id }}</td>
                            <td>
                                <span class="fw-semibold text-dark d-block">
                                    {{ $enquiry->dealer->name ?? 'N/A' }}
                                </span>
                                @if(optional($enquiry->dealer)->phone)
                                    <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $enquiry->dealer->phone }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border">
                                    {{ $enquiry->product->name ?? 'Product #' . $enquiry->tile_product_id }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">{{ $enquiry->quantity }}</span>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 180px;" title="{{ $enquiry->notes }}">
                                    {{ $enquiry->notes ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $enquiry->updatedByStaff->name ?? '-' }}
                                </small>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.dealer-enquiries.updateStatus', $enquiry->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                        class="form-select form-select-sm border-0 fs-7 py-1 px-2 text-center rounded-pill 
                                        @if($enquiry->status == 'pending') bg-warning-subtle text-warning-emphasis 
                                        @elseif($enquiry->status == 'approved' || $enquiry->status == 'completed') bg-success-subtle text-success 
                                        @elseif($enquiry->status == 'rejected') bg-danger-subtle text-danger 
                                        @else bg-light text-dark @endif">
                                        <option value="pending" {{ $enquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $enquiry->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="approved" {{ $enquiry->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $enquiry->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-end pe-3">
                                {{-- Direct WhatsApp Trigger to Dealer --}}
                                @if(optional($enquiry->dealer)->phone)
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $enquiry->dealer->phone);
                                        $waMsg = rawurlencode("Hello " . $enquiry->dealer->name . ", regarding your enquiry #" . $enquiry->id . " for product: " . (optional($enquiry->product)->name ?? 'Tiles') . " (Qty: " . $enquiry->quantity . ")");
                                    @endphp
                                    <a href="https://wa.me/91{{ $cleanPhone }}?text={{ $waMsg }}" target="_blank" class="btn btn-sm btn-success px-2 py-1" title="WhatsApp Dealer">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                @endif

                                {{-- Delete Entry --}}
                                <form action="{{ route('admin.dealer-enquiries.destroy', $enquiry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this dealer enquiry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i> No dealer enquiries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($enquiries->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $enquiries->links() }}
            </div>
        @endif
    </div>

</div>
@endsection