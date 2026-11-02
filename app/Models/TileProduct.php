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
        'description',
        'tile_category_id',
        'tile_type_id',
        'tile_size_id',
        'product_type_id',
        'price',
        'stock_quantity',
        'box_coverage_sqft',
        'pieces_per_box',
        'production_company_id',
        'godown_id',
        'location_id',
        'image',
        'is_active',
    ];

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

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function productionCompany()
    {
        return $this->belongsTo(ProductionCompany::class, 'production_company_id');
    }

    public function godown()
    {
        return $this->belongsTo(Godown::class, 'godown_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}