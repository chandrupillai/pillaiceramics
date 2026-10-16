@extends('layouts.app')

@section('title', $location->name . ' Showroom | Pillai Ceramics')
@section('meta_description', 'Visit our ' . $location->name . ' branch for premium HPT tiles, sanitaryware, and Terafix HPT tile paste solutions.')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .brand-gradient {
        background: linear-gradient(135deg, #0081b8 0%, #009edb 50%, #00b4fc 100%);
    }
</style>
@endpush

@section('content')

<!-- 1. DYNAMIC BANNER SECTION -->
<section class="relative bg-slate-950 text-white py-28 lg:py-36 overflow-hidden border-b border-slate-800">
    @if($location->banner)
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('storage/' . $location->banner) }}" alt="{{ $location->name }}" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
    </div>
    @else
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest mb-6 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
            Pillai Ceramics Showroom Network
        </span>
        <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-tight mb-6 text-white">
            {{ $location->name }}
        </h1>
        <p class="text-lg sm:text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed font-normal">
            Your trusted destination for HPT vitrified tiles, premium sanitaryware, and Terafix HPT tile paste solutions in {{ $location->city }}.
        </p>
    </div>
</section>

<!-- 2. DETAILS & SHOWROOM INNER VIEW -->
<section class="py-24 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left Column: Contact & Quick Info -->
            <div class="lg:col-span-5 space-y-8">
                <div class="glass-card rounded-3xl p-8 shadow-sm border border-slate-200/80 bg-white">
                    <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Branch Information
                    </h2>

                    <div class="space-y-4 text-sm text-slate-600">
                        <div>
                            <strong class="block text-xs uppercase tracking-wider text-slate-400 mb-1">Address</strong>
                            <p class="font-medium text-slate-800">{{ $location->address }}</p>
                            <p class="font-medium text-slate-800">{{ $location->city }}{{ $location->state ? ', ' . $location->state : '' }} {{ $location->postal_code ? '- ' . $location->postal_code : '' }}</p>
                        </div>

                        @if($location->phone)
                        <div>
                            <strong class="block text-xs uppercase tracking-wider text-slate-400 mb-1">Phone Number</strong>
                            <a href="tel:{{ $location->phone }}" class="font-bold text-cyan-600 hover:underline">{{ $location->phone }}</a>
                        </div>
                        @endif

                        @if($location->email)
                        <div>
                            <strong class="block text-xs uppercase tracking-wider text-slate-400 mb-1">Email Address</strong>
                            <a href="mailto:{{ $location->email }}" class="font-bold text-cyan-600 hover:underline">{{ $location->email }}</a>
                        </div>
                        @endif
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col gap-3">
                        @if($location->phone)
                        <a href="https://wa.me/{{ $location->phone }}" target="_blank" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-center transition shadow-sm text-sm flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp text-lg"></i> Chat on WhatsApp
                        </a>
                        @endif
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($location->name . ' ' . $location->address . ' ' . $location->city) }}" target="_blank" class="w-full py-3 px-4 bg-slate-900 hover:bg-cyan-600 text-white font-bold rounded-xl text-center transition shadow-sm text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            Get Directions
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Showroom Inner Image & Map Preview -->
            <div class="lg:col-span-7 space-y-8">
                @if($location->inner_image)
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-white aspect-[16/10]">
                    <img src="{{ asset('storage/' . $location->inner_image) }}" alt="{{ $location->name }} Showroom" class="w-full h-full object-cover">
                </div>
                @endif

                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-white p-2">
                    <iframe
                        width="100%"
                        height="320"
                        style="border:0; border-radius: 1.25rem;"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q={{ urlencode($location->name . ' ' . $location->address . ' ' . $location->city) }}&output=embed">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 3. CALL TO ACTION -->
<section class="py-20 brand-gradient text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10">
        <h2 class="text-3xl sm:text-4xl font-black">Explore All Our Showroom Locations</h2>
        <p class="text-slate-100 max-w-xl mx-auto text-base font-medium">
            Visit any of our branches across Tamil Nadu to check out live samples of HPT Tiles and Terafix tile bonding products.
        </p>
        <div class="pt-2">
            <a href="{{ route('shops') }}" class="bg-slate-900 hover:bg-slate-950 text-white px-8 py-3.5 rounded-xl font-bold transition shadow-lg text-sm inline-block">
                View All Showrooms
            </a>
        </div>
    </div>
</section>

@endsection