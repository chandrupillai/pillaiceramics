@extends('layouts.admin')

@section('title', 'Preview Card: ' . $staff->name)

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-light border me-3"><i class="bi bi-chevron-left"></i></a>
            <h4 class="fw-bold mb-0">Staff Digital Business Card Preview</h4>
        </div>
        <div>
            <a href="{{ route('staff.public.card', $staff->id) }}" target="_blank" class="btn btn-sm btn-primary">
                <i class="bi bi-box-arrow-up-right me-1"></i> Open Public Card Link
            </a>
        </div>
    </div>

    @php 
        $cardUrl = route('staff.public.card', $staff->id); 
        $companyAddress = $staff->address ?? '111, Pitchi nagar, Varageri, Trichy - 620008, Tamil Nadu';
    @endphp

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="w-full bg-[#0f172a] text-white rounded-3xl shadow-2xl overflow-hidden border border-slate-800">
                
                <!-- Header Profile Section -->
                <div class="text-center px-6 pt-10 pb-6 bg-gradient-to-b from-[#1e293b] to-[#0f172a]">
                    <img src="{{ $staff->image ? asset('uploads/Staff/' . $staff->profile?->avatar) : asset('images/default-profile.png') }}" 
                         class="w-28 h-28 rounded-full border-4 border-sky-500/30 object-cover mx-auto mb-4 shadow-md" 
                         alt="{{ $staff->name }}">
                    
                    <h1 class="text-2xl font-bold text-white">{{ $staff->name }}</h1>
                    <p class="text-sky-400 font-semibold text-sm mt-1">{{ ucfirst($staff->role ?? 'Staff Member') }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Pillai Ceramics - {{ $staff->shop_name ?? 'Trichy HQ' }}</p>

                    <!-- Quick Action Buttons -->
                    <div class="flex justify-center gap-3 mt-6">
                        <a href="tel:{{ $staff->phone }}" class="w-11 h-11 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white hover:bg-sky-600 transition shadow">
                            <i class="fa-solid fa-phone"></i>
                        </a>
                        <a href="https://wa.me/{{ $staff->phone }}" target="_blank" class="w-11 h-11 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white hover:bg-emerald-600 transition shadow">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                        <a href="mailto:{{ $staff->email }}" class="w-11 h-11 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white hover:bg-sky-600 transition shadow">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="p-6 border-t border-slate-800">
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
                        <p><strong>Authorized Dealer:</strong> Ramco Cements & Hard Worker Products</p>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="px-6 pb-6 text-center">
                    <h2 class="text-xs font-extrabold uppercase tracking-widest text-sky-400 mb-3 text-start">Scan to Connect</h2>
                    <div class="bg-white p-3 rounded-2xl inline-block shadow-inner">
                       
                         <div class="bg-white p-3 rounded-2xl inline-block shadow-inner">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ urlencode($cardUrl) }}" alt="Staff QR Code" class="w-[140px] h-[140px] mx-auto">
</div>
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
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection