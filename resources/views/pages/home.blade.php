@extends('layouts.app')

@section('title', 'Pillai Ceramics | Luxury Tiles, Marble, Sanitaryware & Ramco Hard Worker Dealer')
@section('meta_description', 'Founded by CEO AnAnand Pillai in Trichy (June 2016), Pillai Ceramics offers luxury Hpt Tiles tiles, Ramco Hard Worker construction chemicals & cements, and designer sanitaryware across 5 regional showrooms.')

@push('styles')
<style>
    /* Glassmorphism & Modern Micro-Interactions */
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
    .tile-hover-card {
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s ease;
    }
    .tile-hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px -10px rgba(0, 129, 184, 0.15);
    }
    .brand-blue-gradient {
        background: linear-gradient(135deg, #0081b8 0%, #009edb 50%, #00b4fc 100%);
    }
    .brand-dark-gradient {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }
</style>
@endpush

@section('content')

<!-- 1. HERO SECTION -->
<section class="relative bg-slate-950 text-white overflow-hidden py-24 lg:py-32 border-b border-slate-800">
    <!-- Architectural Glow Accents -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container-fluid max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6">
                <span class="inline-flex items-center gap-2 bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                    Founded in Trichy • June 2016
                </span>
                
                <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-tight">
                    Crafting Architectural Luxury With <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Hpt Tiles</span> & Ramco
                </h1>
                
                <p class="text-slate-300 text-lg max-w-xl leading-relaxed">
                    Pillai Ceramics is Tamil Nadu & Puducherry's premier destination for high-definition vitrified tiles, GVT slab marbles, luxury sanitaryware, and trusted Ramco building materials across 5 regional outlets.
                </p>

                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('shops') }}" class="brand-blue-gradient text-white px-8 py-3.5 rounded-xl font-bold shadow-lg hover:shadow-cyan-500/25 transition transform hover:-translate-y-0.5 text-center">
                        Explore Showrooms
                    </a>
                    <a href="{{ route('services') }}" class="bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-700 px-8 py-3.5 rounded-xl font-semibold transition text-center">
                        View Collections
                    </a>
                </div>

                <!-- Metric Counters -->
                <div class="grid grid-cols-3 gap-6 pt-8 border-t border-slate-800/80 text-center sm:text-left">
                    <div>
                        <span class="text-2xl sm:text-3xl font-black text-cyan-400">1,000+</span>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mt-1">Exclusive Designs</p>
                    </div>
                    <div>
                        <span class="text-2xl sm:text-3xl font-black text-cyan-400">5</span>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mt-1">Regional Branches</p>
                    </div>
                    <div>
                        <span class="text-2xl sm:text-3xl font-black text-amber-400">Ramco</span>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mt-1">Authorized Dealer</p>
                    </div>
                </div>
            </div>

            <!-- Featured Product Showcase -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto rounded-3xl overflow-hidden shadow-2xl border border-slate-800 bg-slate-900/60 p-5 backdrop-blur-xl">
                    <div class="rounded-2xl overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Hpt Tiles Luxury Slab Tiles" class="w-full h-80 object-cover transform group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 p-4 glass-card rounded-xl text-slate-900">
                            <span class="inline-block bg-cyan-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded uppercase tracking-wider mb-1">Our Brand & Authorized Dealership</span>
                            <h3 class="font-bold text-lg">Hpt Tiles & Ramco Range</h3>
                            <p class="text-xs text-slate-600">Engineered for enduring structural strength and architectural finish</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- 2. EXECUTIVE ABOUT SECTION -->
