<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function Destination()
    {
        return $this->belongsTo(Destination::class, 'destination');
    }

    public function Carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier');
    }

    public function TruckType()
    {
        return $this->belongsTo(TruckType::class, 'truck_type');
    }
}
