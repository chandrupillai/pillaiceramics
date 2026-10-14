@extends('layouts.app')

@section('title', 'Leadership & Executive Team | Pillai Ceramics')
@section('meta_description', 'Meet the leadership team at Pillai Ceramics, guided by CEO Anand Pillai, CFO Thara A, General Manager Uma Maheswari, and Sales Managers Muthu & Ashok.')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .brand-gradient {
        background: linear-gradient(135deg, #0081b8 0%, #009edb 50%, #00b4fc 100%);
    }
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px -10px rgba(0, 129, 184, 0.12);
    }
    .leader-img-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
    }
    .leader-img-wrapper::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.7) 0%, transparent 60%);
        pointer-events: none;
    }
</style>
@endpush

@section('content')

<!-- 1. HERO HEADER SECTION -->
<section class="relative bg-slate-950 text-white py-20 lg:py-28 overflow-hidden border-b border-slate-800">
    <div class="absolute -top-32 -left-32 w-80 h-80 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-widest mb-6">
            <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
            Pillai Ceramics Leadership
        </span>
        <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-tight mb-6">
            Driven by Vision, <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Led by Experience</span>
        </h1>
        <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">
            Our executive leadership and management teams combine surface expertise to deliver unmatched quality across South India.
        </p>
    </div>
</section>

<!-- 2. EXECUTIVE BOARD (CEO & CFO) -->
@if(isset($executives) && $executives->count() > 0)
<section class="py-20 bg-slate-50 border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-cyan-600 font-bold uppercase text-xs tracking-widest">Executive Board</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Core Leadership</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($executives as $executive)
                @php
                    $roleTitle = ($executive->name == 'Anand Pillai') ? 'CEO & Founder' : 'Chief Financial Officer';
                    $bioText = ($executive->name == 'Anand Pillai') 
                        ? 'Founding Pillai Ceramics in June 2016, Anand Pillai established the company vision: making luxury architectural surfaces and our HPT Ceramics brand accessible.' 
                        : 'Managing financial architecture, strategic budgeting, and institutional supplier partnerships across all showroom locations.';
                    
                    // Fallback to local asset if profile photo is missing
                    $photoPath = optional($executive->profile)->photo;
                    $imageUrl = $photoPath ? asset('storage/' . $photoPath) : null;
                @endphp

                <div class="glass-card rounded-3xl p-8 lg:p-10 card-hover shadow-sm relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Profile Image / Showroom Backdrop Preview -->
                        @if($imageUrl)
                            <div class="leader-img-wrapper mb-6 aspect-[16/9] bg-slate-900">
                                <img src="{{ $imageUrl }}" alt="{{ $executive->name }}" class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div class="flex items-center justify-between mb-6">
                            <span class="bg-cyan-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ $roleTitle }}
                            </span>
                            <div class="flex items-center gap-2">
                                <a href="https://instagram.com/" target="_blank" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-cyan-600 hover:text-white text-slate-600 flex items-center justify-center transition" title="Instagram">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                                <a href="#" class="inline-flex items-center gap-1.5 bg-slate-900 text-white hover:bg-cyan-600 text-xs font-semibold px-3.5 py-2 rounded-xl transition">
                                    Digital Card
                                </a>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-1">{{ $executive->name }}</h3>
                        <p class="text-sm text-cyan-600 font-semibold mb-4">{{ $roleTitle }}</p>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">{{ $bioText }}</p>
                    </div>

                    <div class="pt-4 border-t border-slate-200/60 flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>Address: {{ optional($executive->profile)->address ?? 'Trichy Headquarters' }}</span>
                        <span class="text-cyan-600 font-semibold">Verified Profile</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 3. OPERATIONS & MANAGEMENT TEAM (Uma, Muthu, Ashok) -->
@if(isset($managementTeam) && $managementTeam->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-cyan-600 font-bold uppercase text-xs tracking-widest">Operations & Sales Leadership</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Management & Collection Team</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($managementTeam as $member)
                @php
                    if ($member->name == 'Uma Maheswari') {
                        $roleName = 'General Manager';
                        $bio = 'Overseeing day-to-day showroom administration and inventory distribution workflows.';
                        $defaultImg = asset('images/uma.png'); // fallback to uploaded asset if needed
                    } elseif ($member->name == 'Muthu') {
                        $roleName = 'Sales & Collection Manager';
                        $bio = 'Managing key dealer accounts, client sales pipelines, and structured collection cycles.';
                        $defaultImg = asset('images/muthu.png');
                    } else {
                        $roleName = 'Sales & Collection Manager';
                        $bio = 'Driving regional builder outreach, retail showroom orders, and efficient collection logistics.';
                        $defaultImg = asset('images/ashok.png');
                    }

                    $photoPath = optional($member->profile)->photo;
                    $memberImg = $photoPath ? asset('storage/' . $photoPath) : $defaultImg;
                @endphp

                <div class="glass-card rounded-2xl p-6 card-hover border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <!-- Image Container matching Showroom Background Style -->
                        <div class="leader-img-wrapper mb-5 aspect-[4/3] bg-slate-900">
                            <img src="{{ $memberImg }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-slate-100 text-slate-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                                {{ $roleName }}
                            </span>
                            <div class="flex items-center gap-1.5">
                                <a href="https://instagram.com/" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-cyan-600 hover:text-white text-slate-600 flex items-center justify-center transition" title="Instagram">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                                <a href="#" class="bg-slate-900 text-white hover:bg-cyan-600 text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition">Card</a>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-0.5">{{ $member->name }}</h3>
                        <p class="text-xs text-cyan-600 font-semibold mb-3">{{ $roleName }}</p>
                        <p class="text-slate-600 text-xs leading-relaxed mb-4">{{ $bio }}</p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-500 font-medium">
                        {{ optional($member->profile)->address ?? 'Showroom Staff' }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 4. CALL TO ACTION -->
<section class="py-16 brand-gradient text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <h2 class="text-3xl sm:text-4xl font-extrabold">Connect With Our Team</h2>
        <p class="text-slate-100 max-w-2xl mx-auto text-base">
            Partner with Pillai Ceramics for premium tile supplies and dealer queries.
        </p>
        <div class="pt-2 flex justify-center gap-4">
            <a href="{{ route('shops') }}" class="bg-slate-900 hover:bg-slate-950 text-white px-8 py-3.5 rounded-xl font-bold transition inline-block">
                Visit Our Showrooms
            </a>
        </div>
    </div>
</section>

@endsection