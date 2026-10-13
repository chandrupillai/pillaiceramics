<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $staff->staff_name }} - Pillai Ceramics Digital Card</title>
    
    {{-- Tailwind CSS & FontAwesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #090d16;
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    @php 
        $cardUrl ='';
        $companyAddress = $staff->staff_address ?? '111, Pitchi nagar, Varageri, Trichy - 620008, Tamil Nadu';
    @endphp

    <div class="w-full max-w-md bg-[#0f172a] text-white rounded-3xl shadow-2xl overflow-hidden border border-slate-800">
        
        <!-- Header Profile Section -->
        <div class="text-center px-6 pt-10 pb-6 bg-gradient-to-b from-[#1e293b] to-[#0f172a]">
            <img src="{{ $staff->staff_image ? asset('uploads/Staff/' . $staff->staff_image) : asset('images/default-profile.png') }}" 
                 class="w-28 h-28 rounded-full border-4 border-sky-500/30 object-cover mx-auto mb-4 shadow-md" 
                 alt="{{ $staff->staff_name }}">
            
            <h1 class="text-2xl font-bold text-white">{{ $staff->staff_name }}</h1>
            <p class="text-sky-400 font-semibold text-sm mt-1">{{ $staff->staff_designation ?? 'Sales & Showroom Executive' }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Pillai Ceramics - {{ ucfirst($staff->branch ?? 'Trichy HQ') }}</p>

            <!-- Quick Action Buttons -->
            <div class="flex justify-center gap-3 mt-6">
                <a href="tel:{{ $staff->staff_contactno }}" class="w-11 h-11 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white hover:bg-sky-600 transition shadow">
                    <i class="fa-solid fa-phone"></i>
                </a>
                <a href="https://wa.me/{{ $staff->staff_contactno }}" target="_blank" class="w-11 h-11 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white hover:bg-emerald-600 transition shadow">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                </a>
                <a href="mailto:{{ $staff->staff_emailid }}" class="w-11 h-11 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white hover:bg-sky-600 transition shadow">
                    <i class="fa-solid fa-envelope"></i>
                </a>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="p-6 border-t border-slate-800">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-sky-400 mb-3">Contact Information</h2>
            <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800/80 text-sm space-y-2">
                <p><strong>Mobile:</strong> <span class="text-slate-300">{{ $staff->staff_contactno }}</span></p>
                <p><strong>Email:</strong> <span class="text-slate-300">{{ $staff->staff_emailid }}</span></p>
                <p><strong>Address:</strong> <span class="text-slate-300">{{ $companyAddress }}</span></p>
            </div>
        </div>

        <!-- Specialization / Dealership -->
        <div class="px-6 pb-6">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-sky-400 mb-3">Specialization</h2>
            <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800/80 text-xs space-y-1.5 text-slate-300">
                <p><strong>Showroom Network:</strong> HPT Ceramics & Sanitaryware</p>
                <p><strong>Authorized Dealer:</strong> Ramco Cements & Hard Worker Products</p>
            </div>
        </div>

        <!-- Company & Branch Location Map -->
        <div class="px-6 pb-6 border-t border-slate-800 pt-6">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-sky-400 mb-3">Our Showroom Location</h2>
            <div class="rounded-xl overflow-hidden border border-slate-800">
                <iframe
                    width="100%"
                    height="200"
                    style="border:0; display:block;"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q={{ urlencode($companyAddress) }}&output=embed">
                </iframe>
                <div class="p-3 bg-slate-900 text-center">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($companyAddress) }}"
                        target="_blank"
                        class="inline-block w-full text-xs font-bold text-sky-400 hover:underline">
                        <i class="fa-solid fa-location-dot me-1"></i> Open in Google Maps
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Branding -->
        <div class="py-4 bg-slate-950 text-center text-[10px] text-slate-500 border-t border-slate-900">
            &copy; {{ date('Y') }} Pillai Ceramics. All rights reserved.
        </div>

    </div>

</body>
</html>