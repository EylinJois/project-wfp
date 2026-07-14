<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'email',
        'phone_number',
        'sip',
        'experience',
        'photo',
        'specialty_id',
        'start_time',
        'end_time',
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

}
