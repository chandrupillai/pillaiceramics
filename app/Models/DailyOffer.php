<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'status',
        'offer_date',
    ];

    protected $casts = [
        'status' => 'integer',
        'offer_date' => 'date:Y-m-d',
    ];
}