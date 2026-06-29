<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable =[
        'member_id',
        'doctor_id',
        'consultation_type',
        'notes',
        'time',
        'status',
    ];
}
