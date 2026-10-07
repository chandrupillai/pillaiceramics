@extends('layouts.admin')

@section('title', 'Manage Showrooms')

@section('content')
<div class="container-fluid py-3">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-shop text-primary me-2"></i> Showrooms / Branches
            </h4>
            <p class="text-muted fs-7 mb-0">Manage company branches, locations, contact info, and status.</p>
        </div>

        <div>
            <a href="{{ route('admin.shops.create') }}" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-plus-circle-fill me-1"></i> Add New Showroom
            </a>
        </div>
    </div>

    {{-- Alert Notifications --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fs-7 mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-7">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Branch Name</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shops as $shop)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    @if($shop->image)
                                        <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $shop->name }}" class="rounded me-2 border" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-2 border d-flex align-items-center justify-content-center text-muted" style="width: 40px; height: 40px;">
                                            <i class="bi bi-building"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="fw-semibold text-dark d-block">{{ $shop->name }}</span>
                                        <small class="text-muted">{{ $shop->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $shop->city }}</span></td>
                            <td>{{ $shop->phone ?? '-' }}</td>
                            <td><span class="text-truncate d-inline-block" style="max-width: 220px;">{{ $shop->address }}</span></td>
                            <td class="text-center">
                                @if($shop->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.shops.destroy', $shop->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this showroom?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                No showrooms found. Click <strong>"Add New Showroom"</strong> to add your first branch.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($shops->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $shops->links() }}
            </div>
        @endif
    </div>

</div>
@endsection