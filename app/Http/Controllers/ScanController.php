<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Template;
use Vinkla\Hashids\Facades\Hashids;

class ScanController extends Controller
{
    public function scan($id, $course_id, $templateId)
    {
        $hash      = Hashids::decode($id);
        $studentId = $hash[0];

        $student = Student::with(['enrollments' => function ($query) use ($course_id) {
            $query->where('id', $course_id);
        }])->findOrFail($studentId);
        $course   = Course::findOrFail($course_id);
        $template = Template::findOrFail($templateId);
        $data     = [
            'student'  => $student,
            'course'   => $course,
            'template' => $template,
        ];
        if (! $template->options['qr_code']['content']) {
            abort(404);
        }
        return view('scan', $data);
    }
}
