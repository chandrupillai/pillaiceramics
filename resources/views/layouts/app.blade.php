<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- Dynamic SEO Meta Tags --}}
    <title>@yield('title', 'Best Tiles Showroom in Tamil Nadu | Pillai Ceramics - Premium Floor & Wall Tiles')</title>
    <meta name="description" content="@yield('meta_description', 'Looking for the best tiles showroom in Tamil Nadu? Pillai Ceramics offers luxury vitrified floor tiles, GVT slabs, wall tiles & sanitaryware across Trichy, Madurai, Karur, Karaikal, & Ramanathapuram.')">
    <meta name="keywords" content="@yield('meta_keywords', 'tiles showroom in tamil nadu, best tiles showroom tamil nadu, tiles showroom trichy, tiles showroom madurai, tiles showroom karur, tiles showroom ramanathapuram, tiles showroom karaikal, vitrified tiles dealers tn, wall tiles shop, sanitaryware showroom tamilnadu')">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    {{-- Geo Location & Region Tags for Tamil Nadu --}}
    <meta name="geo.region" content="IN-TN">
    <meta name="geo.placename" content="Tamil Nadu, India">
    <meta name="author" content="Pillai Ceramics">

    {{-- Favicon Setup --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

    {{-- Open Graph / Social Media Meta Tags --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_IN">
    <meta property="og:site_name" content="Pillai Ceramics">
    <meta property="og:title" content="@yield('title', 'Best Tiles Showroom in Tamil Nadu | Pillai Ceramics')">
    <meta property="og:description" content="@yield('meta_description', 'Leading tiles and sanitaryware showroom chain in Tamil Nadu. Explore vitrified floor tiles, GVT slabs, marble tiles, and luxury bathroom fittings.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">
    
    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Best Tiles Showroom in Tamil Nadu | Pillai Ceramics')">
    <meta name="twitter:description" content="@yield('meta_description', 'Premium tiles & sanitaryware showrooms across Tamil Nadu - Trichy, Madurai, Karur, Karaikal, & Ramanathapuram.')">
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
        "https://www.instagram.com/pillaiceramics"
      ],
      "department": [
        {
          "@type": "TileStore",
          "name": "Pillai Ceramics - Trichy Tiles Showroom",
          "telephone": "+91-9444365536",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Trichy",
            "addressRegion": "Tamil Nadu",
            "addressCountry": "IN"
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
            <a href="{{ route('home') }}" class="flex items-center group transition transform hover:scale-[1.02]" title="Pillai Ceramics - Best Tiles Showroom in Tamil Nadu">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Pillai Ceramics Logo - Tiles Showroom Tamil Nadu" 
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

            {{-- Right CTA Button --}}
            <div class="hidden sm:flex items-center space-x-4">
                <a href="{{ route('contact') }}" class="bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-md hover:shadow-sky-500/25 active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Enquire Now
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
            <a href="{{ route('contact') }}" class="block w-full text-center bg-sky-600 text-white font-semibold py-2.5 rounded-lg mt-3">Enquire Now</a>
        </div>
    </header>

    {{-- Main Content Container --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Pillai Ceramics - Premium Tiles Showroom Tamil Nadu" class="h-10 w-auto mb-4 brightness-200 contrast-200">
                <p class="text-xs text-slate-400 leading-relaxed">
                    Pillai Ceramics is Tamil Nadu's leading tiles showroom network. We offer vitrified floor tiles, GVT marble slabs, wall ceramics, and luxury sanitaryware with delivery support across all districts in Tamil Nadu & Puducherry.
                </p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-sky-400 transition">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-sky-400 transition">About Us</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-sky-400 transition">Tile Collections</a></li>
                    <li><a href="{{ route('shops') }}" class="hover:text-sky-400 transition">Showrooms Network</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-sky-400 transition">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Flagship Showrooms</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Tiles Showroom in Trichy</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Tiles Showroom in Madurai</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Tiles Showroom in Karur</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Tiles Showroom in Ramanathapuram</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Tiles Showroom in Karaikal</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Get In Touch</h4>
                <p class="text-sm text-slate-400">Email: info@pillaiceramics.in</p>
                <p class="text-sm text-slate-400 mt-2">Sales Helpline: +91 9444365536</p>
                <p class="text-xs text-slate-500 mt-3">Serving: Trichy, Madurai, Karur, Ramanathapuram, Karaikal, Thanjavur, Dindigul, Pudukkottai, Tirunelveli & across Tamil Nadu.</p>
            </div>
        </div>

        {{-- SEO Regional Internal Link Silo --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 pt-6 border-t border-slate-800 text-xs text-slate-500">
            <p class="font-semibold text-slate-400 mb-2">Popular Searches in Tamil Nadu:</p>
            <p class="leading-relaxed">
                Tiles Showroom near me &bull; Vitrified Tiles Dealers in Tamil Nadu &bull; Floor Tiles Shop Trichy &bull; Wall Tiles Showroom Madurai &bull; Kitchen Tiles Karur &bull; Bathroom Sanitaryware Ramanathapuram &bull; GVT Marble Slabs Karaikal &bull; Premium Tiles Dealer TN
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
            <p>&copy; {{ date('Y') }} Pillai Ceramics. Premium Tiles & Sanitaryware Showrooms Tamil Nadu. All rights reserved.</p>
            <p>Trichy &bull; Karaikal &bull; Karur &bull; Ramanathapuram &bull; Madurai</p>
        </div>
    </footer>

    {{-- Mobile Menu Toggle --}}
    <script>
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            var menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
    </script>
    
    @stack('scripts')
</body>
</html>