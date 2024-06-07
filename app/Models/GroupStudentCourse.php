<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupStudentCourse extends Model
{
    use HasFactory;
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function studentCourse()
    {
        return $this->belongsTo(StudentCourse::class);
    }
}
