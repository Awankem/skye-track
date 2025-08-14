<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'mac_address', 'department'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
