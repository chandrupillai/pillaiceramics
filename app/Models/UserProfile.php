<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'location_id',
        'godown_id',
        'company_name',
        'gst_number',
        'address',
        'city',
        'pincode',
        'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
