<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_id',
        'tile_product_id',
        'quantity',
        'notes',
        'status',
        'updated_by',
    ];

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function product()
    {
        return $this->belongsTo(TileProduct::class, 'tile_product_id');
    }

    public function updatedByStaff()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}