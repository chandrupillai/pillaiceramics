<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'city',
        'address',
        'pincode',
        'phone',
        'email',
        'timing',
        'google_maps_link',
        'image',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    /**
     * Use 'slug' for Route Model Binding instead of 'id'
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}