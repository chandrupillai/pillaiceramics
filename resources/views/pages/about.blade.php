@extends('layouts.app')

@section('title', 'About Us | Pillai Ceramics & HPT Ceramics')
@section('meta_description', 'Founded in Trichy (June 2016) by CEO Anandharaj, Pillai Ceramics is a trusted regional leader in luxury tiles, HPT Ceramics vitrified slabs, and designer sanitaryware across 5 showrooms.')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .brand-gradient {
        background: linear-gradient(135deg, #0081b8 0%, #009edb 50%, #00b4fc 100%);
    }
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -10px rgba(0, 129, 184, 0.15);
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
            Established June 2016 • Tiruchirappalli
        </span>
        <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-tight mb-6">
            Redefining Architectural Surfaces Since <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">2016</span>
        </h1>
        <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">
            From our founding showroom in Trichy to a multi-branch network across South India, Pillai Ceramics brings world-class tile craft and our flagship <strong class="text-cyan-300">HPT Ceramics</strong> brand to modern spaces.
        </p>
    </div>
</section>


<!-- 2. FOUNDER & COMPANY ORIGIN (EXECUTIVE SINGLE ROW SHOWCASE) -->
<section class="py-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-900 text-white rounded-3xl p-8 lg:p-12 border border-slate-800 shadow-xl relative overflow-hidden">
            <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-gradient-to-l from-cyan-500/10 to-transparent pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                
                <!-- Founder Spotlight -->
                <div class="lg:col-span-4 flex flex-col items-start border-b lg:border-b-0 lg:border-r border-slate-800 pb-6 lg:pb-0 lg:pr-8">
                    <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Visionary Founder</span>
                    <h2 class="text-3xl font-black text-white mt-1">Anandharaj</h2>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Founder & Chief Executive Officer</p>
                    
                    <div class="mt-5 inline-flex items-center gap-2 bg-slate-800/90 border border-slate-700 px-3.5 py-2 rounded-xl text-xs font-medium text-slate-300">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Trichy Origin • June 2016
                    </div>
                </div>

                <!-- Strategic Journey Text -->
                <div class="lg:col-span-8 space-y-4">
                    <span class="text-xs font-bold tracking-widest text-cyan-400 uppercase">Leadership Vision</span>
                    <h3 class="text-2xl font-bold text-white leading-snug">
                        Transforming South Indian Homes Through Direct Quality & Innovation
                    </h3>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        In **June 2016**, CEO **Anandharaj** founded **Pillai Ceramics** in Trichy with a clear objective: to bridge the gap between premium international surface design and accessibility for regional homeowners and builders. 
                    </p>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Under his leadership, the company introduced **HPT Ceramics**, our proprietary house brand designed to offer unmatched durability, scratch resistance, and micro-calibrated precision edges without middleman overheads.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>


<!-- 3. BRAND ADVANTAGE: HPT CERAMICS -->
<section class="py-20 bg-slate-50 border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-cyan-600 font-bold uppercase text-xs tracking-widest">Our Flagship Brand</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">The HPT Ceramics Standard</h2>
            <p class="text-slate-600 text-sm mt-3">Engineered for long-lasting performance, luxury aesthetic appeal, and extreme durability.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="p-8 rounded-2xl bg-white border border-slate-200/80 card-hover">
                <div class="w-12 h-12 rounded-xl bg-cyan-600/10 text-cyan-600 flex items-center justify-center font-bold text-xl mb-6">01</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">High Density Vitrification</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    HPT Ceramics slabs undergo ultra-high pressure compaction to achieve minimal water absorption, protecting floorings against deep moisture damage.
                </p>
            </div>

            <div class="p-8 rounded-2xl bg-white border border-slate-200/80 card-hover">
                <div class="w-12 h-12 rounded-xl bg-cyan-600/10 text-cyan-600 flex items-center justify-center font-bold text-xl mb-6">02</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Mirror & Satin Finishes</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Available in Italian-finish high gloss, slip-resistant matt, and tactile 3D elevation finishes designed for luxury interiors and outdoor facades.
                </p>
            </div>

            <div class="p-8 rounded-2xl bg-white border border-slate-200/80 card-hover">
                <div class="w-12 h-12 rounded-xl bg-cyan-600/10 text-cyan-600 flex items-center justify-center font-bold text-xl mb-6">03</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Rectified Edge Precision</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Laser-calibrated edges allow seamless installation with paper-thin grout lines for an expansive, continuous marble look across living areas.
                </p>
            </div>
        </div>
    </div>
</section>


<!-- 4. REGIONAL NETWORK: 5 SHOWROOM BRANCHES -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
            <div>
                <span class="text-cyan-600 font-bold uppercase text-xs tracking-widest">Widespread Reach</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">5 Showrooms Across Tamil Nadu & Puducherry</h2>
            </div>
            <a href="{{ route('shops') }}" class="mt-4 md:mt-0 text-cyan-600 font-bold text-sm hover:underline">Explore Branch Locations &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Trichy -->
            <div class="p-6 rounded-2xl border-2 border-cyan-500/30 bg-cyan-50/20 card-hover">
                <span class="bg-cyan-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Headquarters • Est. June 2016</span>
                <h3 class="text-2xl font-bold text-slate-900 mt-3 mb-1">Trichy Branch</h3>
                <p class="text-slate-600 text-sm mb-4">Thillai Nagar Main Road, Tiruchirappalli</p>
                <a href="{{ route('shops.detail', ['location' => 'trichy']) }}" class="text-cyan-600 font-bold text-xs uppercase tracking-wider hover:underline">Showroom Details &rarr;</a>
            </div>

            <!-- Karaikal -->
            <div class="p-6 rounded-2xl border border-slate-200/80 bg-slate-50 card-hover">
                <span class="bg-slate-200 text-slate-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Coastal Showroom</span>
                <h3 class="text-2xl font-bold text-slate-900 mt-3 mb-1">Karaikal Branch</h3>
                <p class="text-slate-600 text-sm mb-4">Church Street, Karaikal, Puducherry</p>
                <a href="{{ route('shops.detail', ['location' => 'karaikal']) }}" class="text-cyan-600 font-bold text-xs uppercase tracking-wider hover:underline">Showroom Details &rarr;</a>
            </div>

            <!-- Karur -->
            <div class="p-6 rounded-2xl border border-slate-200/80 bg-slate-50 card-hover">
                <span class="bg-slate-200 text-slate-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Regional Outlet</span>
                <h3 class="text-2xl font-bold text-slate-900 mt-3 mb-1">Karur Branch</h3>
                <p class="text-slate-600 text-sm mb-4">Covai Road, Karur</p>
                <a href="{{ route('shops.detail', ['location' => 'karur']) }}" class="text-cyan-600 font-bold text-xs uppercase tracking-wider hover:underline">Showroom Details &rarr;</a>
            </div>

            <!-- Ramanathapuram -->
            <div class="p-6 rounded-2xl border border-slate-200/80 bg-slate-50 card-hover">
                <span class="bg-slate-200 text-slate-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Regional Outlet</span>
                <h3 class="text-2xl font-bold text-slate-900 mt-3 mb-1">Ramanathapuram Branch</h3>
                <p class="text-slate-600 text-sm mb-4">Madurai Road, Ramanathapuram</p>
                <a href="{{ route('shops.detail', ['location' => 'ramanathapuram']) }}" class="text-cyan-600 font-bold text-xs uppercase tracking-wider hover:underline">Showroom Details &rarr;</a>
            </div>

            <!-- Madurai -->
            <div class="p-6 rounded-2xl border border-slate-200/80 bg-slate-50 card-hover">
                <span class="bg-slate-200 text-slate-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Regional Outlet</span>
                <h3 class="text-2xl font-bold text-slate-900 mt-3 mb-1">Madurai Branch</h3>
                <p class="text-slate-600 text-sm mb-4">KK Nagar, Madurai</p>
                <a href="{{ route('shops.detail', ['location' => 'madurai']) }}" class="text-cyan-600 font-bold text-xs uppercase tracking-wider hover:underline">Showroom Details &rarr;</a>
            </div>

        </div>
    </div>
</section>

<!-- 5. CALL TO ACTION -->
<section class="py-16 brand-gradient text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <h2 class="text-3xl sm:text-4xl font-extrabold">Ready to Upgrade Your Space?</h2>
        <p class="text-slate-100 max-w-2xl mx-auto text-base">
            Visit any of our 5 regional showrooms to explore our full tile catalog and consult with our surface design experts.
        </p>
        <div class="pt-2">
            <a href="{{ route('shops') }}" class="bg-slate-900 hover:bg-slate-950 text-white px-8 py-3.5 rounded-xl font-bold transition inline-block">
                Locate Nearest Showroom
            </a>
        </div>
    </div>
</section>

@endsection