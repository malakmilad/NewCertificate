<?php

namespace App\Http\Controllers;

use App\Models\Student;

class ScanController extends Controller
{
    public function scan($id){
        $student = Student::with(['courses.groups.templates'])
            ->where('id', $id)
            ->first();
        if(!$student){
            abort(404);
        }
        $studentId=$student->id;
        $studentName = $student->name;
        $courseName = $student->courses->first()->name;
        $templateId = $student->courses->first()->groups->first()->templates->first();
        return view('scan', compact('studentId','studentName','courseName','templateId'));
    }
}
