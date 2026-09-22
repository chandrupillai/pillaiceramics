@extends('layouts.app')

@section('title', 'Our Shop Locations | Trichy, Karaikal & More')
@section('meta_description', 'Find details, operating hours, and locations for our 5 shop branches in Trichy, Karaikal, Thanjavur, Madurai, and Coimbatore.')



@section('content')
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Our 5 Shop Branches</h1>
            <p class="text-slate-600">Select a branch to get contact information and operating hours.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Trichy Branch -->
            <div class="border border-slate-200 rounded-xl p-6 bg-slate-50 hover:border-indigo-500 transition">
                <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded mb-3">Major Hub</span>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Trichy Branch</h2>
                <p class="text-slate-600 text-sm mb-4">Main Road, Thillai Nagar, Tiruchirappalli, Tamil Nadu</p>
                <div class="text-xs text-slate-500 space-y-1 border-t border-slate-200 pt-3">
                    <p><strong>Manager:</strong> Trichy Branch Admin</p>
                    <p><strong>Hours:</strong> 9:00 AM - 9:00 PM</p>
                </div>
            </div>

            <!-- Karaikal Branch -->
            <div class="border border-slate-200 rounded-xl p-6 bg-slate-50 hover:border-indigo-500 transition">
                <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded mb-3">Coastal Hub</span>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Karaikal Branch</h2>
                <p class="text-slate-600 text-sm mb-4">Church Street, Karaikal, Puducherry</p>
                <div class="text-xs text-slate-500 space-y-1 border-t border-slate-200 pt-3">
                    <p><strong>Manager:</strong> Karaikal Branch Admin</p>
                    <p><strong>Hours:</strong> 9:30 AM - 8:30 PM</p>
                </div>
            </div>

            <!-- Thanjavur Branch -->
            <div class="border border-slate-200 rounded-xl p-6 bg-slate-50 hover:border-indigo-500 transition">
                <span class="inline-block bg-slate-200 text-slate-700 text-xs font-semibold px-2.5 py-1 rounded mb-3">Branch Shop</span>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Thanjavur Branch</h2>
                <p class="text-slate-600 text-sm mb-4">South Rampart, Thanjavur, Tamil Nadu</p>
                <div class="text-xs text-slate-500 space-y-1 border-t border-slate-200 pt-3">
                    <p><strong>Hours:</strong> 9:00 AM - 8:30 PM</p>
                </div>
            </div>

            <!-- Madurai Branch -->
            <div class="border border-slate-200 rounded-xl p-6 bg-slate-50 hover:border-indigo-500 transition">
                <span class="inline-block bg-slate-200 text-slate-700 text-xs font-semibold px-2.5 py-1 rounded mb-3">Branch Shop</span>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Madurai Branch</h2>
                <p class="text-slate-600 text-sm mb-4">KK Nagar Main Road, Madurai, Tamil Nadu</p>
                <div class="text-xs text-slate-500 space-y-1 border-t border-slate-200 pt-3">
                    <p><strong>Hours:</strong> 9:00 AM - 9:00 PM</p>
                </div>
            </div>

            <!-- Coimbatore Branch -->
            <div class="border border-slate-200 rounded-xl p-6 bg-slate-50 hover:border-indigo-500 transition">
                <span class="inline-block bg-slate-200 text-slate-700 text-xs font-semibold px-2.5 py-1 rounded mb-3">Branch Shop</span>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Coimbatore Branch</h2>
                <p class="text-slate-600 text-sm mb-4">Cross Cut Road, Gandhipuram, Coimbatore, Tamil Nadu</p>
                <div class="text-xs text-slate-500 space-y-1 border-t border-slate-200 pt-3">
                    <p><strong>Hours:</strong> 9:30 AM - 9:00 PM</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection