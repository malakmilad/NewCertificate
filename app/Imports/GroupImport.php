<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Group;
use App\Models\Student;
use App\Models\StudentCourse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GroupImport implements ToModel, WithHeadingRow
{
    protected $groupName;

    public function __construct($groupName)
    {
        $this->groupName = $groupName;
    }

    public function model(array $row)
    {
        $student = Student::where('uuid', $row['nationalid_or_passportid'])->first();
        if(!$student){
            $student = Student::firstOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['student_name'],
                    'uuid' => $row['nationalid_or_passportid'],
                    'phone' => $row['phone']
                ]
            );
        }
        $course = Course::firstOrCreate(['name' => $row['course_name']]);

        $studentCourse = StudentCourse::firstOrCreate([
            'student_id' => $student->id,
            'course_id' => $course->id
        ]);

        $group = Group::firstOrCreate(['name' => $this->groupName]);

        $group->students()->attach($studentCourse);
    }
}
