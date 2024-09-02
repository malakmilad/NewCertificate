<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Group;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class GroupImport implements ToModel, WithHeadingRow
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function model(array $row)
    {
        try {
            // Skip empty rows
            if (empty($row['email']) && empty($row['national_id_or_passport_id']) && empty($row['phone'])) {
                return null;
            }

            // Find or create student
            $student = Student::where('email', $row['email'])
                ->orWhere('uuid', $row['national_id_or_passport_id'])
                ->orWhere('phone', $row['phone'])
                ->first();

            if (!$student) {
                $student = Student::create([
                    'email' => $row['email'],
                    'name' => $row['student_name'],
                    'uuid' => $row['national_id_or_passport_id'],
                    'phone' => $row['phone'],
                ]);
            }

            // Find or create course
            $course = Course::firstOrCreate(['name' => $row['course_name']]);

            // Find group
            $group = Group::where('name', $this->name)->first();

            if (!$group) {
                Log::warning('Group not found: ' . $this->name);
                return null;
            }

            // Create or find enrollment
            $enrollment = Enrollment::firstOrCreate([
                'course_id' => $course->id,
                'student_id' => $student->id,
                'group_id' => $group->id,
            ]);

            return $enrollment;

        } catch (\Exception $e) {
            Log::error('Error importing row: ' . $e->getMessage());
            return null;
        }
    }
}
