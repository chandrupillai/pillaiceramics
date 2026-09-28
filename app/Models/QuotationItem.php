<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'tile_product_id',
        'product_name',
        'boxes',
        'sqft_per_box',
        'total_sqft',
        'unit_price',
        'total_price'
    ];

    public function product()
    {
        return $this->belongsTo(TileProduct::class, 'tile_product_id');
    }
}