<?php
namespace App\Http\Controllers;

use App\Events\AttachmentEvent;
use App\Http\Requests\StoreGroupTemplateRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\EnrollmentTemplate;
use App\Models\Group;
use App\Models\GroupTemplate;
use App\Models\Student;
use App\Models\Template;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Vinkla\Hashids\Facades\Hashids;

class GroupTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all groups and templates
        $groups    = Group::all();
        $templates = Template::all();

        // Retrieve all enrollment templates with related group and template
        $enrollmentTemplates = EnrollmentTemplate::with(['template', 'group.enrollments.student'])->get();

        // Flatten and filter the data
        $students = $enrollmentTemplates->flatMap(function ($groupTemplate) {
            return $groupTemplate->group->enrollments->map(function ($enrollment) use ($groupTemplate) {
                $student       = $enrollment->student;
                $course        = $enrollment->course;
                $group         = $enrollment->group;
                $student->name = ! empty($enrollment->student_name) ? $enrollment->student_name : $student->name;
                return [
                    'id'          => $student->id,
                    'name'        => $student->name,
                    'email'       => $student->email,
                    'uuid'        => $student->uuid,
                    'phone'       => $student->phone,
                    'course_id'   => $course->id,
                    'course'      => $course->name,
                    'template'    => $groupTemplate->template->name,
                    'template_id' => $groupTemplate->template->id,
                    'group'       => $group,
                ];
            });
        });
        $data = [
            'students'  => $students,
            'groups'    => $groups,
            'templates' => $templates,
        ];
        return view('admin.groupTemplate.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.groupTemplate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupTemplateRequest $request)
    {
        EnrollmentTemplate::updateOrCreate([
            'group_id'    => $request->group_id,
            'template_id' => $request->template_id,
        ]);
        event(new AttachmentEvent($request->group_id, $request->template_id));
        Alert::success('Success', 'Generate has been saved successfully!');
        return redirect()->route('generate.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $course_id, $templateId,$groupId)
    {
        $hash      = Hashids::decode($id);
        $studentId = $hash[0];
        $student = Student::with(['enrollments' => function ($query) use ($course_id) {
            $query->where('id', $course_id)
                ->select('id', 'student_id', 'group_id', 'course_id', 'student_name')
                ->with('course');
        }])
            ->findOrFail($studentId);
        $group=Group::findOrFail($groupId);
        $student_name=Enrollment::where('student_id', $studentId)->where('group_id',  $group->id)->first();
        $student->name = ! empty($student_name->student_name) ? $student_name->student_name : $student->name;
        $course   = Course::findOrFail($course_id);
        $template = Template::findOrFail($templateId);
        $data     = [
            'student'  => $student,
            'course'   => $course,
            'template' => $template,
            'group_id' => $group->id
        ];
        return view('admin.groupTemplate.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GroupTemplate $groupTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GroupTemplate $groupTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupTemplate $groupTemplate)
    {
        //
    }
    public function download($id, $course_id, $templateId, $groupId)
    {
        $hash      = Hashids::decode($id);
        $studentId = $hash[0];

        $student = Student::findOrFail($studentId);

        $enrollment = Enrollment::where('student_id', $studentId)
            ->where('group_id', $groupId)
            ->where('course_id', $course_id)
            ->first();

        if ($enrollment && ! empty($enrollment->student_name)) {
            $student->name = $enrollment->student_name;
        }

        $course   = Course::findOrFail($course_id);
        $template = Template::findOrFail($templateId);

        $data = [
            'student'  => $student,
            'course'   => $course,
            'template' => $template,
        ];

        $studentPdf = Pdf::loadView('admin.pdf.student', $data);
        $studentPdf->setPaper('A4', 'landscape');

        return $studentPdf->download($student->name . '_' . $course->name . '.pdf');
    }
}
