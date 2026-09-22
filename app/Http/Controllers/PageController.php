<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'title' => 'Top Retail & Service Chain in Trichy & Karaikal | Home',
            'meta_description' => 'Discover high-quality products and professional services across our 5 major shop locations in Tamil Nadu and Puducherry.'
        ]);
    }

    public function about()
    {
        return view('pages.about', [
            'title' => 'About Our 5 Regional Branches & Mission',
            'meta_description' => 'Learn how our business connects 5 regional shop locations with local managers and reliable customer service.'
        ]);
    }

    public function services()
    {
        return view('pages.services', [
            'title' => 'Our Retail & After-Sales Services',
            'meta_description' => 'Explore the comprehensive services we offer at all 5 branch locations including localized fulfillment and customer care.'
        ]);
    }

    public function shops()
    {
        // 5 Locations Data
        $shops = [
            ['name' => 'Trichy Branch', 'slug' => 'trichy', 'city' => 'Trichy', 'status' => 'Open'],
            ['name' => 'Karaikal Branch', 'slug' => 'karaikal', 'city' => 'Karaikal', 'status' => 'Open'],
            ['name' => 'Thanjavur Branch', 'slug' => 'thanjavur', 'city' => 'Thanjavur', 'status' => 'Open'],
            ['name' => 'Madurai Branch', 'slug' => 'madurai', 'city' => 'Madurai', 'status' => 'Open'],
            ['name' => 'Coimbatore Branch', 'slug' => 'coimbatore', 'city' => 'Coimbatore', 'status' => 'Open'],
        ];

        return view('pages.shops', [
            'title' => 'Find Our Shops in Trichy, Karaikal, Thanjavur & More',
            'meta_description' => 'Locate your nearest shop branch out of our 5 locations. View store timings, directions, and direct contact details.',
            'shops' => $shops
        ]);
    }

    public function contact()
    {
        return view('pages.contact', [
            'title' => 'Contact Us | Branch Support for Trichy & Karaikal',
            'meta_description' => 'Get in touch with our main customer team or select your local branch to reach out directly.'
        ]);
    }

    // Dynamic Route Handler for /shops/trichy or /shops/karaikal
    public function shopDetail($location)
    {
        $validLocations = ['trichy', 'karaikal', 'thanjavur', 'madurai', 'coimbatore'];

        if (!in_array(strtolower($location), $validLocations)) {
            abort(404);
        }

        $cityName = ucfirst($location);

        return view('pages.shop-detail', [
            'location' => $cityName,
            'title' => "{$cityName} Shop Branch | Location, Hours & Services",
            'meta_description' => "Visit our official store in {$cityName}. Check address, opening hours, and available local services."
        ]);
    }
}