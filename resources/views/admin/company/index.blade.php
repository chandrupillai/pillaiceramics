@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Company Details</h5>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.company.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Company Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $company->name ?? 'Pillai Ceramics') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $company->email ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $company->phone ?? '') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $company->address ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Company Logo</label>
                    <input type="file" name="logo" class="form-control">
                    
                    @if(isset($company) && $company->logo)
                        <div class="mt-2">
                            <small class="text-muted d-block mb-1">Current Logo:</small>
                            <img src="{{ asset($company->logo) }}" alt="Company Logo" class="img-thumbnail" style="max-height: 80px;">
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Save Company Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection