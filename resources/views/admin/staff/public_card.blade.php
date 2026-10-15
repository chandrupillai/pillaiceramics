<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $staff->name }} - Pillai Ceramics Digital Card</title>
    
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
        $cardUrl = route('staff.digital-card', $staff->slug);
        $companyAddress = optional($staff->profile)->address ?? '111, Pitchi nagar, Varageri, Trichy - 620008, Tamil Nadu';
        $avatarStoragePath = optional($staff->profile)->avatar;

        // Custom professional experience details based on staff name
        $nameLower = strtolower($staff->name);
        if (str_contains($nameLower, 'uma')) {
            $designation = 'General Manager';
            $qualification = 'M.Com, M.Ed';
            $experienceText = '6 Years of leadership expertise in showroom sales administration, financial auditing, and structured collection workflows.';
        } elseif (str_contains($nameLower, 'muthu')) {
            $designation = 'Sales & Collection Manager';
            $qualification = 'B.E';
            $experienceText = '9 Years of industry experience managing 1,000+ active dealer networks, wholesale channels, and large-scale architectural supply pipelines.';
        } elseif (str_contains($nameLower, 'ashok')) {
            $designation = 'Sales & Collection Manager';
            $qualification = 'Professional Sales Leadership';
            $experienceText = '5 Years of dedicated experience driving retail showroom growth, client relations, and efficient regional collection logistics.';
        } else {
            $designation = ucfirst($staff->role ?? 'Sales & Showroom Executive');
            $qualification = 'Showroom Expert';
            $experienceText = optional($staff->profile)->bio ?? 'Dedicated to providing seamless customer support, showroom assistance, and reliable service.';
        }
    @endphp

    <div class="w-full max-w-md bg-[#0f172a] text-white rounded-3xl shadow-2xl overflow-hidden border border-slate-800">
        
        <!-- Header Profile Section -->
        <div class="text-center px-6 pt-10 pb-6 bg-gradient-to-b from-[#1e293b] to-[#0f172a]">
            <img src="{{ $avatarStoragePath ? asset('storage/' . $avatarStoragePath) : asset('images/default-profile.png') }}" 
                 class="w-28 h-28 rounded-full border-4 border-sky-500/30 object-cover mx-auto mb-4 shadow-md" 
                 alt="{{ $staff->name }}">
            
            <h1 class="text-2xl font-bold text-white">{{ $staff->name }}</h1>
            <p class="text-sky-400 font-semibold text-sm mt-1">{{ $designation }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Pillai Ceramics - {{ optional($staff->profile)->shop_name ?? 'Trichy HQ' }}</p>

            <!-- Quick Action Buttons -->
            <div class="flex justify-center gap-3 mt-6">
                <a href="tel:{{ $staff->phone }}" class="w-11 h-11 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white hover:bg-sky-600 transition shadow" title="Call">
                    <i class="fa-solid fa-phone"></i>
                </a>
                <a href="https://wa.me/{{ $staff->phone }}" target="_blank" class="w-11 h-11 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white hover:bg-emerald-600 transition shadow" title="WhatsApp">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                </a>
                <a href="mailto:{{ $staff->email }}" class="w-11 h-11 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white hover:bg-sky-600 transition shadow" title="Email">
                    <i class="fa-solid fa-envelope"></i>
                </a>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="p-6 border-t border-slate-800">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-sky-400 mb-3">Professional Profile</h2>
            <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800/80 text-sm space-y-2">
                <p><strong>Qualification:</strong> <span class="text-slate-300">{{ $qualification }}</span></p>
                <p><strong>Experience & Background:</strong> <span class="text-slate-300 text-xs leading-relaxed block mt-1">{{ $experienceText }}</span></p>
            </div>
        </div>

        <!-- Contact Details -->
        <div class="px-6 pb-6">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-sky-400 mb-3">Contact Information</h2>
            <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800/80 text-sm space-y-2">
                <p><strong>Mobile:</strong> <span class="text-slate-300">{{ $staff->phone ?? 'N/A' }}</span></p>
                <p><strong>Email:</strong> <span class="text-slate-300">{{ $staff->email }}</span></p>
                <p><strong>Address:</strong> <span class="text-slate-300">{{ $companyAddress }}</span></p>
            </div>
        </div>

        <!-- Specialization / Dealership -->
        <div class="px-6 pb-6">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-sky-400 mb-3">Specialization</h2>
            <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800/80 text-xs space-y-1.5 text-slate-300">
                <p><strong>Showroom Network:</strong> HPT Ceramics & Sanitaryware</p>
                <p><strong>Authorized Brand:</strong> Terafix HPT Tile Paste & Solutions</p>
            </div>
        </div>

        <!-- QR Code & Copy Link Section -->
        <div class="px-6 pb-6 text-center">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-sky-400 mb-3 text-start">Scan or Copy Digital Card</h2>
            <div class="bg-white p-3 rounded-2xl inline-block shadow-inner mb-4">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data={{ urlencode($cardUrl) }}" alt="Staff QR Code" class="w-[130px] h-[130px] mx-auto">
            </div>
            <div>
                <button onclick="navigator.clipboard.writeText('{{ $cardUrl }}'); alert('Digital card link copied to clipboard!');" 
                        class="w-full py-2.5 px-4 bg-sky-600 hover:bg-sky-500 text-white font-bold rounded-xl text-xs transition flex items-center justify-center gap-2 shadow-md">
                    <i class="fa-solid fa-copy"></i> Copy Card Link
                </button>
            </div>
        </div>

        <!-- Company & Branch Location Map -->
        <div class="px-6 pb-6 border-t border-slate-800 pt-6">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-sky-400 mb-3">Our Showroom Location</h2>
            <div class="rounded-xl overflow-hidden border border-slate-800">
                <iframe
                    width="100%"
                    height="180"
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