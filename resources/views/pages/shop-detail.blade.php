@extends('layouts.app')

@section('title', $shop->meta_title ?? "Best Tiles Showroom in {$shop->city} | Pillai Ceramics")
@section('meta_description', $shop->meta_description ?? "Visit Pillai Ceramics tile showroom in {$shop->city}, Tamil Nadu. Explore vitrified floor tiles, GVT slabs, ceramic wall tiles, and designer sanitaryware.")
@section('meta_keywords', "tiles showroom {$shop->city}, tile shop in {$shop->city}, vitrified tiles {$shop->city}, sanitaryware dealer {$shop->city}, pillai ceramics {$shop->city}")

@push('schema')
{{-- Local Business Schema for Local SEO --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "TileStore",
  "name": "Pillai Ceramics - {{ $shop->name }}",
  "image": "{{ $shop->image ? asset('storage/' . $shop->image) : asset('images/logo.png') }}",
  "telephone": "{{ $shop->phone }}",
  "email": "{{ $shop->email ?? 'info@pillaiceramics.in' }}",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "{{ $shop->address }}",
    "addressLocality": "{{ $shop->city }}",
    "addressRegion": "Tamil Nadu",
    "postalCode": "{{ $shop->pincode }}",
    "addressCountry": "IN"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "{{ $shop->latitude ?? '10.7905' }}",
    "longitude": "{{ $shop->longitude ?? '78.7047' }}"
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    "opens": "09:00",
    "closes": "20:30"
  }
}
</script>
@endpush

@section('content')

{{-- Hero Section --}}
<section class="relative bg-slate-900 text-white py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-block bg-sky-500/20 text-sky-400 border border-sky-500/30 px-3 py-1 rounded-full text-xs font-semibold tracking-wider uppercase mb-4">
                Branch Showroom &bull; {{ $shop->city }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white mb-4">
                {{ $shop->name }}
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed">
                {{ $shop->short_description ?? 'Explore premium floor tiles, wall ceramics, marble finish GVT slabs, and luxury sanitaryware at our flagship showroom in ' . $shop->city . ', Tamil Nadu.' }}
            </p>
        </div>
    </div>
</section>

{{-- Main Details Grid --}}
<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            {{-- Left Content Area --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Showroom Image --}}
                @if($shop->image)
                    <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-100">
                        <img src="{{ asset('storage/' . $shop->image) }}" alt="Pillai Ceramics {{ $shop->name }}" class="w-full h-80 object-cover">
                    </div>
                @endif

                {{-- CMS Content --}}
                <div class="prose max-w-none text-slate-600 leading-relaxed">
                    <h2 class="text-2xl font-bold text-slate-900 mb-4">About Our {{ $shop->city }} Showroom</h2>
                    <div>
                        {!! $shop->description ?? '<p>Welcome to Pillai Ceramics in ' . $shop->city . '. We display over 500+ designs in vitrified tiles, ceramic tiles, high-gloss slabs, and modern bathroom fixtures.</p>' !!}
                    </div>
                </div>

                {{-- Key Features --}}
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/80">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Showroom Features & Services</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-sky-500"></span> 500+ Live Tile Mockups & Displays</div>
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-sky-500"></span> Expert Architectural Guidance</div>
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-sky-500"></span> Direct Tamil Nadu Delivery Support</div>
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-sky-500"></span> Luxury Sanitaryware Display Zone</div>
                    </div>
                </div>

            </div>

            {{-- Right Sidebar Info Box --}}
            <div class="space-y-6">
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80 shadow-sm sticky top-28">
                    <h3 class="text-xl font-bold text-slate-900 border-b border-slate-200 pb-3 mb-6">Showroom Information</h3>
                    
                    <div class="space-y-5 text-sm">
                        {{-- Address --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-sky-100 text-sky-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <span class="font-semibold text-slate-900 block">Address</span>
                                <p class="text-slate-600 mt-0.5 leading-relaxed">{{ $shop->address }}, {{ $shop->city }} - {{ $shop->pincode }}, Tamil Nadu</p>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-sky-100 text-sky-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <span class="font-semibold text-slate-900 block">Phone</span>
                                <a href="tel:{{ $shop->phone }}" class="text-sky-600 font-medium hover:underline">{{ $shop->phone }}</a>
                            </div>
                        </div>

                        {{-- Opening Hours --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-sky-100 text-sky-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <span class="font-semibold text-slate-900 block">Working Hours</span>
                                <p class="text-slate-600 mt-0.5">{{ $shop->timing ?? 'Mon - Sat: 9:00 AM - 8:30 PM' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 space-y-3">
                        @if($shop->google_maps_link)
                            <a href="{{ $shop->google_maps_link }}" target="_blank" class="w-full text-center bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-4 rounded-xl block transition shadow">
                                Get Directions (Google Maps)
                            </a>
                        @endif
                        <a href="{{ route('contact') }}" class="w-full text-center bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-4 rounded-xl block transition shadow-md shadow-sky-500/20">
                            Book Showroom Appointment
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection