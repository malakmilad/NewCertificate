<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Vinkla\Hashids\Facades\Hashids;

class ScanController extends Controller
{
    public function scan($id){
        $hash=Hashids::decode($id);
        $student = Student::with(['courses.groups.templates'])
            ->where('id', $hash[0])
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
