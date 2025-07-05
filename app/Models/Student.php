<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'place_of_birth',
        'date_of_birth',
        'address',
        'etnic',
        'username',
        'email',
        'phone',
        'hobby',
        'phone',
        'bio',
        'image',
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
