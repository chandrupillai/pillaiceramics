@extends('layouts.admin')

@section('title', 'Add New Showroom')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Add New Showroom</h4>
            <p class="text-muted fs-7 mb-0">Create a new branch location for your store network.</p>
        </div>
        <a href="{{ route('admin.shops.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.shops.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row g-4">
            {{-- Left Column: Core Details --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold mb-0">Branch Details</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Showroom Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Pillai Ceramics Trichy" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="e.g. Trichy" required>
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pincode</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}" placeholder="e.g. 620018">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" placeholder="Full address" required>{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+91 9444365536">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="trichy@pillaiceramics.in">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Right Column: Media & Status --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold mb-0">Media & Settings</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Showroom Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-input-label fw-semibold" for="is_active">Publish Showroom (Active)</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-save me-1"></i> Save Showroom
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection