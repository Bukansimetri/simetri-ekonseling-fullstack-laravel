<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'student_name', 'faculty', 'class_of', 'image', 'description',
    ];
}
