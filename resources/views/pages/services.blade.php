@extends('layouts.app')

@section('title', 'Professional Services Offered Across All Branches')
@section('meta_description', 'Explore our comprehensive range of retail and consultation services available at all 5 branch locations.')

@section('content')
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Our Professional Services</h1>
            <p class="text-slate-600">Offered with guaranteed consistency across Trichy, Karaikal, and all 5 shop locations.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <h2 class="text-xl font-bold text-slate-900 mb-3">On-Site Retail Assistance</h2>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Personalized consultation and product selection guided by experienced staff at every location.
                </p>
                <a href="{{ route('contact') }}" class="text-indigo-600 font-semibold text-sm hover:underline">Inquire Service &rarr;</a>
            </div>

            <!-- Service 2 -->
            <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <h2 class="text-xl font-bold text-slate-900 mb-3">Local Delivery & Fulfillment</h2>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Fast order fulfillment dispatched directly from the branch nearest to your geographic location.
                </p>
                <a href="{{ route('contact') }}" class="text-indigo-600 font-semibold text-sm hover:underline">Inquire Service &rarr;</a>
            </div>

            <!-- Service 3 -->
            <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <h2 class="text-xl font-bold text-slate-900 mb-3">After-Sales Support</h2>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Maintenance, returns, and support managed directly by the branch admin in your area.
                </p>
                <a href="{{ route('contact') }}" class="text-indigo-600 font-semibold text-sm hover:underline">Inquire Service &rarr;</a>
            </div>
        </div>
    </div>
</section>
@endsection