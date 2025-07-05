<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'education',
        'experience',
        'username',
        'email',
        'phone',
        'address',
        'essay',
        'office',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
