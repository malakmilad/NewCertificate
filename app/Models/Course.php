<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_course');
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_student_course', 'student_course_id', 'group_id');
    }
}
