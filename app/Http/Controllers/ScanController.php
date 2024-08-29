<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Template;
use Vinkla\Hashids\Facades\Hashids;

class ScanController extends Controller
{
    public function scan($id,$course_id,$templateId){
        $hash=Hashids::decode($id);
        $student = Student::with(['courses.groups.templates'])
            ->where('id', $hash[0])
            ->first();
        if(!$student){
            abort(404);
        }
        $studentId=$student->id;
        $studentName = $student->name;
        $courseName = Course::findOrFail($course_id)['name'];
        $templateId = Template::findOrFail($templateId);
        return view('scan', compact('studentId','studentName','courseName','templateId'));
    }
}
