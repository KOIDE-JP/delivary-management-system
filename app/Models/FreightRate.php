<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreightRate extends Model
{
    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }


    public function truckType()
    {
        return $this->belongsTo(TruckType::class);
    }

}