<section class="py-16 bg-white border-b border-slate-100">
    <div class="container-fluid max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-900 text-white rounded-3xl p-8 lg:p-12 border border-slate-800 shadow-xl relative overflow-hidden">
            <!-- Background Accent -->
            <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-gradient-to-l from-cyan-500/10 to-transparent pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                
                <!-- Founder Spotlight Badge -->
                <div class="lg:col-span-3 flex flex-col items-start border-b lg:border-b-0 lg:border-r border-slate-800 pb-6 lg:pb-0 lg:pr-8">
                    <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Executive Leadership</span>
                    <h3 class="text-2xl font-black text-white mt-1">AnAnand Pillai</h3>
                    <p class="text-xs text-slate-400 font-medium">Founder & Chief Executive Officer</p>
                    <div class="mt-4 inline-flex items-center gap-2 bg-slate-800/90 border border-slate-700 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Founded June 2016
                    </div>
                </div>

                <!-- Mission & Vision Content -->
                <div class="lg:col-span-6 space-y-3">
                    <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Our Journey & Expansion</span>
                    <h4 class="text-xl font-bold text-white leading-snug">
                        Building a Legacy of Surface Excellence from Trichy across South India
                    </h4>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Under the leadership of **AnAnand Pillai**, Pillai Ceramics began its journey in **Trichy in June 2016**. Driven by a vision to deliver world-class aesthetic and structural solutions, we established **Hpt Tiles** and partnered as an authorized **Ramco dealer**, serving masons, contractors, and hard-working builders.
                    </p>
                </div>

                <!-- Network Highlights -->
                <div class="lg:col-span-3 bg-slate-800/80 rounded-2xl p-5 border border-slate-700/80 space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-700 pb-2">
                        <span class="text-xs font-medium text-slate-400">Headquarters</span>
                        <span class="text-xs font-bold text-cyan-400">Trichy</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-700 pb-2">
                        <span class="text-xs font-medium text-slate-400">Total Showrooms</span>
                        <span class="text-xs font-bold text-white">5 Locations</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-400">Authorized Dealer</span>
                        <span class="text-xs font-bold text-amber-400">Ramco Cements</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<!-- 3. BRAND ADVANTAGE GRID (WHY Hpt Tiles) -->
<section class="py-16 bg-white border-b border-slate-100">
    <div class="container-fluid max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-cyan-600 font-bold uppercase text-xs tracking-widest">Brand Excellence</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Why Choose Hpt Tiles?</h2>
            <p class="text-slate-600 text-sm mt-2">Designed for residential, commercial, and architectural projects with zero compromise on quality.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-white hover:border-cyan-500 transition shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-600/10 text-cyan-600 flex items-center justify-center font-bold text-lg mb-4">01</div>
                <h3 class="font-bold text-slate-900 text-lg mb-1">Direct Factory Quality</h3>
                <p class="text-slate-600 text-xs leading-relaxed">Sourced directly to ensure premium vitrification and uniform batch consistency.</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-white hover:border-cyan-500 transition shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-600/10 text-cyan-600 flex items-center justify-center font-bold text-lg mb-4">02</div>
                <h3 class="font-bold text-slate-900 text-lg mb-1">Low Water Absorption</h3>
                <p class="text-slate-600 text-xs leading-relaxed">High-density pressing prevents moisture seepage, discoloration, and structural wear.</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-white hover:border-cyan-500 transition shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-600/10 text-cyan-600 flex items-center justify-center font-bold text-lg mb-4">03</div>
                <h3 class="font-bold text-slate-900 text-lg mb-1">Scratch & Stain Shield</h3>
                <p class="text-slate-600 text-xs leading-relaxed">Advanced protective glaze retains high gloss and matt clarity even under heavy foot traffic.</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-white hover:border-cyan-500 transition shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-600/10 text-cyan-600 flex items-center justify-center font-bold text-lg mb-4">04</div>
                <h3 class="font-bold text-slate-900 text-lg mb-1">Precision Edge Calibrated</h3>
                <p class="text-slate-600 text-xs leading-relaxed">Rectified micro-edges allow seamless minimal-grout tile alignment across large floors.</p>
            </div>
        </div>
    </div>
</section>


<!-- 3.5. MIDDLE SECTION: AUTHORIZED RAMCO HARDWORKER SHOWCASE -->
<section class="py-16 bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 text-white relative overflow-hidden border-y border-slate-800">
    <div class="absolute -right-20 top-1/2 -translate-y-1/2 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container-fluid max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <div class="lg:col-span-5 space-y-4">
                <span class="inline-flex items-center gap-2 bg-amber-500/10 border border-amber-500/30 text-amber-400 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    Authorized Ramco Dealer
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                    Powering Real Hard Workers With <span class="text-amber-400">Ramco Products</span>
                </h2>
                <p class="text-slate-300 text-sm leading-relaxed">
                    We supply heavy-duty construction solutions engineered for masons, engineers, and hard-working builders who demand maximum structural bonding and zero-defect quality.
                </p>
                <div class="pt-2">
                    <a href="{{ route('shops') }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-slate-950 px-6 py-3 rounded-xl font-bold transition shadow-lg shadow-amber-500/20 text-sm">
                        <span>Order Ramco Materials</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:border-amber-500/50 transition">
                    <div class="w-9 h-9 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-white font-bold text-base mb-1">Ramco Super Grade Cement</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">High early strength and superior corrosion resistance for heavy-duty load structures.</p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:border-amber-500/50 transition">
                    <div class="w-9 h-9 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-white font-bold text-base mb-1">Hard Worker Chemicals</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">Advanced tile adhesives, eco plasters, waterproof coatings, and structural bonding solutions.</p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:border-amber-500/50 transition">
                    <div class="w-9 h-9 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-white font-bold text-base mb-1">Crack-Free Bond Strength</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">Eliminates hollow sounds, debonding, and surface cracks under harsh climate conditions.</p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 hover:border-amber-500/50 transition">
                    <div class="w-9 h-9 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path></svg>
                    </div>
                    <h3 class="text-white font-bold text-base mb-1">Direct Outlet Supply</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">Fresh stock delivered directly across all 5 Pillai Ceramics branch godowns.</p>
                </div>

            </div>

        </div>
    </div>
</section>


<!-- 4. INTERACTIVE CATEGORY TABBED SHOWCASE -->
<section class="py-20 bg-slate-50">
    <div class="container-fluid max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-cyan-600 font-bold uppercase text-xs tracking-widest">Our Collections</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Explore By Category</h2>
            <p class="text-slate-600 text-sm mt-3">Filter through our catalog featuring Hpt Tiles, Ramco Hard Worker series, and sanitaryware collections.</p>
            
            <div class="flex flex-wrap justify-center gap-2 mt-8" id="categoryFilter">
                <button class="filter-btn active-filter bg-cyan-600 text-white px-5 py-2 rounded-full text-sm font-semibold transition" data-filter="all">All Collections</button>
                <button class="filter-btn bg-white text-slate-700 border border-slate-200 px-5 py-2 rounded-full text-sm font-semibold hover:bg-slate-100 transition" data-filter="floor">Floor & Slabs</button>
                <button class="filter-btn bg-white text-slate-700 border border-slate-200 px-5 py-2 rounded-full text-sm font-semibold hover:bg-slate-100 transition" data-filter="wall">Wall & Elevation</button>
                <button class="filter-btn bg-white text-slate-700 border border-slate-200 px-5 py-2 rounded-full text-sm font-semibold hover:bg-slate-100 transition" data-filter="ramco">Ramco & Construction</button>
                <button class="filter-btn bg-white text-slate-700 border border-slate-200 px-5 py-2 rounded-full text-sm font-semibold hover:bg-slate-100 transition" data-filter="sanitary">Sanitaryware</button>
            </div>
        </div>

        <!-- Product Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="productsGrid">
            
            <!-- Item 1 -->
            <div class="product-card tile-hover-card bg-white rounded-2xl overflow-hidden border border-slate-200/70 shadow-sm" data-category="floor">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1615873968403-89e068629265?auto=format&fit=crop&w=700&q=80" alt="Glossy Marble Tiles" class="w-full h-full object-cover transition duration-500 hover:scale-110">
                    <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-medium">HPT Floor Series</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-slate-900 mb-2">HPT High-Gloss Marble Vitrified</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Stain-resistant, mirror-finish 4x2ft and large slab tiles crafted under our signature brand.</p>
                    <a href="{{ route('shops') }}" class="inline-flex items-center text-cyan-600 font-bold text-sm hover:gap-2 transition-all">Check Showroom Availability &rarr;</a>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="product-card tile-hover-card bg-white rounded-2xl overflow-hidden border border-slate-200/70 shadow-sm" data-category="wall">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=700&q=80" alt="Kitchen Wall Tiles" class="w-full h-full object-cover transition duration-500 hover:scale-110">
                    <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-medium">Wall Tiles</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-slate-900 mb-2">Designer Kitchen & Elevation Walls</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Waterproof ceramic wall tiles featuring modern geometric layouts, 3D textures, and stone finishes.</p>
                    <a href="{{ route('shops') }}" class="inline-flex items-center text-cyan-600 font-bold text-sm hover:gap-2 transition-all">Check Showroom Availability &rarr;</a>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="product-card tile-hover-card bg-white rounded-2xl overflow-hidden border border-slate-200/70 shadow-sm" data-category="ramco">
                <div class="h-64 overflow-hidden relative bg-slate-900 flex items-center justify-center p-6">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=700&q=80" alt="Ramco Construction Chemicals" class="w-full h-full object-cover opacity-80 transition duration-500 hover:scale-110">
                    <span class="absolute top-4 left-4 bg-amber-500 text-slate-950 text-xs px-3 py-1 rounded-full font-bold">Ramco Hard Worker</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-slate-900 mb-2">Ramco Cement & Hard Worker Range</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Heavy-duty construction cement, waterproof adhesives, and high-strength eco plasters.</p>
                    <a href="{{ route('shops') }}" class="inline-flex items-center text-amber-600 font-bold text-sm hover:gap-2 transition-all">Inquire Wholesale Rates &rarr;</a>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="product-card tile-hover-card bg-white rounded-2xl overflow-hidden border border-slate-200/70 shadow-sm" data-category="sanitary">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=700&q=80" alt="Luxury Bathroom Sanitaryware" class="w-full h-full object-cover transition duration-500 hover:scale-110">
                    <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-medium">Sanitaryware</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-slate-900 mb-2">Luxury Sanitary & Bath Fittings</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Matt-finish wall-hung closets, vanity washbasins, and premium brass chrome bath accessories.</p>
                    <a href="{{ route('shops') }}" class="inline-flex items-center text-cyan-600 font-bold text-sm hover:gap-2 transition-all">Check Showroom Availability &rarr;</a>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- 5. LOCATIONS & GOOGLE MAPS SHOWCASE (ALL 5 BRANCHES WITH MAP EMBEDS) -->
<section class="py-20 bg-white">
    <div class="container-fluid max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
            <div>
                <span class="text-cyan-600 font-bold uppercase text-xs tracking-widest">Interactive Network Map</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Visit Our Showrooms</h2>
                <p class="text-slate-500 text-sm mt-1">Get direct directions to our 5 showroom & godown locations across Tamil Nadu & Puducherry.</p>
            </div>
            <a href="{{ route('shops') }}" class="mt-4 md:mt-0 text-cyan-600 font-bold hover:underline">View All Locations &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- 1. Trichy (HQ Main) -->
            <div class="rounded-2xl border-2 border-cyan-500/30 bg-cyan-50/20 hover:bg-white hover:border-cyan-500 shadow-sm transition overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Google Map Embed -->
                    <div class="h-48 w-full bg-slate-200 relative">
                        <iframe 
                            class="w-full h-full border-0" 
                            loading="lazy" 
                            allowfullscreen 
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q=111+Pitchi+nagar+Varageri+Trichy+620008&output=embed">
                        </iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <span class="bg-cyan-600 text-white text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full font-bold">HQ & Flagship (Est. June 2016)</span>
                            <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-1">Pillai Ceramics - Trichy</h3>
                        <p class="text-slate-600 text-xs leading-relaxed mb-4">111, Pitchi nagar, Varageri, Trichy - 620008, Tamil Nadu</p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-0 flex items-center justify-between border-t border-slate-100/80 mt-auto">
                    <a href="https://www.google.com/maps/search/?api=1&query=111+Pitchi+nagar+Varageri+Trichy+620008" target="_blank" class="inline-flex items-center gap-1.5 text-cyan-600 font-bold text-xs hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Get Map Directions
                    </a>
                    <a href="{{ route('shops.detail', ['location' => 'trichy']) }}" class="text-slate-900 font-bold text-xs hover:text-cyan-600 transition">Showroom Details &rarr;</a>
                </div>
            </div>

            <!-- 2. Karur Branch -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-cyan-500 shadow-sm transition overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Google Map Embed -->
                    <div class="h-48 w-full bg-slate-200 relative">
                        <iframe 
                            class="w-full h-full border-0" 
                            loading="lazy" 
                            allowfullscreen 
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q=Anamalai+Mondy+No+596/1A+Next+PSR+Mahal+Andalkovil+East+Sk+Garden+Covai+Road+Andankoil+Karur+639008&output=embed">
                        </iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <span class="bg-slate-200 text-slate-700 text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full font-bold">Regional Branch</span>
                            <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-1">Pillai Ceramics - Karur</h3>
                        <p class="text-slate-600 text-xs leading-relaxed mb-4">Anamalai Mondy No 596/1A, Next PSR Mahal, Andalkovil East, Sk Garden, Covai Road, Andankoil, Karur - 639008, Tamil Nadu</p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-0 flex items-center justify-between border-t border-slate-100/80 mt-auto">
                    <a href="https://www.google.com/maps/search/?api=1&query=Anamalai+Mondy+No+596/1A+Next+PSR+Mahal+Andalkovil+East+Sk+Garden+Covai+Road+Andankoil+Karur+639008" target="_blank" class="inline-flex items-center gap-1.5 text-cyan-600 font-bold text-xs hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Get Map Directions
                    </a>
                    <a href="{{ route('shops.detail', ['location' => 'karur']) }}" class="text-slate-900 font-bold text-xs hover:text-cyan-600 transition">Showroom Details &rarr;</a>
                </div>
            </div>

            <!-- 3. Karaikal Branch -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-cyan-500 shadow-sm transition overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Google Map Embed -->
                    <div class="h-48 w-full bg-slate-200 relative">
                        <iframe 
                            class="w-full h-full border-0" 
                            loading="lazy" 
                            allowfullscreen 
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q=Pillai+Ceramics+Church+Street+Karaikal+Puducherry&output=embed">
                        </iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <span class="bg-slate-200 text-slate-700 text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full font-bold">Coastal Showroom</span>
                            <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-1">Pillai Ceramics - Karaikal</h3>
                        <p class="text-slate-600 text-xs leading-relaxed mb-4">Church Street, Karaikal, Puducherry</p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-0 flex items-center justify-between border-t border-slate-100/80 mt-auto">
                    <a href="https://www.google.com/maps/search/?api=1&query=Pillai+Ceramics+Church+Street+Karaikal+Puducherry" target="_blank" class="inline-flex items-center gap-1.5 text-cyan-600 font-bold text-xs hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Get Map Directions
                    </a>
                    <a href="{{ route('shops.detail', ['location' => 'karaikal']) }}" class="text-slate-900 font-bold text-xs hover:text-cyan-600 transition">Showroom Details &rarr;</a>
                </div>
            </div>

            <!-- 4. Ramanathapuram Branch (Maharaja Tiles) -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-cyan-500 shadow-sm transition overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Google Map Embed -->
                    <div class="h-48 w-full bg-slate-200 relative">
                        <iframe 
                            class="w-full h-full border-0" 
                            loading="lazy" 
                            allowfullscreen 
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q=Maharaja+tiles+Sakkarakottai+Tamil+Nadu+623502&output=embed">
                        </iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <span class="bg-amber-500/10 text-amber-700 border border-amber-500/30 text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full font-bold">Partner Outlet</span>
                            <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-1">Maharaja Tiles</h3>
                        <p class="text-slate-600 text-xs leading-relaxed mb-4">Sakkarakottai, Ramanathapuram, Tamil Nadu - 623502</p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-0 flex items-center justify-between border-t border-slate-100/80 mt-auto">
                    <a href="https://www.google.com/maps/search/?api=1&query=Maharaja+tiles+Sakkarakottai+Tamil+Nadu+623502" target="_blank" class="inline-flex items-center gap-1.5 text-cyan-600 font-bold text-xs hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Get Map Directions
                    </a>
                    <a href="{{ route('shops.detail', ['location' => 'ramanathapuram']) }}" class="text-slate-900 font-bold text-xs hover:text-cyan-600 transition">Showroom Details &rarr;</a>
                </div>
            </div>

            <!-- 5. Madurai Branch -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-cyan-500 shadow-sm transition overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Google Map Embed -->
                    <div class="h-48 w-full bg-slate-200 relative">
                        <iframe 
                            class="w-full h-full border-0" 
                            loading="lazy" 
                            allowfullscreen 
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q=KK+Nagar+Madurai+Tamil+Nadu&output=embed">
                        </iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <span class="bg-slate-200 text-slate-700 text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full font-bold">Regional Branch</span>
                            <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-1">Pillai Ceramics - Madurai</h3>
                        <p class="text-slate-600 text-xs leading-relaxed mb-4">KK Nagar, Madurai, Tamil Nadu</p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-0 flex items-center justify-between border-t border-slate-100/80 mt-auto">
                    <a href="https://www.google.com/maps/search/?api=1&query=KK+Nagar+Madurai+Tamil+Nadu" target="_blank" class="inline-flex items-center gap-1.5 text-cyan-600 font-bold text-xs hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Get Map Directions
                    </a>
                    <a href="{{ route('shops.detail', ['location' => 'madurai']) }}" class="text-slate-900 font-bold text-xs hover:text-cyan-600 transition">Showroom Details &rarr;</a>
                </div>
            </div>

        </div>
    </div>
    
</section>

@endsection

@push('scripts')
<script>
    // Category Filter Animation
    $(document).ready(function() {
        $('.filter-btn').on('click', function() {
            var filter = $(this).attr('data-filter');

            $('.filter-btn').removeClass('active-filter bg-cyan-600 text-white').addClass('bg-white text-slate-700');
            $(this).addClass('active-filter bg-cyan-600 text-white').removeClass('bg-white text-slate-700');

            if(filter === 'all') {
                $('.product-card').fadeIn(400);
            } else {
                $('.product-card').hide();
                $('.product-card[data-category="' + filter + '"]').fadeIn(400);
            }
        });
    });
</script>
@endpush