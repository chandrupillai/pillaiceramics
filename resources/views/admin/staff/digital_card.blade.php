@extends('layouts.admin')

@section('title', 'Preview Card: ' . $staff->staff_name)

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-light border me-3"><i class="bi bi-chevron-left"></i></a>
            <h4 class="fw-bold mb-0">Staff Digital Business Card Preview</h4>
        </div>
        <div>
            <a href="{{ route('staff.public.card', $staff->id) }}" target="_blank" class="btn btn-sm btn-primary">
                <i class="bi bi-box-arrow-up-right me-1"></i> Open Public Card Link
            </a>
        </div>
    </div>

    {{-- Render the exact same card layout inside an admin container wrapper --}}
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-dark text-white">
                @include('admin.staff.public_card_snippet') {{-- Or keep your card HTML wrapped here --}}
            </div>
        </div>
    </div>
</div>
@endsection