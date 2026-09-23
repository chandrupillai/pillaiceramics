<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TileSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'width_mm',
        'height_mm',
        'unit',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'width_mm' => 'decimal:2',
        'height_mm' => 'decimal:2',
    ];
}