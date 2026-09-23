<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Location;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard Statistics
        $stats = [
            'total_locations'  => Location::count(),
            'active_locations' => Location::where('is_active', true)->count(),

            'total_godowns'    => Godown::count(),
            'active_godowns'   => Godown::where('is_active', true)->count(),
            'inactive_godowns' => Godown::where('is_active', false)->count(),

            'total_users'      => User::count(),
        ];

        // Godowns grouped by Location
        $godownsByLocation = Location::withCount('godowns')
            ->having('godowns_count', '>', 0)
            ->get(['id', 'name']);

        $locationNames = $godownsByLocation
            ->pluck('name')
            ->values();

        $godownCounts = $godownsByLocation
            ->pluck('godowns_count')
            ->values();

        // Recently added Godowns
        $recentGodowns = Godown::with('location:id,name')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'stats'          => $stats,
            'locationNames'  => $locationNames,
            'godownCounts'   => $godownCounts,
            'recentGodowns'  => $recentGodowns,
        ]);
    }
}