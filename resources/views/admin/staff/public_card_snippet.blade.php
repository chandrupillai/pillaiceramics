@extends('layouts.app')

@section('title', 'Leadership & Executive Team | Pillai Ceramics')
@section('meta_description', 'Meet the leadership and management team at Pillai Ceramics, guided by our executive board and regional managers across South India.')

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

    .card-hover {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 129, 184, 0.15);
        border-color: rgba(0, 158, 219, 0.4);
    }

    .leader-img-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 1.25rem;
    }

    .leader-img-wrapper::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.75) 0%, rgba(15, 23, 42, 0.1) 50%, transparent 100%);
        pointer-events: none;
    }
</style>
@endpush

@section('content')

<!-- 1. HERO HEADER SECTION -->
<section class="relative bg-slate-950 text-white py-24 lg:py-32 overflow-hidden border-b border-slate-800">
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest mb-6 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
            Pillai Ceramics Leadership Board
        </span>
        <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-tight mb-6 text-white">
            Driven by Vision, <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Led by Experience</span>
        </h1>
        <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed font-normal">
            Our executive leadership and management teams combine decades of structural and surface expertise to deliver unmatched quality across Tamil Nadu & Puducherry.
        </p>
    </div>
</section>

<!-- 2. EXECUTIVE BOARD (Super Admins & Admins) -->
@if(isset($executives) && $executives->count() > 0)
<section class="py-24 bg-gradient-to-b from-slate-50 to-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-cyan-600 font-extrabold uppercase text-xs tracking-widest bg-cyan-50 px-3.5 py-1.5 rounded-full border border-cyan-100">Executive Board</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-3">Core Leadership & Direction</h2>
            <p class="text-slate-500 text-sm mt-2">Guiding strategic expansion, institutional partnerships, and surface excellence.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            @foreach($executives as $executive)
            @php
            $profile = $executive->profile;
            $photoPath = optional($profile)->avatar;
            $imageUrl = $photoPath ? asset('storage/' . $photoPath) : null;
            $roleLabel = str_replace('_', ' ', strtoupper($executive->role ?? 'Executive'));
            @endphp

            <div class="glass-card rounded-3xl p-8 lg:p-10 card-hover shadow-md relative overflow-hidden flex flex-col justify-between border border-slate-200/80 bg-white">
                <div>
                    <!-- Profile Image Avatar -->
                    <div class="leader-img-wrapper mb-6 aspect-[16/9] bg-slate-900 shadow-inner">
                        @if($imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $executive->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-cyan-950 text-cyan-400 font-black text-3xl">
                            {{ strtoupper(substr($executive->name, 0, 2)) }}
                        </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="bg-cyan-600/90 backdrop-blur-md text-white text-[11px] font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider shadow-lg">
                                {{ $roleLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $executive->name }}</h3>
                            <p class="text-sm font-semibold text-cyan-600 mt-0.5">{{ $executive->email }}</p>
                        </div>
                        <a href="{{ route('staff.digital-card', $executive->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-cyan-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 22 2 0 000 4z"></path>
                            </svg>
                            Digital Card
                        </a>
                    </div>

                    <p class="text-slate-600 text-sm leading-relaxed mt-4 mb-6">
                        {{ optional($profile)->bio ?: 'Providing expert executive leadership, maintaining high quality standards across HPT Tiles collections and Terafix HPT tile paste bonding solutions.' }}
                    </p>
                </div>

                <div class="pt-5 border-t border-slate-100 flex items-center justify-between text-xs font-medium text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ optional($profile)->address ?: 'Trichy Headquarters' }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-emerald-600 font-bold bg-emerald-50 px-2.5 py-1 rounded-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Verified Official
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 3. MANAGEMENT & OPERATIONS TEAM (Staff) -->
@if(isset($managementTeam) && $managementTeam->count() > 0)
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-cyan-600 font-extrabold uppercase text-xs tracking-widest bg-cyan-50 px-3.5 py-1.5 rounded-full border border-cyan-100">Operations & Support</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-3">Staff & Management Team</h2>
            <p class="text-slate-500 text-sm mt-2">Managing regional showroom inventories, customer care, and logistics workflows.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($managementTeam as $member)
            @php
            $profile = $member->profile;
            $photoPath = optional($profile)->avatar;
            $memberImg = $photoPath ? asset('storage/' . $photoPath) : null;
            $roleLabel = ucfirst($member->role ?? 'Staff Member');
            @endphp

            <div class="glass-card rounded-2xl p-6 card-hover border border-slate-200/80 bg-white shadow-sm flex flex-col justify-between">
                <div>
                    <!-- Member Photo -->
                    <div class="leader-img-wrapper mb-5 aspect-[4/3] bg-slate-900 shadow-inner">
                        @if($memberImg)
                        <img src="{{ $memberImg }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-slate-800 text-slate-300 font-bold text-2xl">
                            {{ strtoupper(substr($member->name, 0, 2)) }}
                        </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ $roleLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 tracking-tight">{{ $member->name }}</h3>
                            <p class="text-xs font-semibold text-cyan-600 mt-0.5">{{ $member->email }}</p>
                        </div>
                        <a href="{{ route('staff.digital-card', $member->slug) }}" target="_blank" class="inline-flex items-center gap-1 bg-slate-900 hover:bg-cyan-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm">
                            Digital Card
                        </a>
                    </div>

                    <p class="text-slate-600 text-xs leading-relaxed mt-3 mb-5">
                        {{ optional($profile)->bio ?: 'Dedicated to providing seamless customer support, showroom assistance, and reliable service.' }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-medium">
                    <span>{{ optional($profile)->address ?: 'Showroom Outlet' }}</span>
                    <span class="text-cyan-600 font-semibold">Active Staff</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 4. CALL TO ACTION -->
<section class="py-20 brand-gradient text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-slate-950/10 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10">
        <h2 class="text-3xl sm:text-4xl font-black">Connect With Our Showroom Network</h2>
        <p class="text-slate-100 max-w-2xl mx-auto text-base font-medium">
            Partner with Pillai Ceramics for premium vitrified tile supplies, wholesale inquiries, and Terafix HPT tile paste bonding solutions.
        </p>
        <div class="pt-2 flex flex-wrap justify-center gap-4">
            <a href="{{ route('shops') }}" class="bg-slate-900 hover:bg-slate-950 text-white px-8 py-3.5 rounded-xl font-bold transition shadow-lg text-sm">
                Visit Our 5 Showrooms
            </a>
        </div>
    </div>
</section>

@endsection