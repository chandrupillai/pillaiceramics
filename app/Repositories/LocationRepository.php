<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepository
{
    /**
     * Get all active locations for dropdown selection.
     */
    public function getActiveLocations()
    {
        return Location::where('is_active', true)
            ->select('id', 'name', 'city')
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Get all locations with pagination.
     */
    public function getAllLocations()
    {
        return Location::latest()->paginate(10);
    }

    /**
     * Find location by ID.
     */
    public function findById($id)
    {
        return Location::findOrFail($id);
    }
}