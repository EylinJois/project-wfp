<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'content',
        'photo',
        'doctor_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }
}
