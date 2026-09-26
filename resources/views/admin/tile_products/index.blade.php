@extends('layouts.admin')

@section('title', 'Tile Products')

@section('content')

<div class="container-fluid py-3">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i>
                Tile Products
            </h4>
            <p class="text-muted fs-7 mb-0">
                Manage tile product inventory, pricing, stock, and product relationships.
            </p>
        </div>

        <a href="{{ route('admin.tile-products.create') }}"
           class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle-fill me-1"></i>
            Add Product
        </a>
    </div>


    {{-- Flash Notifications --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fs-7 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show fs-7 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif


    {{-- Filter & Search --}}
    <div class="card border-0 shadow-sm rounded-3 mb-3">

        <div class="card-body p-3">

            <form method="GET"
                  action="{{ route('admin.tile-products.index') }}"
                  class="row g-2 align-items-center">

                {{-- Search --}}
                <div class="col-12 col-md-4">

                    <div class="input-group input-group-sm">

                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>

                        <input type="text"
                               name="search"
                               class="form-control bg-light border-start-0"
                               placeholder="Search product name or SKU..."
                               value="{{ request('search') }}">

                    </div>

                </div>


                {{-- Category --}}
                <div class="col-12 col-md-3">

                    <select name="category_id"
                            class="form-select form-select-sm bg-light">

                        <option value="">
                            All Categories
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Type --}}
                <div class="col-12 col-md-3">

                    <select name="type_id"
                            class="form-select form-select-sm bg-light">

                        <option value="">
                            All Types
                        </option>

                        @foreach($types as $type)

                            <option value="{{ $type->id }}"
                                {{ request('type_id') == $type->id ? 'selected' : '' }}>

                                {{ $type->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Buttons --}}
                <div class="col-12 col-md-2 d-flex gap-1">

                    <button type="submit"
                            class="btn btn-sm btn-secondary w-100">

                        <i class="bi bi-funnel-fill me-1"></i>
                        Filter

                    </button>


                    @if(request()->hasAny(['search', 'category_id', 'type_id']))

                        <a href="{{ route('admin.tile-products.index') }}"
                           class="btn btn-sm btn-outline-secondary"
                           title="Reset Filters">

                            <i class="bi bi-arrow-counterclockwise"></i>

                        </a>

                    @endif

                </div>

            </form>

        </div>

    </div>


    {{-- Products Table --}}
    <div class="card border-0 shadow-sm rounded-3">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0 fs-7">

                <thead class="bg-light">

                    <tr>

                        <th class="ps-3">
                            <i class="bi bi-box-seam me-1"></i>
                            Product
                        </th>

                        <th>
                            <i class="bi bi-upc-scan me-1"></i>
                            SKU
                        </th>

                        <th>
                            <i class="bi bi-tags me-1"></i>
                            Category / Type
                        </th>

                        <th>
                            <i class="bi bi-rulers me-1"></i>
                            Size
                        </th>

                        <th>
                            <i class="bi bi-building me-1"></i>
                            Godown / Location
                        </th>

                        <th>
                            <i class="bi bi-currency-rupee me-1"></i>
                            Price
                        </th>

                        <th>
                            <i class="bi bi-boxes me-1"></i>
                            Stock
                        </th>

                        <th>
                            <i class="bi bi-toggle-on me-1"></i>
                            Status
                        </th>

                        <th class="text-end pe-3">
                            <i class="bi bi-gear-fill me-1"></i>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($products as $product)

                        <tr>

                            {{-- Product --}}
                            <td class="ps-3">

                                <div class="d-flex align-items-center">

                                    @if($product->image)

                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->product_name }}"
                                             class="rounded me-2 border"
                                             style="width: 42px; height: 42px; object-fit: cover;">

                                    @else

                                        <div class="bg-light rounded me-2 border d-flex align-items-center justify-content-center text-muted"
                                             style="width: 42px; height: 42px;">

                                            <i class="bi bi-image fs-5"></i>

                                        </div>

                                    @endif


                                    <div>

                                        <span class="fw-semibold text-dark d-block">
                                            {{ $product->product_name }}
                                        </span>

                                        @if($product->brand ?? false)

                                            <small class="text-muted">
                                                {{ $product->brand }}
                                            </small>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- SKU --}}
                            <td>

                                <span class="badge bg-light text-dark border">

                                    <i class="bi bi-upc me-1"></i>

                                    {{ $product->sku }}

                                </span>

                            </td>


                            {{-- Category / Type --}}
                            <td>

                                <div class="fw-medium">
                                    {{ $product->category->name ?? '-' }}
                                </div>

                                <small class="text-muted">
                                    {{ $product->type->name ?? '-' }}
                                </small>

                            </td>


                            {{-- Size --}}
                            <td>

                                <span class="text-dark">

                                    <i class="bi bi-aspect-ratio me-1 text-muted"></i>

                                    {{ $product->size->name ?? '-' }}

                                </span>

                            </td>


                            {{-- Godown / Location --}}
                            <td>

                                <div>

                                    <i class="bi bi-building text-muted me-1"></i>

                                    {{ $product->godown->name ?? '-' }}

                                </div>

                                <small class="text-muted">

                                    <i class="bi bi-geo-alt me-1"></i>

                                    {{ $product->location->name ?? '-' }}

                                </small>

                            </td>


                            {{-- Price --}}
                            <td class="fw-semibold">

                                <span class="text-dark">

                                    <i class="bi bi-currency-rupee me-1"></i>

                                    {{ number_format($product->price, 2) }}

                                </span>

                            </td>


                            {{-- Stock --}}
                            <td>

                                @if($product->stock_quantity > 10)

                                    <span class="badge bg-info-subtle text-info border">

                                        <i class="bi bi-boxes me-1"></i>

                                        {{ number_format($product->stock_quantity) }}

                                        boxes

                                    </span>

                                @elseif($product->stock_quantity > 0)

                                    <span class="badge bg-warning-subtle text-warning border">

                                        <i class="bi bi-exclamation-circle me-1"></i>

                                        {{ number_format($product->stock_quantity) }}

                                        boxes

                                    </span>

                                @else

                                    <span class="badge bg-danger-subtle text-danger border">

                                        <i class="bi bi-x-circle me-1"></i>

                                        Out of Stock

                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($product->is_active)

                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">

                                        <i class="bi bi-check-circle-fill me-1"></i>

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">

                                        <i class="bi bi-x-circle-fill me-1"></i>

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-end pe-3">

                                <div class="btn-group btn-group-sm"
                                     role="group">

                                    {{-- View --}}
                                    <a href="{{ route('admin.tile-products.show', $product->id) }}"
                                       class="btn btn-outline-primary"
                                       title="View Product">

                                        <i class="bi bi-eye-fill"></i>

                                    </a>


                                    {{-- Edit --}}
                                    <a href="{{ route('admin.tile-products.edit', $product->id) }}"
                                       class="btn btn-outline-secondary"
                                       title="Edit Product">

                                        <i class="bi bi-pencil-fill"></i>

                                    </a>


                                    {{-- Delete --}}
                                    <form action="{{ route('admin.tile-products.destroy', $product->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this product?');">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-outline-danger"
                                                title="Delete Product">

                                            <i class="bi bi-trash-fill"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center py-5 text-muted">

                                <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary"></i>

                                <div class="fw-semibold">
                                    No tile products found
                                </div>

                                <small>
                                    Try changing your search or filter.
                                </small>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($products->hasPages())

            <div class="card-footer bg-white border-top py-3">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">

                    <div class="text-muted fs-7">

                        Showing

                        <strong>
                            {{ $products->firstItem() ?? 0 }}
                        </strong>

                        to

                        <strong>
                            {{ $products->lastItem() ?? 0 }}
                        </strong>

                        of

                        <strong>
                            {{ $products->total() }}
                        </strong>

                        products

                    </div>


                    <div class="custom-pagination">

                        {{ $products->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}

                    </div>

                </div>

            </div>

        @endif

    </div>

</div>


{{-- Pagination Styling --}}
<style>

    .custom-pagination .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .custom-pagination .page-item .page-link {
        border-radius: 6px !important;
        border: 1px solid #dee2e6;
        min-width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: #495057;
        background-color: #fff;
        padding: 0 10px;
    }

    .custom-pagination .page-item .page-link:hover {
        background-color: #f1f3f5;
        color: #0d6efd;
        border-color: #b6d4fe;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }

    .custom-pagination .page-item.disabled .page-link {
        background-color: #f8f9fa;
        color: #adb5bd;
        border-color: #e9ecef;
    }

    @media (max-width: 576px) {

        .custom-pagination .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }

        .custom-pagination .page-item .page-link {
            min-width: 32px;
            height: 32px;
            font-size: 12px;
        }

    }

</style>

@endsection