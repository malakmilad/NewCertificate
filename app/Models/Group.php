<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function studentCourses()
    {
        return $this->belongsToMany(StudentCourse::class, 'group_student_course');
    }

    public function templates()
    {
        return $this->belongsToMany(Template::class, 'group_templates');
    }
}
