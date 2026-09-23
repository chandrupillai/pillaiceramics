@extends('layouts.admin')

@section('title', 'Tile Categories')

@section('content')
<div class="container-fluid py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Tile Categories</h4>
            <p class="text-muted fs-7 mb-0">Manage tile categories (e.g., Floor Tiles, Wall Tiles, Parking Tiles).</p>
        </div>
        <button class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="resetCategoryForm()">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </button>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-7">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    @forelse($categories as $category)
                        <tr id="category-row-{{ $category->id }}">
                            <td class="ps-3 fw-semibold text-dark">{{ $category->name }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $category->slug }}</span></td>
                            <td>{{ $category->description ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $category->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} rounded-pill">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-outline-secondary me-1" onclick="editCategory({{ $category->id }})">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory({{ $category->id }})">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyCategoryRow">
                            <td colspan="5" class="text-center py-4 text-muted">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold" id="categoryModalTitle">Add Tile Category</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm" onsubmit="saveCategory(event)">
                @csrf
                <input type="hidden" id="categoryId" name="id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fs-7 fw-medium">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="name" required placeholder="e.g., Ceramic Floor Tiles">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-7 fw-medium">Description</label>
                        <textarea class="form-control" id="category_description" name="description" rows="3" placeholder="Optional details..."></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="category_is_active" name="is_active" value="1" checked>
                        <label class="form-check-label fs-7" for="category_is_active">Active Status</label>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light py-2">
                    <button type="button" class="btn btn-light btn-sm fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold" id="categorySaveBtn">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));

    function resetCategoryForm() {
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryId').value = '';
        document.getElementById('categoryModalTitle').innerText = 'Add Tile Category';
        document.getElementById('category_is_active').checked = true;
    }

    function editCategory(id) {
        fetch(`/admin/tile-categories/${id}/edit`)
            .then(res => res.json())
            .then(res => {
                if(res.success) {
                    document.getElementById('categoryId').value = res.data.id;
                    document.getElementById('category_name').value = res.data.name;
                    document.getElementById('category_description').value = res.data.description || '';
                    document.getElementById('category_is_active').checked = res.data.is_active;
                    document.getElementById('categoryModalTitle').innerText = 'Edit Tile Category';
                    categoryModal.show();
                }
            });
    }

    function saveCategory(e) {
        e.preventDefault();
        const id = document.getElementById('categoryId').value;
        const url = id ? `/admin/tile-categories/${id}` : '/admin/tile-categories';
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
                categoryModal.hide();
                location.reload();
            } else {
                alert(res.message || 'Validation error');
            }
        });
    }

    function deleteCategory(id) {
        if(!confirm('Are you sure you want to delete this category?')) return;

        fetch(`/admin/tile-categories/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                document.getElementById(`category-row-${id}`).remove();
            }
        });
    }
</script>
@endpush