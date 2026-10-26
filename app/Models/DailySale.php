<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    use HasFactory;

    protected $table = 'daily_sales';

    protected $fillable = [
        'user_id',
        'product_name',
        'sale_date',
        'quantity',
        'bill_shop_name',
        'vehicle_info',
        'product_id',
        'product_type_id'
    ];

    // Relationship to Sales Person (User)
    public function salesPerson()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to Product Type (Tiles, Paste, etc.)
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    // Relationship to Product (TileProduct)
    public function product()
    {
        return $this->belongsTo(TileProduct::class, 'product_id');
    }
}
