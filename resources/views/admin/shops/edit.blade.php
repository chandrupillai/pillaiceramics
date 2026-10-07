@extends('layouts.admin')

@section('title', 'Edit Showroom')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Showroom: {{ $shop->name }}</h4>
            <p class="text-muted fs-7 mb-0">Update branch details, image, or active state.</p>
        </div>
        <a href="{{ route('admin.shops.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold mb-0">Branch Details</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Showroom Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $shop->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $shop->city) }}" required>
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pincode</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $shop->postal_code) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $shop->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $shop->phone) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $shop->email) }}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold mb-0">Media & Settings</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Image</label>
                            @if($shop->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $shop->name }}" class="img-fluid rounded border">
                                </div>
                            @else
                                <p class="text-muted fs-7">No image uploaded.</p>
                            @endif

                            <label class="form-label fw-semibold mt-2">Replace Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $shop->is_active) ? 'checked' : '' }}>
                            <label class="form-check-input-label fw-semibold" for="is_active">Publish Showroom (Active)</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-save me-1"></i> Update Showroom
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection