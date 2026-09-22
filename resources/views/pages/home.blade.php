@extends('layouts.app')

@section('title', 'Pillai Ceramics | Luxury Tiles, Marble & Sanitaryware Showroom')
@section('meta_description', 'Explore premium floor tiles, wall tiles, and designer sanitaryware across our 5 showrooms in Trichy, Karaikal, Karur, Ramanathapuram, and Madurai.')

@push('styles')
<style>
    /* Custom Modern Glassmorphism & Animations */
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .tile-hover-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .tile-hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 30px -10px rgba(0, 158, 219, 0.2);
    }
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .brand-blue-gradient {
        background: linear-gradient(135deg, #0081b8 0%, #009edb 50%, #00b4fc 100%);
    }
</style>
@endpush

@section('content')

<!-- 1. HERO SECTION WITH ANIMATED BADGE & GLASSMORPHISM -->
<section class="relative bg-slate-900 text-white overflow-hidden py-24 lg:py-32">
    <!-- Background Architectural Glow -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>

    <div class="container-fluid max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 animate-fade-in space-y-6">
                <span class="inline-flex items-center gap-2 bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                    5 Showrooms: Trichy, Karaikal, Karur, Ramanathapuram & Madurai
                </span>
                
                <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-tight">
                    Elevate Your Spaces With <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Luxury Tiles</span> & Sanitaryware
                </h1>
                
                <p class="text-slate-300 text-lg max-w-xl leading-relaxed">
                    Discover handpicked Italian finish tiles, GVT slab marbles, non-slip bathroom ceramics, and modern bath fittings at Pillai Ceramics.
                </p>

                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="{{ route('shops') }}" class="brand-blue-gradient text-white px-8 py-3.5 rounded-xl font-bold shadow-lg hover:shadow-cyan-500/30 transition transform hover:-translate-y-0.5 text-center">
                        Explore Showrooms
                    </a>
                    <a href="{{ route('services') }}" class="bg-slate-800/80 hover:bg-slate-800 text-slate-200 border border-slate-700 px-8 py-3.5 rounded-xl font-semibold transition text-center">
                        Our Collections
                    </a>
                </div>

                <!-- Stats counter -->
                <div class="grid grid-cols-3 gap-6 pt-8 border-t border-slate-800 text-center sm:text-left">
                    <div>
                        <span class="text-2xl sm:text-3xl font-extrabold text-cyan-400">500+</span>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-medium mt-1">Tile Designs</p>
                    </div>
                    <div>
                        <span class="text-2xl sm:text-3xl font-extrabold text-cyan-400">5</span>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-medium mt-1">Branches</p>
                    </div>
                    <div>
                        <span class="text-2xl sm:text-3xl font-extrabold text-cyan-400">25+</span>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-medium mt-1">Years Trust</p>
                    </div>
                </div>
            </div>

            <!-- Hero Interactive Showcase Card -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto rounded-3xl overflow-hidden shadow-2xl border border-slate-700 bg-slate-800/50 p-6 backdrop-blur-md">
                    <div class="rounded-2xl overflow-hidden relative group">
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Luxury Interior Tiles" class="w-full h-80 object-cover transform group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 p-4 glass-card rounded-xl text-slate-900">
                            <p class="text-xs font-bold text-cyan-600 uppercase">Featured Collection</p>
                            <h3 class="font-bold text-lg">Italian Finish Vitrified Slabs</h3>
                            <p class="text-xs text-slate-600">Available across all 5 branch showrooms</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- 2. INTERACTIVE CATEGORY TABBED SHOWCASE -->
<section class="py-20 bg-slate-50">
    <div class="container-fluid max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-cyan-600 font-bold uppercase text-xs tracking-widest">Our Range</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Explore By Category</h2>
            <p class="text-slate-600 text-sm mt-3">Filter our product collections to find the perfect match for your home or commercial space.</p>
            
            <!-- Category Filter Buttons (jQuery Animated) -->
            <div class="flex flex-wrap justify-center gap-2 mt-8" id="categoryFilter">
                <button class="filter-btn active-filter bg-cyan-600 text-white px-5 py-2 rounded-full text-sm font-semibold transition" data-filter="all">All Products</button>
                <button class="filter-btn bg-white text-slate-700 border border-slate-200 px-5 py-2 rounded-full text-sm font-semibold hover:bg-slate-100 transition" data-filter="floor">Floor Tiles</button>
                <button class="filter-btn bg-white text-slate-700 border border-slate-200 px-5 py-2 rounded-full text-sm font-semibold hover:bg-slate-100 transition" data-filter="wall">Wall & Elevation</button>
                <button class="filter-btn bg-white text-slate-700 border border-slate-200 px-5 py-2 rounded-full text-sm font-semibold hover:bg-slate-100 transition" data-filter="sanitary">Sanitaryware</button>
            </div>
        </div>

        <!-- Product Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="productsGrid">
            
            <!-- Item 1 -->
            <div class="product-card tile-hover-card bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm" data-category="floor">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1615873968403-89e068629265?auto=format&fit=crop&w=700&q=80" alt="Glossy Marble Tiles" class="w-full h-full object-cover transition duration-500 hover:scale-110">
                    <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-medium">Floor Tiles</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-slate-900 mb-2">High-Gloss Marble Vitrified</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Stain-resistant, mirror-finish 4x2ft tiles perfect for living rooms and halls.</p>
                    <a href="{{ route('shops') }}" class="inline-flex items-center text-cyan-600 font-bold text-sm hover:gap-2 transition-all">Check Showroom Availability &rarr;</a>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="product-card tile-hover-card bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm" data-category="wall">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=700&q=80" alt="Kitchen Wall Tiles" class="w-full h-full object-cover transition duration-500 hover:scale-110">
                    <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-medium">Wall Tiles</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-slate-900 mb-2">Designer Kitchen & Bathroom Walls</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Waterproof ceramic wall tiles featuring modern geometric patterns and textures.</p>
                    <a href="{{ route('shops') }}" class="inline-flex items-center text-cyan-600 font-bold text-sm hover:gap-2 transition-all">Check Showroom Availability &rarr;</a>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="product-card tile-hover-card bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm" data-category="sanitary">
                <div class="h-64 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=700&q=80" alt="Luxury Bathroom Sanitaryware" class="w-full h-full object-cover transition duration-500 hover:scale-110">
                    <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-medium">Sanitaryware</span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-slate-900 mb-2">Luxury Sanitary & Bath Fittings</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Matt-finish water closets, vanity basins, and premium chrome bath accessories.</p>
                    <a href="{{ route('shops') }}" class="inline-flex items-center text-cyan-600 font-bold text-sm hover:gap-2 transition-all">Check Showroom Availability &rarr;</a>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- 3. LOCATIONS QUICK-SELECTOR (ALL 5 BRANCHES DISPLAYED) -->
<section class="py-20 bg-white">
    <div class="container-fluid max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
            <div>
                <span class="text-cyan-600 font-bold uppercase text-xs tracking-widest">Our Outlets</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Visit Our 5 Regional Showrooms</h2>
            </div>
            <a href="{{ route('shops') }}" class="mt-4 md:mt-0 text-cyan-600 font-bold hover:underline">View All Locations &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Trichy -->
            <div class="p-6 rounded-2xl border-2 border-cyan-500/30 bg-cyan-50/30 hover:bg-white hover:border-cyan-500 shadow-sm transition">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-cyan-600 text-white text-xs px-3 py-1 rounded-full font-bold">Main Showroom</span>
                    <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-1">Trichy Branch</h3>
                <p class="text-slate-600 text-sm mb-4">Thillai Nagar Main Road, Tiruchirappalli</p>
                <a href="{{ route('shops.detail', ['location' => 'trichy']) }}" class="text-slate-900 font-bold text-sm hover:text-cyan-600 transition">View Showroom Details &rarr;</a>
            </div>

            <!-- Karaikal -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-cyan-500 shadow-sm transition">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-slate-200 text-slate-700 text-xs px-3 py-1 rounded-full font-bold">Coastal Showroom</span>
                    <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-1">Karaikal Branch</h3>
                <p class="text-slate-600 text-sm mb-4">Church Street, Karaikal, Puducherry</p>
                <a href="{{ route('shops.detail', ['location' => 'karaikal']) }}" class="text-slate-900 font-bold text-sm hover:text-cyan-600 transition">View Showroom Details &rarr;</a>
            </div>

            <!-- Karur -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-cyan-500 shadow-sm transition">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-slate-200 text-slate-700 text-xs px-3 py-1 rounded-full font-bold">Branch</span>
                    <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-1">Karur Branch</h3>
                <p class="text-slate-600 text-sm mb-4">Covai Road, Karur</p>
                <a href="{{ route('shops.detail', ['location' => 'karur']) }}" class="text-slate-900 font-bold text-sm hover:text-cyan-600 transition">View Showroom Details &rarr;</a>
            </div>

            <!-- Ramanathapuram -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-cyan-500 shadow-sm transition">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-slate-200 text-slate-700 text-xs px-3 py-1 rounded-full font-bold">Branch</span>
                    <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-1">Ramanathapuram Branch</h3>
                <p class="text-slate-600 text-sm mb-4">Madurai Road, Ramanathapuram</p>
                <a href="{{ route('shops.detail', ['location' => 'ramanathapuram']) }}" class="text-slate-900 font-bold text-sm hover:text-cyan-600 transition">View Showroom Details &rarr;</a>
            </div>

            <!-- Madurai -->
            <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-cyan-500 shadow-sm transition">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-slate-200 text-slate-700 text-xs px-3 py-1 rounded-full font-bold">Branch</span>
                    <span class="text-emerald-600 text-xs font-semibold">● Open Now</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-1">Madurai Branch</h3>
                <p class="text-slate-600 text-sm mb-4">KK Nagar, Madurai</p>
                <a href="{{ route('shops.detail', ['location' => 'madurai']) }}" class="text-slate-900 font-bold text-sm hover:text-cyan-600 transition">View Showroom Details &rarr;</a>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Simple jQuery Category Filter Animation
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