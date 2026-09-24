@extends('layouts.admin')

@section('title', 'Tile Products')

@section('content')
<div class="container-fluid py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Tile Products</h4>
            <p class="text-muted fs-7 mb-0">Manage tile product inventory, pricing, and specs seamlessly via AJAX.</p>
        </div>
        <button class="btn btn-primary btn-sm px-3" onclick="openCreateModal()">
            <i class="bi bi-plus-lg me-1"></i> Add Product
        </button>
    </div>

    <!-- Filters Section -->
    <div class="card border-0 shadow-sm p-3 mb-4 rounded-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" id="filterSearch" class="form-control form-control-sm" placeholder="Search product name or SKU..." oninput="loadProducts(1)">
            </div>
            <div class="col-md-3">
                <select id="filterCategory" class="form-select form-select-sm" onchange="loadProducts(1)">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterType" class="form-select form-select-sm" onchange="loadProducts(1)">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary btn-sm w-100" onclick="resetFilters()">Reset Filters</button>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-7">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Product</th>
                        <th>SKU</th>
                        <th>Category / Type</th>
                        <th>Size</th>
                        <th>Godown / Location</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <!-- Populated dynamically via JS -->
                </tbody>
            </table>
        </div>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-between align-items-center p-3 border-top" id="paginationContainer">
            <!-- Dynamic pagination controls -->
        </div>
    </div>
</div>

