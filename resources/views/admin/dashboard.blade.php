@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name ?? 'Admin' }} 👋</h4>
        <p class="text-muted fs-7 mb-0">Live overview of locations, godowns, and user activity.</p>
    </div>
    <div>
        <span class="badge bg-light text-dark border px-3 py-2 fs-7">
            <i class="bi bi-calendar3 me-1"></i> {{ date('M d, Y') }}
        </span>
    </div>
</div>

<!-- Dynamic Metric Tiles -->
<div class="row g-3 mb-4">
    <!-- Active Locations -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white border-0 shadow-sm rounded-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fs-7 fw-medium">Active Locations</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ $stats['active_locations'] }}</h3>
                    <small class="text-muted fs-8">Out of {{ $stats['total_locations'] }} total</small>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 fs-4">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Godowns -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white border-0 shadow-sm rounded-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fs-7 fw-medium">Active Godowns</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ $stats['active_godowns'] }}</h3>
                    <small class="text-muted fs-8">Out of {{ $stats['total_godowns'] }} total</small>
                </div>
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 fs-4">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total System Users -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white border-0 shadow-sm rounded-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fs-7 fw-medium">Total Users</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ $stats['total_users'] }}</h3>
                    <small class="text-success fs-8 fw-semibold"><i class="bi bi-check-circle-fill"></i> Registered</small>
                </div>
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 fs-4">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Inactive Godowns -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3 bg-white border-0 shadow-sm rounded-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fs-7 fw-medium">Inactive Godowns</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ $stats['inactive_godowns'] }}</h3>
                    <small class="text-warning fs-8 fw-semibold"><i class="bi bi-exclamation-triangle-fill"></i> Attention Needed</small>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 fs-4">
                    <i class="bi bi-archive-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphs & Data Visualizations -->
<div class="row g-3 mb-4">
    <!-- Bar Chart: Godowns Per Location -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Godowns per Location</h6>
                <span class="badge bg-light text-muted border">Distribution</span>
            </div>
            <div style="height: 280px;">
                <canvas id="godownsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Donut Chart: Active vs Inactive Status -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Godown Status</h6>
                <span class="badge bg-light text-muted border">Ratio</span>
            </div>
            <div style="height: 280px;" class="d-flex align-items-center justify-content-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Godowns Table -->
<div class="card border-0 shadow-sm bg-white rounded-3">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Recently Added Godowns</h6>
        <a href="{{ route('admin.godowns.index') }}" class="btn btn-sm btn-outline-primary fw-semibold fs-8">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-7">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Godown Name</th>
                    <th>Code</th>
                    <th>Location</th>
                    <th>Incharge Person</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentGodowns as $godown)
                    <tr>
                        <td class="ps-3 fw-semibold text-dark">{{ $godown->name }}</td>
                        <td><span class="badge bg-secondary-subtle text-secondary border">{{ $godown->code }}</span></td>
                        <td>{{ $godown->location->name ?? 'N/A' }}</td>
                        <td>{{ $godown->incharge_person ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $godown->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} rounded-pill">
                                {{ $godown->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No godowns recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Bar Chart: Godowns per Location
        const locationCtx = document.getElementById('godownsChart').getContext('2d');
        new Chart(locationCtx, {
            type: 'bar',
            data: {
                labels: '{!! json_encode($locationNames) !!}',
                datasets: [{
                    label: 'Number of Godowns',
                    data: '{!! json_encode($godownCounts) !!}',
                    backgroundColor: '#0d6efd',
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // 2. Donut Chart: Active vs Inactive Godowns
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active Godowns', 'Inactive Godowns'],
                datasets: [{
                    data: ["{{ $stats['active_godowns'] }}", "{{ $stats['inactive_godowns'] }}"],
                    backgroundColor: ['#198754', '#ffc107'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush