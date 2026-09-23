@extends('layouts.admin')

@section('title', 'Tile Sizes')

@section('content')
<div class="container-fluid py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Tile Sizes</h4>
            <p class="text-muted fs-7 mb-0">Manage dimensions and sizing specifications (e.g., 600x600 mm, 300x600 mm, 2x2 ft).</p>
        </div>
        <button class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#sizeModal" onclick="resetSizeForm()">
            <i class="bi bi-plus-lg me-1"></i> Add Size
        </button>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-7">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Size Name</th>
                        <th>Slug</th>
                        <th>Dimensions</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="sizeTableBody">
                    @forelse($sizes as $size)
                        <tr id="size-row-{{ $size->id }}">
                            <td class="ps-3 fw-semibold text-dark">{{ $size->name }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $size->slug }}</span></td>
                            <td>
                                @if($size->width_mm && $size->height_mm)
                                    {{ $size->width_mm }} × {{ $size->height_mm }} {{$size->unit }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td><span class="text-uppercase fw-semibold">{{ $size->unit }}</span></td>
                            <td>
                                <span class="badge {{ $size->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} rounded-pill">
                                    {{ $size->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-outline-secondary me-1" onclick="editSize({{ $size->id }})">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteSize({{ $size->id }})">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptySizeRow">
                            <td colspan="6" class="text-center py-4 text-muted">No tile sizes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Size Modal -->
<div class="modal fade" id="sizeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold" id="sizeModalTitle">Add Tile Size</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="sizeForm" onsubmit="saveSize(event)">
                @csrf
                <input type="hidden" id="sizeId" name="id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fs-7 fw-medium">Size Display Name</label>
                        <input type="text" class="form-control" id="size_name" name="name" required placeholder="e.g., 600x600 mm or 2x2 ft">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-medium">Width</label>
                            <input type="number" step="0.01" class="form-control" id="size_width" name="width_mm" placeholder="600">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-medium">Height</label>
                            <input type="number" step="0.01" class="form-control" id="size_height" name="height_mm" placeholder="600">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-medium">Unit</label>
                            <select class="form-select" id="size_unit" name="unit" required>
                                <option value="mm">mm</option>
                                <option value="cm">cm</option>
                                <option value="inch">inch</option>
                                <option value="ft">ft</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-7 fw-medium">Description</label>
                        <textarea class="form-control" id="size_description" name="description" rows="2" placeholder="Optional details..."></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="size_is_active" name="is_active" value="1" checked>
                        <label class="form-check-label fs-7" for="size_is_active">Active Status</label>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light py-2">
                    <button type="button" class="btn btn-light btn-sm fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold" id="sizeSaveBtn">Save Size</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const sizeModal = new bootstrap.Modal(document.getElementById('sizeModal'));

    function resetSizeForm() {
        document.getElementById('sizeForm').reset();
        document.getElementById('sizeId').value = '';
        document.getElementById('sizeModalTitle').innerText = 'Add Tile Size';
        document.getElementById('size_is_active').checked = true;
        document.getElementById('size_unit').value = 'mm';
    }

    function editSize(id) {
        fetch(`/admin/tile-sizes/${id}/edit`)
            .then(res => res.json())
            .then(res => {
                if(res.success) {
                    document.getElementById('sizeId').value = res.data.id;
                    document.getElementById('size_name').value = res.data.name;
                    document.getElementById('size_width').value = res.data.width_mm || '';
                    document.getElementById('size_height').value = res.data.height_mm || '';
                    document.getElementById('size_unit').value = res.data.unit || 'mm';
                    document.getElementById('size_description').value = res.data.description || '';
                    document.getElementById('size_is_active').checked = res.data.is_active;
                    document.getElementById('sizeModalTitle').innerText = 'Edit Tile Size';
                    sizeModal.show();
                }
            });
    }

    function saveSize(e) {
        e.preventDefault();
        const id = document.getElementById('sizeId').value;
        const url = id ? `/admin/tile-sizes/${id}` : '/admin/tile-sizes';
        const formData = new FormData(e.target);
        
        if (id) {
            formData.append('_method', 'PUT');
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                sizeModal.hide();
                location.reload();
            } else {
                alert(res.message || 'Validation error');
            }
        });
    }

    function deleteSize(id) {
        if(!confirm('Are you sure you want to delete this size?')) return;

        fetch(`/admin/tile-sizes/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                document.getElementById(`size-row-${id}`).remove();
            }
        });
    }
</script>
@endpush