<!-- Add/Edit Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold" id="productModalTitle">Add Tile Product</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productForm" enctype="multipart/form-data" onsubmit="saveProduct(event)">
                @csrf
                <input type="hidden" id="productId" name="id">
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fs-7 fw-medium">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required placeholder="e.g. Italian Glossy Ceramic Tile">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-medium">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sku" name="sku" required placeholder="e.g. TL-GLS-6060">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-medium">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="tile_category_id" name="tile_category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-medium">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="tile_type_id" name="tile_type_id" required>
                                <option value="">Select Type</option>
                                @foreach($types as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-7 fw-medium">Size <span class="text-danger">*</span></label>
                            <select class="form-select" id="tile_size_id" name="tile_size_id" required>
                                <option value="">Select Size</option>
                                @foreach($sizes as $sz)
                                    <option value="{{ $sz->id }}">{{ $sz->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fs-7 fw-medium">Location</label>
                            <select class="form-select" id="location_id" name="location_id">
                                <option value="">Select Location</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-7 fw-medium">Godown</label>
                            <select class="form-select" id="godown_id" name="godown_id">
                                <option value="">Select Godown</option>
                                @foreach($godowns as $gdn)
                                    <option value="{{ $gdn->id }}">{{ $gdn->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label fs-7 fw-medium">Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required placeholder="0.00">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fs-7 fw-medium">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required placeholder="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fs-7 fw-medium">Coverage (Sq. Ft/Box)</label>
                            <input type="text" class="form-control" id="box_coverage_sqft" name="box_coverage_sqft" placeholder="e.g. 15.5">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fs-7 fw-medium">Pieces Per Box</label>
                            <input type="number" class="form-control" id="pieces_per_box" name="pieces_per_box" placeholder="e.g. 4">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fs-7 fw-medium">Product Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div id="imagePreviewContainer" class="mt-2 d-none">
                            <img id="imagePreview" src="" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fs-7 fw-medium">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2" placeholder="Optional notes or specifications..."></textarea>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label fs-7" for="is_active">Active Status</label>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light py-2">
                    <button type="button" class="btn btn-light btn-sm fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold" id="saveBtn">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const productModal = new bootstrap.Modal(document.getElementById('productModal'));
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', () => {
        loadProducts(currentPage);
    });

    // 1. Fetch & Render Table via AJAX
    function loadProducts(page = 1) {
        currentPage = page;
        const search = document.getElementById('filterSearch').value;
        const categoryId = document.getElementById('filterCategory').value;
        const typeId = document.getElementById('filterType').value;

        const params = new URLSearchParams({
            page: page,
            search: search,
            category_id: categoryId,
            type_id: typeId
        });

        fetch(`/admin/tile-products?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                renderTable(res.data.data);
                renderPagination(res.data);
            }
        })
        .catch(err => console.error('Error loading products:', err));
    }

    // 2. Render Table Rows
    function renderTable(products) {
        const tbody = document.getElementById('productTableBody');
        tbody.innerHTML = '';

        if (products.length === 0) {
            tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4 text-muted">No tile products found.</td></tr>`;
            return;
        }

        products.forEach(p => {
            const imgHtml = p.image 
                ? `<img src="/storage/${p.image}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">`
                : `<div class="bg-light rounded me-2 d-flex align-items-center justify-content-center text-muted" style="width: 40px; height: 40px;"><i class="bi bi-image"></i></div>`;

            const statusBadge = p.is_active
                ? `<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>`
                : `<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Inactive</span>`;

            tbody.innerHTML += `
                <tr id="product-row-${p.id}">
                    <td class="ps-3">
                        <div class="d-flex align-items-center">
                            ${imgHtml}
                            <span class="fw-semibold text-dark">${p.product_name}</span>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border">${p.sku}</span></td>
                    <td>
                        <div>${p.category ? p.category.name : '-'}</div>
                        <small class="text-muted">${p.type ? p.type.name : '-'}</small>
                    </td>
                    <td>${p.size ? p.size.name : '-'}</td>
                    <td>
                        <div>${p.godown ? p.godown.name : '-'}</div>
                        <small class="text-muted">${p.location ? p.location.name : '-'}</small>
                    </td>
                    <td class="fw-semibold">₹${parseFloat(p.price).toFixed(2)}</td>
                    <td>
                        <span class="badge ${p.stock_quantity > 10 ? 'bg-info-subtle text-info border' : 'bg-warning-subtle text-warning border'}">
                            ${p.stock_quantity} boxes
                        </span>
                    </td>
                    <td>${statusBadge}</td>
                    <td class="text-end pe-3">
                        <button class="btn btn-sm btn-outline-secondary me-1" onclick="editProduct(${p.id})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteProduct(${p.id})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }

    // 3. Render Pagination
    function renderPagination(meta) {
        const container = document.getElementById('paginationContainer');
        if (meta.total <= meta.per_page) {
            container.innerHTML = `<small class="text-muted">Total Records: ${meta.total}</small>`;
            return;
        }

        let linksHtml = '';
        meta.links.forEach(link => {
            if (link.url) {
                const pageNum = new URL(link.url).searchParams.get('page');
                linksHtml += `
                    <button class="btn btn-sm ${link.active ? 'btn-primary' : 'btn-outline-secondary'} me-1" onclick="loadProducts(${pageNum})">
                        ${link.label.replace('&laquo;', '«').replace('&raquo;', '»')}
                    </button>
                `;
            }
        });

        container.innerHTML = `
            <small class="text-muted">Showing ${meta.from || 0} to ${meta.to || 0} of ${meta.total} entries</small>
            <div>${linksHtml}</div>
        `;
    }

    // 4. Open Modal for Create
    function openCreateModal() {
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('productModalTitle').innerText = 'Add Tile Product';
        document.getElementById('is_active').checked = true;
        document.getElementById('imagePreviewContainer').classList.add('d-none');
        productModal.show();
    }

    // 5. Open Modal for Edit via AJAX
    function editProduct(id) {
        fetch(`/admin/tile-products/${id}/edit`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const p = res.data;
                document.getElementById('productId').value = p.id;
                document.getElementById('product_name').value = p.product_name;
                document.getElementById('sku').value = p.sku;
                document.getElementById('tile_category_id').value = p.tile_category_id;
                document.getElementById('tile_type_id').value = p.tile_type_id;
                document.getElementById('tile_size_id').value = p.tile_size_id;
                document.getElementById('location_id').value = p.location_id || '';
                document.getElementById('godown_id').value = p.godown_id || '';
                document.getElementById('price').value = p.price;
                document.getElementById('stock_quantity').value = p.stock_quantity;
                document.getElementById('box_coverage_sqft').value = p.box_coverage_sqft || '';
                document.getElementById('pieces_per_box').value = p.pieces_per_box || '';
                document.getElementById('description').value = p.description || '';
                document.getElementById('is_active').checked = p.is_active;

                if (res.image_url) {
                    document.getElementById('imagePreview').src = res.image_url;
                    document.getElementById('imagePreviewContainer').classList.remove('d-none');
                } else {
                    document.getElementById('imagePreviewContainer').classList.add('d-none');
                }

                document.getElementById('productModalTitle').innerText = 'Edit Tile Product';
                productModal.show();
            }
        })
        .catch(err => console.error('Error fetching product details:', err));
    }

    // 6. Save Product (Store/Update) via AJAX
    function saveProduct(e) {
        e.preventDefault();
        const id = document.getElementById('productId').value;
        const url = id ? `/admin/tile-products/${id}` : '/admin/tile-products';
        const formData = new FormData(e.target);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async res => {
            const data = await res.json();
            if (res.ok && data.success) {
                productModal.hide();
                loadProducts(currentPage);
            } else {
                alert(data.message || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Validation failed'));
            }
        })
        .catch(err => console.error('Error saving product:', err));
    }

    // 7. Delete Product via AJAX
    function deleteProduct(id) {
        if (!confirm('Are you sure you want to delete this product?')) return;

        fetch(`/admin/tile-products/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                loadProducts(currentPage);
            } else {
                alert(res.message || 'Failed to delete product.');
            }
        })
        .catch(err => console.error('Error deleting product:', err));
    }

    // Reset Filters
    function resetFilters() {
        document.getElementById('filterSearch').value = '';
        document.getElementById('filterCategory').value = '';
        document.getElementById('filterType').value = '';
        loadProducts(1);
    }
</script>
@endpush