<?php

namespace App\Http\Controllers;

use App\Models\TileProduct;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index(): Response
    {
        // Static URLs with priority and change frequency
        $urls = [
            [
                'loc' => route('home'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('about'),
                'lastmod' => now()->subDays(7)->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('services'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'loc' => route('shops'),
                'lastmod' => now()->subDays(3)->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'loc' => route('contact'),
                'lastmod' => now()->subDays(14)->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
        ];

        // Dynamic Product URLs (If you have detail pages for individual products)
        if (class_exists(TileProduct::class)) {
            $products = TileProduct::where('is_active', 1)->get();
            foreach ($products as $product) {
                // Adjust route name if you have a show page like route('products.show', $product->slug)
                if (Route::has('products.show')) {
                    $urls[] = [
                        'loc' => route('products.show', $product->id),
                        'lastmod' => $product->updated_at->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority' => '0.7',
                    ];
                }
            }
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}