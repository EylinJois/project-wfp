<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'doctor_id',
        'consultation_type',
        'notes',
        'time',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
