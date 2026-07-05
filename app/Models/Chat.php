<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    protected $fillable = [
        'chat',
        'member_id',
        'doctor_id',
        'consultation_id',
        'sender_role',
        'delivered_at',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
