<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_no',
        'dealer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'subtotal',
        'tax_amount',
        'discount',
        'grand_total',
        'status',
        'valid_until',
        'notes',
        'created_by'
    ];

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}