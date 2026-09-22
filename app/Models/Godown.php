<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Godown extends Model
{
    protected $fillable = [
        'location_id', 'name', 'code', 'address', 
        'incharge_person', 'contact_number', 'is_active'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}