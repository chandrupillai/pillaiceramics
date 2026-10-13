@extends('layouts.app')

@section('title', 'Contact Us | Reach Our Branch Teams')
@section('meta_description', 'Get in touch with our main headquarters in Trichy or reach out directly to your local branch in Karur, Karaikal, Ramanathapuram, or Madurai.')

@section('content')
<section class="py-16 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Title Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-sky-600 font-bold uppercase text-xs tracking-widest">Get In Touch</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Contact Our Showrooms</h1>
            <p class="text-slate-600 text-sm mt-2">Have a question, bulk inquiry, or need service assistance? Send us a message or visit any of our 5 regional branches.</p>
        </div>

        <!-- 2-Column Grid: Left Map & Right Form -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT SIDE: Google Map & Branch Info Card -->
            <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-1">Headquarters Location</h3>
                    <p class="text-xs text-slate-500 mb-4">111, Pitchi nagar, Varageri, Trichy - 620008, Tamil Nadu</p>
                </div>

                <!-- Google Map Embed -->
                <div class="h-80 w-full rounded-2xl overflow-hidden border border-slate-200 relative bg-slate-100 shadow-inner">
                    <iframe 
                        class="w-full h-full border-0" 
                        loading="lazy" 
                        allowfullscreen 
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q=111+Pitchi+nagar+Varageri+Trichy+620008&output=embed">
                    </iframe>
                </div>

                <!-- Quick Contact Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="block text-xs font-bold text-sky-600 uppercase">Sales Helpline</span>
                        <span class="text-sm font-bold text-slate-800">+91 9444365536</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="block text-xs font-bold text-sky-600 uppercase">Corporate Email</span>
                        <span class="text-sm font-bold text-slate-800">info@pillaiceramics.in</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: Contact Form -->
            <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
                <h3 class="text-xl font-bold text-slate-900 mb-1">Send Us a Message</h3>
                <p class="text-xs text-slate-500 mb-6">Select your preferred branch and our team will get back to you shortly.</p>

                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Your Name</label>
                            <input type="text" name="name" required placeholder="Enter your full name" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Phone Number</label>
                            <input type="tel" name="phone" required placeholder="Enter mobile number" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Email Address</label>
                        <input type="email" name="email" required placeholder="name@example.com" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Select Preferred Branch</label>
                        <select name="branch" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none bg-white transition">
                            <option value="trichy">Trichy Branch (HQ)</option>
                            <option value="karur">Karur Branch</option>
                            <option value="karaikal">Karaikal Branch</option>
                            <option value="ramanathapuram">Ramanathapuram Branch</option>
                            <option value="madurai">Madurai Branch</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Message / Inquiry Details</label>
                        <textarea name="message" rows="4" required placeholder="Tell us about your tile requirements, sanitaryware, or Ramco product inquiry..." class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none transition"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-sky-500/25 text-sm active:scale-[0.99]">
                        Send Message &rarr;
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection