@extends('layouts.app')

@section('title', 'Privacy Policy | Pillai Ceramics')
@section('meta_description', 'Privacy Policy for Pillai Ceramics. Learn how we handle, protect, and use your personal information across our showrooms and online services.')

@section('content')

<!-- HEADER HERO SECTION -->
<section class="bg-slate-950 text-white py-16 lg:py-20 border-b border-slate-800 relative overflow-hidden">
    <div class="absolute -top-32 -left-32 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="container-fluid max-w-5xl px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-block bg-cyan-950 border border-cyan-500/30 text-cyan-400 px-4 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-4">
            Legal & Compliance
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white">Privacy Policy</h1>
        <p class="text-slate-400 text-sm sm:text-base mt-3 max-w-2xl mx-auto">
            Last updated: October 13, 2026. This policy outlines how Pillai Ceramics collects, uses, and safeguards your personal data.
        </p>
    </div>
</section>

<!-- POLICY CONTENT SECTION -->
<section class="py-16 bg-slate-50 text-slate-800">
    <div class="container-fluid max-w-5xl px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-sm space-y-10 leading-relaxed text-sm sm:text-base text-slate-600">

            <!-- Intro -->
            <div class="space-y-3">
                <h2 class="text-2xl font-bold text-slate-900">1. Overview</h2>
                <p>
                    At <strong>Pillai Ceramics</strong> ("we," "our," or "us"), founded by CEO Anandharaj and headquartered in Trichy, Tamil Nadu, we value your trust and are committed to protecting your personal privacy. This Privacy Policy applies to our website, digital customer services, quotation systems, WhatsApp messaging integrations, and physical showroom interactions across our 5 regional outlets (Trichy, Karur, Karaikal, Ramanathapuram, and Madurai).
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- Data Collection -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">2. Information We Collect</h2>
                <p>We may collect personal information directly from you when you request estimates, purchase materials, or interact with our sales representatives:</p>
                <ul class="list-disc pl-6 space-y-2 text-slate-700">
                    <li><strong>Contact Information:</strong> Name, phone number, email address, and billing/shipping address.</li>
                    <li><strong>Transaction Details:</strong> Orders placed for HPT Ceramics tiles, Ramco products, or sanitaryware, along with custom quotation histories and payment confirmation details.</li>
                    <li><strong>Communication Logs:</strong> Customer support messages, WhatsApp communication logs, and form submissions.</li>
                    <li><strong>Technical Data:</strong> IP address, browser type, device details, and navigation analytics collected via cookies when visiting our web portal.</li>
                </ul>
            </div>

            <hr class="border-slate-100">

            <!-- How We Use Data -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">3. How We Use Your Information</h2>
                <p>Your data is strictly utilized to process orders, improve showroom operations, and deliver prompt services, including:</p>
                <ul class="list-disc pl-6 space-y-2 text-slate-700">
                    <li>Processing, exporting, and delivering customer estimates, invoices, and product orders.</li>
                    <li>Sending automated quotation PDFs and status updates via WhatsApp or SMS.</li>
                    <li>Managing regional inventory across our branch showrooms and godowns.</li>
                    <li>Responding to customer inquiries, product requests, or dealership questions.</li>
                    <li>Ensuring compliance with local commercial regulations and financial tax reporting in India.</li>
                </ul>
            </div>

            <hr class="border-slate-100">

            <!-- Data Sharing & Protection -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">4. Information Sharing & Security</h2>
                <p>
                    We <strong>do not sell, trade, or rent</strong> your personal data to third parties. We only share necessary operational details with:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-slate-700">
                    <li><strong>Logistics Partners:</strong> Freight and transport operators required to deliver ceramic tiles, slab marbles, and Ramco products to your project site.</li>
                    <li><strong>Official Dealers & Brands:</strong> Direct manufacturer processing when required for material warranties or special orders.</li>
                    <li><strong>Legal Authorities:</strong> When required by applicable statutory laws or legal processes in India.</li>
                </ul>
                <p class="pt-2">
                    We employ industry-standard physical, administrative, and digital safeguards to prevent unauthorized access, loss, or alteration of your information.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- Cookies & Analytics -->
            <div class="space-y-3">
                <h2 class="text-2xl font-bold text-slate-900">5. Cookies & Tracking Technologies</h2>
                <p>
                    Our website uses basic cookies to optimize page navigation, improve layout performance, and remember user preferences. You can choose to disable cookies through your web browser settings; however, certain interactive website features may function with limited capabilities.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- Rights & Contact -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">6. Your Rights & Contact Us</h2>
                <p>
                    You have the right to request access to your personal information, request corrections to inaccurate details, or ask for the removal of your contact data from our marketing communications.
                </p>
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80 space-y-2 mt-4">
                    <h3 class="font-bold text-slate-900 text-lg">Contact Corporate Headquarters</h3>
                    <p class="text-xs sm:text-sm text-slate-600"><strong>Pillai Ceramics - Headquarters</strong></p>
                    <p class="text-xs sm:text-sm text-slate-600">111, Pitchi nagar, Varageri, Trichy - 620008, Tamil Nadu</p>
                    <p class="text-xs sm:text-sm text-slate-600"><strong>Executive Office:</strong> Anandharaj (CEO)</p>
                </div>
            </div>

        </div>

        <div class="text-center mt-10">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-cyan-600 font-bold hover:underline text-sm">
                &larr; Back to Home
            </a>
        </div>

    </div>
</section>

@endsection