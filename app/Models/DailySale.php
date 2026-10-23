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
    ];

    public function salesPerson()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}