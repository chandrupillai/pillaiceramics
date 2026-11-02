@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="container-fluid px-2 px-sm-3 py-3">
    <!-- Responsive Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 mb-md-4">
        <div>
            <h4 class="fw-bold mb-1 fs-5 fs-md-4">Add Product</h4>
            <p class="text-muted fs-7 mb-0">Dynamic product entry supporting Tiles, Sanitaryware, Sinks, and Paste.</p>
        </div>
        <div>
            <a href="{{ route('admin.tile-products.index') }}" class="btn btn-outline-secondary btn-sm w-100 w-sm-auto px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Products
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show fs-7 mb-3" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i><strong>Please correct the errors below:</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.tile-products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3 g-md-4">
            <!-- Main Form Content -->
            <div class="col-12 col-lg-8">
                
                <!-- 1. Basic Details Card -->
                <div class="card border-0 shadow-sm rounded-3 mb-3 mb-md-4">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="fw-bold mb-0 text-dark fs-6"><i class="bi bi-info-circle me-2 text-primary"></i>Basic Details (Name, SKU, Image & Description)</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-3">
                            <div class="col-12 col-md-8">
                                <label for="product_name" class="form-label fw-semibold fs-7">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg form-control-md-sm fs-6 fs-md-7 @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name') }}" placeholder="e.g. Ceramic Wash Basin, Kitchen Sink, or Floor Tile" required>
                                @error('product_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="sku" class="form-label fw-semibold fs-7">SKU <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg form-control-md-sm fs-6 fs-md-7 text-uppercase @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}" placeholder="e.g. SINK-WHT-01" required>
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div class="col-12">
                                <label for="image" class="form-label fw-semibold fs-7">Product Image</label>
                                <div class="row align-items-center g-3">
                                    <div class="col-md-4 text-center">
                                        <div id="imagePreviewContainer" class="border rounded-3 p-2 bg-light d-flex align-items-center justify-content-center mx-auto" style="height: 110px; max-width: 100%;">
                                            <div id="placeholderText" class="text-muted">
                                                <i class="bi bi-cloud-arrow-up fs-2 d-block mb-1"></i>
                                                <span class="fs-8">No image selected</span>
                                            </div>
                                            <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded d-none" style="max-height: 100px; object-fit: contain;">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control form-control-sm @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewSelectedImage(this)">
                                        <small class="text-muted d-block mt-2 fs-8">JPG, PNG, WEBP (Max 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold fs-7">Description</label>
                                <textarea class="form-control fs-6 fs-md-7" id="description" name="description" rows="3" placeholder="Enter product details...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Product Type First, then Dynamic Fields -->
                <div class="card border-0 shadow-sm rounded-3 mb-3 mb-md-4">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="fw-bold mb-0 text-dark fs-6"><i class="bi bi-diagram-3 me-2 text-primary"></i>Product Type & Specifications</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-3">
                            <!-- Product Type Placed First -->
                            <div class="col-12 col-md-4">
                                <label for="product_type_id" class="form-label fw-semibold fs-7">Product Type <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg form-select-md-sm fs-6 fs-md-7" id="product_type_id" name="product_type_id" required onchange="handleProductTypeChange(this)">
                                    <option value="" disabled selected>Select Product Type</option>
                                    @foreach($productTypes as $ptype)
                                        <option value="{{ $ptype->id }}" data-name="{{ strtolower($ptype->name) }}" {{ old('product_type_id') == $ptype->id ? 'selected' : '' }}>
                                            {{ $ptype->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- DYNAMIC CONTAINER A: Tile Specifications (Shown for Tiles) -->
                        <div id="tileFieldsContainer" class="row g-3 mt-2 d-none">
                            <div class="col-12 col-md-4">
                                <label for="tile_category_id" class="form-label fw-semibold fs-7">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="tile_category_id" name="tile_category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="tile_type_id" class="form-label fw-semibold fs-7">Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="tile_type_id" name="tile_type_id">
                                    <option value="">Select Type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="tile_size_id" class="form-label fw-semibold fs-7">Tile Size <span class="text-danger">*</span></label>
                                <select class="form-select" id="tile_size_id" name="tile_size_id">
                                    <option value="">Select Size</option>
                                    @foreach($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- DYNAMIC CONTAINER B: Tile Paste Weightage (Shown for Paste/Chemical) -->
                        <div id="pasteFieldsContainer" class="row g-3 mt-2 d-none">
                            <div class="col-12 col-md-6">
                                <label for="weightage" class="form-label fw-semibold fs-7">Weightage / Packaging <span class="text-danger">*</span></label>
                                <select class="form-select" id="weightage" name="weightage">
                                    <option value="">Select Weightage</option>
                                    <option value="20kg">20 KG</option>
                                    <option value="30kg">30 KG</option>
                                    <option value="40kg">40 KG</option>
                                    <option value="50kg">50 KG</option>
                                </select>
                            </div>
                        </div>

                        <!-- DYNAMIC CONTAINER C: Sanitaryware / Sink Info (Shown for Sanitaryware/Sinks) -->
                        <div id="sanitarywareFieldsContainer" class="row g-3 mt-2 d-none">
                            <div class="col-12 col-md-6">
                                <label for="finish_type" class="form-label fw-semibold fs-7">Finish / Material</label>
                                <input type="text" class="form-control" id="finish_type" name="finish_type" placeholder="e.g. Glossy Ceramic, Stainless Steel">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Pricing & Inventory Card -->
                <div class="card border-0 shadow-sm rounded-3 mb-3 mb-md-4">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="fw-bold mb-0 text-dark fs-6"><i class="bi bi-box-seam me-2 text-primary"></i>Pricing & Stock Details</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="price" class="form-label fw-semibold fs-7">Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="stock_quantity" class="form-label fw-semibold fs-7">Stock Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Content -->
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 mb-3 mb-md-4">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="fw-bold mb-0 text-dark fs-6"><i class="bi bi-geo-alt me-2 text-primary"></i>Storage Location</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-3">
                            <label for="production_company_id" class="form-label fw-semibold fs-7">Production Company</label>
                            <select class="form-select" id="production_company_id" name="production_company_id">
                                <option value="">Select Company</option>
                                @foreach($productionCompanies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="godown_id" class="form-label fw-semibold fs-7">Godown / Warehouse</label>
                            <select class="form-select" id="godown_id" name="godown_id">
                                <option value="">None / Unassigned</option>
                                @foreach($godowns as $godown)
                                    <option value="{{ $godown->id }}">{{ $godown->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-none d-lg-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-semibold"><i class="bi bi-check-lg me-1"></i> Save Product</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const productTypeSelect = document.getElementById('product_type_id');
        if (productTypeSelect.value) {
            handleProductTypeChange(productTypeSelect);
        }
    });

    function handleProductTypeChange(selectElem) {
        const selectedOption = selectElem.options[selectElem.selectedIndex];
        const typeName = (selectedOption.getAttribute('data-name') || '').toLowerCase();

        const tileContainer = document.getElementById('tileFieldsContainer');
        const pasteContainer = document.getElementById('pasteFieldsContainer');
        const sanitarywareContainer = document.getElementById('sanitarywareFieldsContainer');

        const tileCategory = document.getElementById('tile_category_id');
        const tileType = document.getElementById('tile_type_id');
        const tileSize = document.getElementById('tile_size_id');
        const weightage = document.getElementById('weightage');

        // Reset all containers
        tileContainer.classList.add('d-none');
        pasteContainer.classList.add('d-none');
        sanitarywareContainer.classList.add('d-none');
        tileCategory.removeAttribute('required');
        tileType.removeAttribute('required');
        tileSize.removeAttribute('required');
        weightage.removeAttribute('required');

        if (typeName.includes('paste') || typeName.includes('adhesive') || typeName.includes('chemical')) {
            pasteContainer.classList.remove('d-none');
            weightage.setAttribute('required', 'required');
        } else if (typeName.includes('sanitary') || typeName.includes('sink') || typeName.includes('basin')) {
            sanitarywareContainer.classList.remove('d-none');
        } else {
            // Default to Tiles specs
            tileContainer.classList.remove('d-none');
            tileCategory.setAttribute('required', 'required');
            tileType.setAttribute('required', 'required');
            tileSize.setAttribute('required', 'required');
        }
    }

    function previewSelectedImage(input) {
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('placeholderText');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush