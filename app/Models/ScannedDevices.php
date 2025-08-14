<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScannedDevices extends Model
{
    protected $fillable = ['mac_address', 'first_seen_at', 'last_seen_at'];
    protected $casts = [
        'last_seen_at' => 'datetime',
        'first_seen_at' => 'datetime',
    ];
}
