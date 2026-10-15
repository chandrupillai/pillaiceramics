<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Dynamic SEO Meta Tags --}}
    <title>@yield('title', 'Wholesale Tiles, Branded Tiles Showroom & Ramco Dealer in Trichy | Pillai Ceramics')</title>
    <meta name="description" content="@yield('meta_description', 'Looking for the best tiles showroom and authorized Ramco dealer in Trichy? Pillai Ceramics offers wholesale vitrified floor tiles, GVT slabs, wall tiles & Ramco products in Varageri, Trichy.')">
    <meta name="keywords" content="@yield('meta_keywords', 'wholesale tiles trichy, tiles showroom in trichy, branded tiles showroom in trichy, ramco dealer trichy, floor tiles wholesale trichy, vitrified tiles trichy, wall tiles shop trichy')">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    {{-- Geo Location & Region Tags for Trichy & Tamil Nadu --}}
    <meta name="geo.region" content="IN-TN">
    <meta name="geo.placename" content="Trichy, Tamil Nadu, India">
    <meta name="geo.position" content="10.8282;78.7054">
    <meta name="ICBM" content="10.8282, 78.7054">
    <meta name="author" content="Pillai Ceramics">

    {{-- Favicon Setup --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

    {{-- Open Graph / Social Media Meta Tags --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_IN">
    <meta property="og:site_name" content="Pillai Ceramics">
    <meta property="og:title" content="@yield('title', 'Wholesale Tiles, Branded Tiles Showroom & Ramco Dealer in Trichy | Pillai Ceramics')">
    <meta property="og:description" content="@yield('meta_description', 'Looking for the best tiles showroom and authorized Ramco dealer in Trichy? Pillai Ceramics offers wholesale vitrified floor tiles, GVT slabs, wall tiles & Ramco products.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Wholesale Tiles, Branded Tiles Showroom & Ramco Dealer in Trichy | Pillai Ceramics')">
    <meta name="twitter:description" content="@yield('meta_description', 'Looking for the best tiles showroom and authorized Ramco dealer in Trichy? Pillai Ceramics offers wholesale vitrified floor tiles, GVT slabs, wall tiles & Ramco products.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo.png'))">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#009edb',
                            600: '#0081b8',
                            700: '#006593',
                        }
                    }
                }
            }
        }
    </script>

    {{-- JSON-LD Structured Data Schema for Local Business Chain across Tamil Nadu --}}
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "Organization",
            "name": "Pillai Ceramics",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('images/logo.png') }}",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+91-9444365536",
                "contactType": "sales",
                "areaServed": "IN-TN",
                "availableLanguage": ["English", "Tamil"]
            },
            "sameAs": [
                "https://www.facebook.com/pillaiceramics",
                "https://www.instagram.com/pillaiceramics/"
            ],
            "department": [
                {
                    "@type": "TileStore",
                    "name": "Pillai Ceramics - Wholesale Tiles Showroom & Ramco Dealer in Trichy",
                    "image": "{{ asset('images/logo.png') }}",
                    "telephone": "+91-9444365536",
                    "priceRange": "₹₹",
                    "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "111, Pitchi nagar, Varageri",
                        "addressLocality": "Trichy",
                        "addressRegion": "Tamil Nadu",
                        "postalCode": "620008",
                        "addressCountry": "IN"
                    },
                    "geo": {
                        "@type": "GeoCoordinates",
                        "latitude": "10.8282",
                        "longitude": "78.7054"
                    },
                    "openingHoursSpecification": {
                        "@type": "OpeningHoursSpecification",
                        "dayOfWeek": [
                            "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
                        ],
                        "opens": "09:00",
                        "closes": "20:00"
                    },
                    "areaServed": {
                        "@type": "City",
                        "name": "Trichy"
                    }
                },
                {
                    "@type": "TileStore",
                    "name": "Pillai Ceramics - Madurai Tiles Showroom",
                    "telephone": "+91-9444365536",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "Madurai",
                        "addressRegion": "Tamil Nadu",
                        "addressCountry": "IN"
                    }
                },
                {
                    "@type": "TileStore",
                    "name": "Pillai Ceramics - Karur Tiles Showroom",
                    "telephone": "+91-9444365536",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "Karur",
                        "addressRegion": "Tamil Nadu",
                        "addressCountry": "IN"
                    }
                },
                {
                    "@type": "TileStore",
                    "name": "Pillai Ceramics - Ramanathapuram Tiles Showroom",
                    "telephone": "+91-9444365536",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "Ramanathapuram",
                        "addressRegion": "Tamil Nadu",
                        "addressCountry": "IN"
                    }
                },
                {
                    "@type": "TileStore",
                    "name": "Pillai Ceramics - Karaikal Tiles Showroom",
                    "telephone": "+91-9444365536",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "Karaikal",
                        "addressRegion": "Puducherry",
                        "addressCountry": "IN"
                    }
                }
            ]
        }
    </script>

    @stack('styles')
    @stack('schema')
</head>

<body class="bg-slate-50 text-slate-800 font-sans flex flex-col min-h-screen antialiased">

    {{-- Header / Navbar --}}
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 shadow-sm transition-all">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" class="flex items-center group transition transform hover:scale-[1.02]" title="Pillai Ceramics - Wholesale Tiles Showroom & Ramco Dealer in Trichy">
                <img src="{{ asset('images/logo.png') }}"
                    alt="Pillai Ceramics Logo - Tiles Showroom in Trichy"
                    class="h-10 sm:h-12 w-auto object-contain"
                    style="max-height: 48px;">
            </a>

            {{-- Navigation Links --}}
            <div class="hidden md:flex items-center space-x-1 lg:space-x-2 font-medium text-slate-600 text-sm">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('home') ? 'bg-sky-50 text-sky-600 font-bold shadow-sm' : 'hover:text-sky-600 hover:bg-slate-100/60' }}">
                    Home
                </a>
                <a href="{{ route('about') }}"
                    class="px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('about') ? 'bg-sky-50 text-sky-600 font-bold shadow-sm' : 'hover:text-sky-600 hover:bg-slate-100/60' }}">
                    About Us
                </a>
                <a href="{{ route('services') }}"
                    class="px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('services') ? 'bg-sky-50 text-sky-600 font-bold shadow-sm' : 'hover:text-sky-600 hover:bg-slate-100/60' }}">
                    Tile Collections
                </a>
                <a href="{{ route('shops') }}"
                    class="px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('shops') ? 'bg-sky-50 text-sky-600 font-bold shadow-sm' : 'hover:text-sky-600 hover:bg-slate-100/60' }}">
                    Our Showrooms
                </a>
                <a href="{{ route('contact') }}"
                    class="px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-sky-50 text-sky-600 font-bold shadow-sm' : 'hover:text-sky-600 hover:bg-slate-100/60' }}">
                    Contact
                </a>
            </div>

            {{-- Right CTA Buttons (Enquire & Play Store App Download) --}}
            <div class="hidden sm:flex items-center space-x-3">
                <a href="{{ route('contact') }}" class="bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white px-4 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-md hover:shadow-sky-500/25 active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Enquire Now
                </a>

                {{-- Play Store Download Button --}}
                <a href="https://play.google.com/store/apps/details?id=com.pillaiceramics.app" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   title="Download Pillai Ceramics App on Google Play"
                   class="bg-slate-900 hover:bg-slate-800 text-white px-3.5 py-2 rounded-xl font-medium text-xs transition-all shadow-md hover:shadow-slate-900/20 active:scale-95 flex items-center gap-2 border border-slate-700">
                    <svg class="w-5 h-5 fill-current text-sky-400" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3.609 1.814L13.792 12 3.61 22.186a1.51 1.51 0 0 1-.61-1.21V3.024c0-.495.22-.962.609-1.21zm11.192 11.193l2.802 2.802-9.593 5.545 6.791-8.347zM17.6 15.007l3.39-1.958c.84-.485.84-1.609 0-2.094l-3.39-1.958-2.803 2.803 2.803 3.207zm-2.803-3.81l-9.593-5.545 6.791 8.347 2.802-2.802z"/>
                    </svg>
                    <div class="text-left leading-tight">
                        <span class="block text-[9px] text-slate-400 uppercase tracking-wider">Get it on</span>
                        <span class="block font-semibold text-xs">Google Play</span>
                    </div>
                </a>
            </div>

            {{-- Mobile Drawer Toggle Button --}}
            <button id="mobileMenuBtn" type="button" aria-label="Toggle Navigation Menu" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:text-sky-600 hover:bg-slate-100 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </nav>

        {{-- Mobile Drawer Menu --}}
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2 shadow-xl">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Home</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">About Us</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Tile Collections</a>
            <a href="{{ route('shops') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Our Showrooms</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Contact</a>
            
            <div class="pt-2 space-y-2">
                <a href="{{ route('contact') }}" class="block w-full text-center bg-sky-600 text-white font-semibold py-2.5 rounded-lg">Enquire Now</a>
                <a href="https://play.google.com/store/apps/details?id=com.pillaiceramics.app" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 w-full bg-slate-900 text-white font-semibold py-2.5 rounded-lg">
                    <svg class="w-5 h-5 fill-current text-sky-400" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3.609 1.814L13.792 12 3.61 22.186a1.51 1.51 0 0 1-.61-1.21V3.024c0-.495.22-.962.609-1.21zm11.192 11.193l2.802 2.802-9.593 5.545 6.791-8.347zM17.6 15.007l3.39-1.958c.84-.485.84-1.609 0-2.094l-3.39-1.958-2.803 2.803 2.803 3.207zm-2.803-3.81l-9.593-5.545 6.791 8.347 2.802-2.802z"/>
                    </svg>
                    Download App (Google Play)
                </a>
            </div>
        </div>
    </header>

    {{-- Main Content Container --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- App Download Promo Banner Section --}}
    <section class="bg-gradient-to-r from-sky-600 via-sky-700 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-t border-sky-500/20 shadow-inner">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="text-center lg:text-left space-y-2 max-w-2xl">
                <span class="inline-block bg-sky-500/30 text-sky-200 border border-sky-400/30 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Official Mobile App</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Explore & Buy Tiles on the Go with <span class="text-sky-300">Pillai Ceramics App</span></h3>
                <p class="text-slate-200 text-sm leading-relaxed">
                    Browse our massive wholesale tile catalogs, check live inventory, generate instant estimates, and connect directly with our Trichy showroom right from your mobile device.
                </p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="https://play.google.com/store/apps/details?id=com.pillaiceramics.app" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="bg-black hover:bg-slate-950 text-white border border-slate-700 hover:border-sky-400/50 px-6 py-3.5 rounded-2xl flex items-center gap-3 transition-all shadow-xl hover:shadow-sky-500/10 active:scale-95 group">
                    <svg class="w-8 h-8 fill-current text-sky-400 group-hover:scale-105 transition-transform" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3.609 1.814L13.792 12 3.61 22.186a1.51 1.51 0 0 1-.61-1.21V3.024c0-.495.22-.962.609-1.21zm11.192 11.193l2.802 2.802-9.593 5.545 6.791-8.347zM17.6 15.007l3.39-1.958c.84-.485.84-1.609 0-2.094l-3.39-1.958-2.803 2.803 2.803 3.207zm-2.803-3.81l-9.593-5.545 6.791 8.347 2.802-2.802z"/>
                    </svg>
                    <div class="text-left leading-tight">
                        <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-medium">Download on the</span>
                        <span class="block font-bold text-base tracking-wide">Google Play</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- Unified Professional Footer --}}
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            
            {{-- Column 1: Brand Info & Social Icons --}}
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Pillai Ceramics - Wholesale Tiles Showroom in Trichy" class="h-10 w-auto mb-4 brightness-200 contrast-200">
                <p class="text-xs text-slate-400 leading-relaxed">
                    Pillai Ceramics is Tamil Nadu's leading tiles showroom network and authorized Ramco dealer. We offer wholesale vitrified floor tiles, GVT marble slabs, wall ceramics, and Ramco products across Trichy, Madurai, Karur, Karaikal, and Ramanathapuram[cite: 1].
                </p>

                {{-- Social Media Links --}}
                <div class="mt-6">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Follow Us</span>
                    <div class="flex items-center gap-3">
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/pillaiceramics"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Visit Pillai Ceramics on Facebook"
                            title="Facebook"
                            class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-cyan-400 hover:border-cyan-500/50 hover:bg-slate-800 transition transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>

                        <!-- YouTube -->
                        <a href="https://www.youtube.com/@PillaiCeramics"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Visit YouTube"
                            title="YouTube"
                            class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-red-500 hover:border-red-500/50 hover:bg-slate-800 transition transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>

                        <!-- Instagram -->
                        <a href="https://www.instagram.com/pillaiceramics/"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Visit Pillai Ceramics on Instagram"
                            title="Instagram"
                            class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-pink-500 hover:border-pink-500/50 hover:bg-slate-800 transition transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Column 2: Quick Links --}}
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="{{ route('home') }}" class="hover:text-sky-400 transition">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-sky-400 transition">About Us</a></li>
                    <li><a href="{{ route('leadership') }}" class="hover:text-sky-400 transition">Leadership</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-sky-400 transition">Tile Collections</a></li>
                    <li><a href="{{ route('shops') }}" class="hover:text-sky-400 transition">Showrooms Network</a></li>
                    <li><a href="{{ route('privacy.policy') }}" class="hover:text-sky-400 transition">Privacy Policy</a></li>
                    <li><a href="{{ route('terms.conditions') }}" class="hover:text-sky-400 transition">Terms & Conditions</a></li>
                </ul>
            </div>

            {{-- Column 3: Regional Showrooms --}}
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Showrooms Network</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span><a href="{{ route('shops.detail', ['location' => 'trichy']) }}" class="hover:text-sky-400 transition">Trichy (HQ)</a></li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span><a href="{{ route('shops.detail', ['location' => 'karur']) }}" class="hover:text-sky-400 transition">Karur Branch</a></li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span><a href="{{ route('shops.detail', ['location' => 'karaikal']) }}" class="hover:text-sky-400 transition">Karaikal Branch</a></li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span><a href="{{ route('shops.detail', ['location' => 'ramanathapuram']) }}" class="hover:text-sky-400 transition">Ramanathapuram</a></li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span><a href="{{ route('shops.detail', ['location' => 'madurai']) }}" class="hover:text-sky-400 transition">Madurai Branch</a></li>
                </ul>
            </div>

            {{-- Column 4: Contact & Corporate Info --}}
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Corporate Info</h4>
                <p class="text-xs text-slate-400 leading-relaxed mb-2">
                    <strong class="text-slate-200">Headquarters (Trichy):</strong><br>
                    111, Pitchi nagar, Varageri, Trichy - 620008, Tamil Nadu
                </p>
                <p class="text-xs text-slate-400 mt-2">Sales Helpline: <strong class="text-slate-200">+91 9444365536</strong></p>
                <div class="pt-3 text-xs border-t border-slate-800 mt-3">
                    <span class="block text-slate-400">Founder & CEO: <strong class="text-slate-200">Anandharaj</strong></span>
                    <span class="block text-sky-400 font-semibold mt-1">Est. June 2016</span>
                </div>
            </div>

        </div>

        {{-- SEO Regional Keywords Footer Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 pt-6 border-t border-slate-800 text-xs text-slate-500">
            <p class="font-semibold text-slate-400 mb-2">Popular Searches in Trichy & Tamil Nadu:</p>
            <p class="leading-relaxed">
                Wholesale Tiles Trichy &bull; Tiles Showroom in Trichy &bull; Branded Tiles Showroom in Trichy &bull; Ramco Dealer Trichy &bull; Floor Tiles Wholesale Trichy &bull; Vitrified Tiles Dealers in Tamil Nadu &bull; Wall Tiles Showroom Madurai
            </p>
        </div>

        {{-- Copyright & Legal Links --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
            <p>&copy; {{ date('Y') }} Pillai Ceramics. Wholesale Tiles Showroom & Ramco Dealer in Trichy. All rights reserved.</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('privacy.policy') }}" class="hover:text-slate-300 transition">Privacy Policy</a>
                <span>&bull;</span>
                <a href="{{ route('terms.conditions') }}" class="hover:text-slate-300 transition">Terms & Conditions</a>
            </div>
        </div>

    </footer>

    {{-- Mobile Menu Toggle Script --}}
    <script>
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            var menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>

</html>