<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
        use HasFactory;

    protected $fillable = [
        'type',
        'data',
        'user_id', // if you want to assign notifications to specific users
        'read',
    ];

    // Optional: if you store JSON in `data`, cast it automatically
    protected $casts = [
        'data' => 'array',
    ];
}
