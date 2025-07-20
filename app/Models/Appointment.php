<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['student_id', 'counselor_id', 'scheduled_at', 'status', 'link_meeting', 'notes'];

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'appointment_student');
    }

    public function mainStudent()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
