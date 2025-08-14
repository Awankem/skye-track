<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['intern_id', 'status', 'sign_in', 'sign_out', 'date'];
    protected $casts = [
        'date' => 'date',
        'sign_in'=>'datetime',
        'sign_out'=>'datetime',
    ];
    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
