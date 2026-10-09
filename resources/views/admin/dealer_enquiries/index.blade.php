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
        <div>
            <button type="button" id="bulk-delete-btn" onclick="bulkDeleteAjax()" class="btn btn-danger btn-sm shadow-sm d-none">
                <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selected-count">0</span>)
            </button>
        </div>
    </div>

    {{-- Alert Container for AJAX Notifications --}}
    <div id="ajax-alert" class="alert alert-dismissible fade d-none fs-7 mb-3" role="alert">
        <span id="ajax-alert-message"></span>
        <button type="button" class="btn-close" onclick="document.getElementById('ajax-alert').classList.add('d-none')"></button>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-7">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3" style="width: 40px;">
                            <input type="checkbox" id="select-all" class="form-check-input" onchange="toggleSelectAll(this)">
                        </th>
                        <th>#ID / Date</th>
                        <th>Dealer Name</th>
                        <th>Tile Products</th>
                        <th>Notes</th>
                        <th>Updated By</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $key =>$enquiry)
                    @php
                    // Extract primary ID from grouped array or fallback to model id
                    $primaryId = $enquiry->id ?? ($enquiry->enquiry_id_list[0] ?? null);
                    $idList = !empty($enquiry->enquiry_id_list) ? $enquiry->enquiry_id_list : [$primaryId];
                    @endphp
                    <tr id="row-enquiry-{{ $key }}">
                        <td class="ps-3">
                            <input type="checkbox" class="form-check-input enquiry-checkbox" value="{{ implode(',', $idList) }}" onchange="updateBulkDeleteBtn()">
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">
                                #{{ $primaryId }}
                            </span>
                            <small class="text-muted fs-8">
                                {{ \Carbon\Carbon::parse($enquiry->created_at)->format('d M Y, h:i A') }}
                            </small>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark d-block">
                                {{ $enquiry->dealer->name ?? 'N/A' }}
                            </span>
                            @if(optional($enquiry->dealer)->phone)
                            <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $enquiry->dealer->phone }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @if(isset($enquiry->products) && count($enquiry->products) > 0)
                                @foreach($enquiry->products as $product)
                                <span class="badge bg-light text-primary border">
                                    {{ $product->product_name ?? $product->name }}
                                </span>
                                @endforeach
                                @else
                                <span class="badge bg-light text-secondary border">No Product Specified</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 180px;" title="{{ $enquiry->notes }}">
                                {{ $enquiry->notes ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted updated-by-staff">
                                {{ $enquiry->updatedByStaff->name ?? '-' }}
                            </small>
                        </td>
                        <td class="text-center">
                            <select onchange="updateGroupStatusAjax('{{ json_encode($idList) }}', this)"
                                class="form-select form-select-sm border-0 fs-7 py-1 px-2 text-center rounded-pill status-select
                                        @if($enquiry->status == 'pending') bg-warning-subtle text-warning-emphasis 
                                        {{-- AFTER (Fixed) --}}
@elseif($enquiry->status == 'approved' || $enquiry->status == 'completed') bg-success-subtle text-success
                                        @elseif($enquiry->status == 'rejected') bg-danger-subtle text-danger 
                                        @else bg-light text-dark @endif">
                                <option value="pending" {{ $enquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $enquiry->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="approved" {{ $enquiry->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $enquiry->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </td>
                        <td class="text-end pe-3">
                            {{-- Direct WhatsApp Trigger --}}
                            @if(optional($enquiry->dealer)->phone)
                            @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $enquiry->dealer->phone);$productNames = isset($enquiry->products) ?$enquiry->products->pluck('product_name')->implode(', ') : 'Tiles';
                            $waMsg = rawurlencode("Hello " . $enquiry->dealer->name . ", regarding your enquiry on " . \Carbon\Carbon::parse($enquiry->created_at)->format('d M Y') . " for: " . $productNames);
                            @endphp
                            <a href="https://wa.me/91{{ $cleanPhone }}?text={{$waMsg }}" target="_blank" class="btn btn-sm btn-success px-2 py-1" title="WhatsApp Dealer">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            @endif

                            {{-- Group Delete Button --}}
                            <button type="button" onclick="deleteGroupAjax('{{ json_encode($idList) }}', 'row-enquiry-{{$key }}')" class="btn btn-sm btn-outline-danger px-2 py-1" title="Delete Group">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr id="no-records-row">
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

{{-- JavaScript Functions --}}
<script>
    // 1. Select / Deselect All Checkboxes
    function toggleSelectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('.enquiry-checkbox');
        checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
        updateBulkDeleteBtn();
    }

    // 2. Toggle Delete Selected Button Visibility and Count
    function updateBulkDeleteBtn() {
        const checkedBoxes = document.querySelectorAll('.enquiry-checkbox:checked');
        const bulkBtn = document.getElementById('bulk-delete-btn');
        const countSpan = document.getElementById('selected-count');
        const selectAll = document.getElementById('select-all');

        const totalCheckboxes = document.querySelectorAll('.enquiry-checkbox').length;
        if (selectAll) {
            selectAll.checked = (checkedBoxes.length > 0 && checkedBoxes.length === totalCheckboxes);
        }

        if (checkedBoxes.length > 0) {
            countSpan.innerText = checkedBoxes.length;
            bulkBtn.classList.remove('d-none');
        } else {
            bulkBtn.classList.add('d-none');
        }
    }

    // 3. Multi / Bulk Delete via AJAX (POST)
    function bulkDeleteAjax() {
        const checkedBoxes = Array.from(document.querySelectorAll('.enquiry-checkbox:checked'));
        if (checkedBoxes.length === 0) return;

        // Flatten all comma-separated IDs from checked rows into a single array
        let allIds = [];
        checkedBoxes.forEach(cb => {
            const ids = cb.value.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id));
            allIds = allIds.concat(ids);
        });

        if (allIds.length === 0) return;

        if (!confirm(`Are you sure you want to delete ${allIds.length} selected enquiry record(s)?`)) return;

        fetch(`{{ url('admin/dealer-enquiries/bulk-destroy') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    enquiry_ids: allIds
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to delete');
                return response.json();
            })
            .then(data => {
                checkedBoxes.forEach(cb => {
                    const row = cb.closest('tr');
                    if (row) row.remove();
                });

                document.getElementById('select-all').checked = false;
                updateBulkDeleteBtn();
                showAlert('success', data.message || 'Enquiries deleted successfully!');
            })
            .catch(error => {
                showAlert('danger', 'Failed to delete selected items.');
                console.error('Error:', error);
            });
    }

    // 4. Update Group Status via AJAX (PATCH/POST)
    function updateGroupStatusAjax(enquiryIds, selectElement) {
        // Ensure enquiryIds is converted to a clean array of integers
        let formattedIds = [];
        if (Array.isArray(enquiryIds)) {
            formattedIds = enquiryIds.map(id => parseInt(id)).filter(id => !isNaN(id));
        } else if (typeof enquiryIds === 'string') {
            formattedIds = enquiryIds.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id));
        } else if (typeof enquiryIds === 'number') {
            formattedIds = [enquiryIds];
        }

        if (formattedIds.length === 0) {
            showAlert('danger', 'Invalid enquiry group ID.');
            return;
        }

        const newStatus = selectElement.value;
        selectElement.disabled = true;

        fetch(`{{ url('admin/dealer-enquiries/group-status') }}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    enquiry_ids: formattedIds, // Always sent as a proper array [1, 2, 3]
                    status: newStatus
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Update failed');
                return response.json();
            })
            .then(data => {
                selectElement.disabled = false;

                // Dynamic badge color update
                selectElement.className = 'form-select form-select-sm border-0 fs-7 py-1 px-2 text-center rounded-pill status-select ';
                if (newStatus === 'pending') selectElement.classList.add('bg-warning-subtle', 'text-warning-emphasis');
                else if (newStatus === 'approved' || newStatus === 'completed') selectElement.classList.add('bg-success-subtle', 'text-success');
                else if (newStatus === 'rejected') selectElement.classList.add('bg-danger-subtle', 'text-danger');
                else selectElement.classList.add('bg-light', 'text-dark');

                showAlert('success', data.message || 'Status updated successfully!');
            })
            .catch(error => {
                selectElement.disabled = false;
                showAlert('danger', 'Failed to update status.');
                console.error('Error:', error);
            });
    }

    // 5. Delete Group via AJAX (POST)
    function deleteGroupAjax(enquiryIds, rowId) {
        // Standardize input into a valid array of integers
        let formattedIds = [];
        if (Array.isArray(enquiryIds)) {
            formattedIds = enquiryIds.map(id => parseInt(id)).filter(id => !isNaN(id));
        } else if (typeof enquiryIds === 'string') {
            formattedIds = enquiryIds.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id));
        } else if (typeof enquiryIds === 'number') {
            formattedIds = [enquiryIds];
        }

        if (formattedIds.length === 0) {
            showAlert('danger', 'Invalid enquiry ID selection.');
            return;
        }

        if (!confirm(`Are you sure you want to delete ${formattedIds.length} enquiry record(s)?`)) return;

        fetch(`{{ url('admin/dealer-enquiries/group-destroy') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    enquiry_ids: formattedIds
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Delete failed');
                return response.json();
            })
            .then(data => {
                const row = document.getElementById(rowId);
                if (row) row.remove();

                updateBulkDeleteBtn();
                showAlert('success', data.message || 'Enquiries deleted successfully!');
            })
            .catch(error => {
                showAlert('danger', 'Failed to delete enquiries.');
                console.error('Error:', error);
            });
    }

    // Helper: Display Alert Toast
    function showAlert(type, message) {
        const alertBox = document.getElementById('ajax-alert');
        const alertMsg = document.getElementById('ajax-alert-message');

        alertBox.className = `alert alert-${type} alert-dismissible fade show fs-7 mb-3`;
        alertMsg.innerText = message;
        alertBox.classList.remove('d-none');

        setTimeout(() => {
            alertBox.classList.add('d-none');
        }, 3000);
    }
</script>
@endsection