<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Godown;

class Location extends Model
{
    protected $fillable = ['name', 'slug', 'code', 'address', 'phone', 'is_active'];

    public function godowns()
    {
        return $this->hasMany(Godown::class);
    }

    public function profiles()
    {
        return $this->hasMany(UserProfile::class);
    }
}
