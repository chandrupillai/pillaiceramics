@extends('layouts.app')

@section('title', 'Contact Us | Reach Our Branch Teams')
@section('meta_description', 'Get in touch with our main office or reach out directly to your local branch in Trichy, Karaikal, or other locations.')

@section('content')
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto bg-white p-8 md:p-10 rounded-2xl shadow-sm border border-slate-200">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Get in Touch</h1>
            <p class="text-slate-600 text-sm mb-8">Have a question or need service assistance? Send us a message and select your preferred branch.</p>

            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Your Name</label>
                        <input type="text" name="name" required class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                        <input type="email" name="email" required class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Select Preferred Branch</label>
                    <select name="branch" class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white">
                        <option value="trichy">Trichy Branch</option>
                        <option value="karaikal">Karaikal Branch</option>
                        <option value="thanjavur">Thanjavur Branch</option>
                        <option value="madurai">Madurai Branch</option>
                        <option value="coimbatore">Coimbatore Branch</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                    <textarea name="message" rows="4" required class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition text-sm">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</section>
@endsection