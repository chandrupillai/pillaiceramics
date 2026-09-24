<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TileProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'sku',
        'slug',
        'tile_category_id',
        'tile_type_id',
        'tile_size_id',
        'location_id',
        'godown_id',
        'price',
        'stock_quantity',
        'box_coverage_sqft',
        'pieces_per_box',
        'image',
        'description',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'pieces_per_box' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(TileCategory::class, 'tile_category_id');
    }

    public function type()
    {
        return $this->belongsTo(TileType::class, 'tile_type_id');
    }

    public function size()
    {
        return $this->belongsTo(TileSize::class, 'tile_size_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function godown()
    {
        return $this->belongsTo(Godown::class);
    }
}