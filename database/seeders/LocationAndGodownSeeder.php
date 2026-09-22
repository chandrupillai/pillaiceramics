<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Godown;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocationAndGodownSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Trichy', 'code' => 'TRZ', 'address' => 'Thillai Nagar Main Road, Tiruchirappalli'],
            ['name' => 'Karaikal', 'code' => 'KKL', 'address' => 'Church Street, Karaikal, Puducherry'],
            ['name' => 'Karur', 'code' => 'KRR', 'address' => 'Covai Road, Karur'],
            ['name' => 'Ramanathapuram', 'code' => 'RMD', 'address' => 'Madurai Road, Ramanathapuram'],
            ['name' => 'Madurai', 'code' => 'MDU', 'address' => 'KK Nagar, Madurai'],
        ];

        foreach ($locations as $loc) {
            $location = Location::create([
                'name' => $loc['name'],
                'slug' => Str::slug($loc['name']),
                'code' => $loc['code'],
                'address' => $loc['address'],
                'is_active' => true,
            ]);

            // Create primary godown for each location
            Godown::create([
                'location_id' => $location->id,
                'name' => $loc['name'] . ' Main Godown',
                'code' => $loc['code'] . '-GD-01',
                'address' => $loc['address'],
                'is_active' => true,
            ]);
        }
    }
}
