@extends('layouts.app')

@section('title', 'About Us | Multi-Branch Business Operations')
@section('meta_description', 'Learn about our history, mission, and how we manage 5 successful branches across Tamil Nadu and Puducherry.')

@section('content')
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-6">About Our Journey</h1>
            <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                Founded with a mission to bring accessible services to regional hubs, our business has expanded from a single flagship location into a robust network of 5 shop branches.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-12 items-center">
            <div class="bg-slate-100 rounded-2xl p-8 border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 mb-4">Our Core Mission</h2>
                <p class="text-slate-600 leading-relaxed mb-4">
                    We empower each location—from major centers like Trichy to coastal hubs like Karaikal—with localized staff, efficient supply chains, and dedicated branch management.
                </p>
                <p class="text-slate-600 leading-relaxed">
                    By tailoring products to local demands while adhering to high corporate standards, we ensure high satisfaction for every customer.
                </p>
            </div>
            <div class="space-y-6">
                <div class="border-l-4 border-indigo-600 pl-4">
                    <h3 class="font-bold text-slate-900 text-lg">Localized Branch Management</h3>
                    <p class="text-sm text-slate-600">Every shop is managed by local personnel who understand regional customer preferences.</p>
                </div>
                <div class="border-l-4 border-indigo-600 pl-4">
                    <h3 class="font-bold text-slate-900 text-lg">Streamlined Operations</h3>
                    <p class="text-sm text-slate-600">Centralized quality control keeps inventory fresh and standards consistent everywhere.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection