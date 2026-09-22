<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- Dynamic SEO Meta Tags --}}
    <title>@yield('title', 'Pillai Ceramics | Premium Tiles & Sanitaryware Showrooms in Trichy, Karaikal, Karur, Ramanathapuram & Madurai')</title>
    <meta name="description" content="@yield('meta_description', 'Pillai Ceramics offers luxury vitrified floor tiles, wall tiles, GVT slabs, and designer sanitaryware across 5 showrooms in Trichy, Karaikal, Karur, Ramanathapuram, and Madurai.')">
    <meta name="keywords" content="@yield('meta_keywords', 'pillai ceramics, tiles trichy, tiles karaikal, tiles karur, tiles ramanathapuram, tiles madurai, sanitaryware showroom, vitrified floor tiles')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    {{-- Favicon Setup --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

    {{-- Open Graph / Social Media Meta Tags --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Pillai Ceramics | Luxury Tiles & Sanitaryware Showrooms')">
    <meta property="og:description" content="@yield('meta_description', 'Explore floor tiles, wall tiles, and premium sanitaryware across our showrooms in Trichy, Karaikal, Karur, Ramanathapuram, and Madurai.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('meta_description')">
    
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
    
    @stack('styles')
    @stack('schema')
</head>
<body class="bg-slate-50 text-slate-800 font-sans flex flex-col min-h-screen antialiased">

    {{-- Header / Navbar --}}
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 shadow-sm transition-all">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" class="flex items-center group transition transform hover:scale-[1.02]">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Pillai Ceramics Logo" 
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
                   Collections
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
            <button id="mobileMenuBtn" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:text-sky-600 hover:bg-slate-100 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </nav>

        {{-- Mobile Drawer Menu --}}
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2 shadow-xl">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Home</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">About Us</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-600">Collections</a>
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
                <img src="{{ asset('images/logo.png') }}" alt="Pillai Ceramics" class="h-10 w-auto mb-4 brightness-200 contrast-200">
                <p class="text-xs text-slate-400 leading-relaxed">
                    Premium vitrified tiles, marble finish slabs, non-slip ceramics, and luxury sanitaryware across 5 regional showrooms in Tamil Nadu & Puducherry.
                </p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-sky-400 transition">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-sky-400 transition">About Us</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-sky-400 transition">Collections</a></li>
                    <li><a href="{{ route('shops') }}" class="hover:text-sky-400 transition">Showrooms</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-sky-400 transition">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Our Showrooms</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Trichy Branch</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Karaikal Branch</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Karur Branch</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Ramanathapuram Branch</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>Madurai Branch</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Get In Touch</h4>
                <p class="text-sm text-slate-400">Email: info@pillaiceramics.in</p>
                <p class="text-sm text-slate-400 mt-2">Phone: +91 9444365536</p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
            <p>&copy; {{ date('Y') }} Pillai Ceramics. All rights reserved.</p>
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