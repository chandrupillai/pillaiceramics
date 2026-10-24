<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_types';

    protected $fillable = [
        'name',
        'slug',
        'flag',
        'is_active',
    ];

    public function products()
    {
        return $this->hasMany(TileProduct::class, 'product_type_id');
    }
}