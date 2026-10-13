@extends('layouts.app')

@section('title', 'Terms & Conditions | Pillai Ceramics')
@section('meta_description', 'Terms and Conditions for Pillai Ceramics. Review our business policies, order terms, warranties, and showroom service guidelines.')

@section('content')

<!-- HEADER HERO SECTION -->
<section class="bg-slate-950 text-white py-16 lg:py-20 border-b border-slate-800 relative overflow-hidden text-center">
    <div class="absolute -top-32 -left-32 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col items-center justify-center">
        <span class="inline-block bg-cyan-950 border border-cyan-500/30 text-cyan-400 px-4 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-4">
            Legal & Policy
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white text-center">Terms & Conditions</h1>
        <p class="text-slate-400 text-sm sm:text-base mt-3 max-w-2xl mx-auto text-center">
            Last updated: October 13, 2026. Please read these terms carefully before placing orders or using our services.
        </p>
    </div>
</section>

<!-- TERMS CONTENT SECTION -->
<section class="py-16 bg-slate-50 text-slate-800 min-h-screen">
    <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 flex flex-col items-center">
        
        <!-- Main Centered Content Card -->
        <div class="w-full bg-white rounded-3xl p-6 sm:p-12 border border-slate-200/80 shadow-sm space-y-10 leading-relaxed text-sm sm:text-base text-slate-600 mx-auto">

            <!-- 1. Introduction -->
            <div class="space-y-3">
                <h2 class="text-2xl font-bold text-slate-900">1. Acceptance of Terms</h2>
                <p>
                    Welcome to <strong>Pillai Ceramics</strong> ("we," "our," or "us"), founded by CEO Anandharaj in June 2016 and headquartered in Trichy, Tamil Nadu. By accessing our website, purchasing products (including HPT Ceramics vitrified tiles, Ramco building materials, and designer sanitaryware), or engaging with our 5 regional showrooms (Trichy, Karur, Karaikal, Ramanathapuram, and Madurai), you agree to be bound by these Terms & Conditions.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 2. Quotations & Product Orders -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">2. Quotations, Pricing & Orders</h2>
                <ul class="list-disc pl-6 space-y-2 text-slate-700">
                    <li><strong>Quotation Validity:</strong> All cost estimates, proforma invoices, or price quotations issued via PDF or WhatsApp are valid for the timeframe specified on the quotation (standard valid period is 7 to 14 days due to market raw material fluctuations).</li>
                    <li><strong>Shade & Batch Variations:</strong> Ceramic and vitrified tiles are natural clay-fired products. Slight variations in color shade, size tolerances, or grain texture between showroom samples and delivered batch lots are inherent to ceramic manufacturing and are not considered defects.</li>
                    <li><strong>Ramco Product Specs:</strong> Cement and construction chemical supplies follow official manufacturer specifications provided by Ramco Cements Ltd.</li>
                </ul>
            </div>

            <hr class="border-slate-100">

            <!-- 3. Delivery & Transportation -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">3. Delivery & Freight Terms</h2>
                <p>Delivery services are managed from our regional branch godowns to your site location:</p>
                <ul class="list-disc pl-6 space-y-2 text-slate-700">
                    <li>Site access roads must allow entry for heavy commercial goods vehicles. Unloading charges are extra unless explicitly stated in your invoice quotation.</li>
                    <li>Customers or site representatives must inspect materials upon arrival. Any transit breakage or quantity discrepancy must be noted on the lorry copy receipt and reported within 24 hours of delivery.</li>
                </ul>
            </div>

            <hr class="border-slate-100">

            <!-- 4. Inspection & Installation Policy -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">4. Tile Laying & Installation Notice</h2>
                <p class="font-semibold text-slate-800">
                    CRITICAL: Please inspect all tile boxes for batch number, shade, and caliber consistency PRIOR to installation.
                </p>
                <p>
                    No claims or returns regarding shade variations, size differences, or physical defects will be entertained once tiles have been laid or fixed with mortar/adhesive.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 5. Returns & Cancellations -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">5. Returns, Refunds & Cancellations</h2>
                <ul class="list-disc pl-6 space-y-2 text-slate-700">
                    <li><strong>Unopened Boxes:</strong> Returns for standard stock tiles in complete, undamaged, unopened original boxes may be accepted within 7 days of purchase, subject to store manager approval and restocking fees.</li>
                    <li><strong>Non-Returnable Items:</strong> Custom-cut slabs, special indent non-stock orders, and opened cement/chemical bags are strictly non-returnable.</li>
                </ul>
            </div>

            <hr class="border-slate-100">

            <!-- 6. Governing Law -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">6. Governing Law & Jurisdiction</h2>
                <p>
                    These terms and any commercial transactions conducted with Pillai Ceramics shall be governed by and construed in accordance with the laws of India. Any legal disputes or claims arising hereunder shall be subject to the exclusive jurisdiction of the courts in <strong>Tiruchirappalli (Trichy), Tamil Nadu</strong>.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 7. Corporate Contact Card -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">7. Contact Information</h2>
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80 space-y-2 text-center sm:text-left">
                    <h3 class="font-bold text-slate-900 text-lg">Pillai Ceramics - Corporate Office</h3>
                    <p class="text-xs sm:text-sm text-slate-600"><strong>HQ Address:</strong> 111, Pitchi nagar, Varageri, Trichy - 620008, Tamil Nadu</p>
                    <p class="text-xs sm:text-sm text-slate-600"><strong>Leadership:</strong> Anandharaj (Founder & CEO)</p>
                </div>
            </div>

        </div>

        <!-- Centered Back Button -->
        <div class="text-center mt-10 w-full flex justify-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-cyan-600 font-bold hover:underline text-sm text-center">
                &larr; Back to Home
            </a>
        </div>

    </div>
</section>

@endsection