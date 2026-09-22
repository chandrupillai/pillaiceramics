@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name ?? 'Admin' }} 👋</h4>
        <p class="text-muted fs-7 mb-0">Overview of users, showrooms, and godowns.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fs-7 fw-medium">Active Locations</span>
                    <h3 class="fw-bold mt-1 mb-0">5</h3>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 fs-4">
                    <i class="bi bi-geo-alt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fs-7 fw-medium">Active Godowns</span>
                    <h3 class="fw-bold mt-1 mb-0">5</h3>
                </div>
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 fs-4">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection