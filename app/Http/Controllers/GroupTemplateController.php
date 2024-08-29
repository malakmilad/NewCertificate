<?php

namespace App\Http\Controllers;

use App\Events\AttachmentEvent;
use App\Http\Requests\StoreGroupTemplateRequest;
use App\Models\Course;
use App\Models\Font;
use App\Models\Group;
use App\Models\GroupTemplate;
use App\Models\Student;
use App\Models\Template;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class GroupTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        $templates = Template::all();
        $groupTemplates = GroupTemplate::with([
            'template',
            'group.studentCourses.student.courses',
        ])->get();
        $students = $groupTemplates->flatMap(function ($groupTemplate) {
            $group = $groupTemplate->group;

            return $group->studentCourses->flatMap(function ($studentCourse) use ($groupTemplate) {
                $student = $studentCourse->student;
                $courses = $student->courses->filter(function ($course) use ($studentCourse) {
                    return $studentCourse->course_id == $course->id;
                });
                return $courses->map(function ($course) use ($student, $groupTemplate) {
                    return [
                        'id' => $student->id,
                        'name' => $student->name,
                        'email' => $student->email,
                        'uuid' => $student->uuid,
                        'phone' => $student->phone,
                        'course_id' => $course->id,
                        'course' => $course->name,
                        'template' => $groupTemplate->template->name,
                        'template_id' => $groupTemplate->template->id,
                    ];
                });
            });
        });

        return view('admin.groupTemplate.index', compact('students', 'groups', 'templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Group::get();
        $templates = Template::get();
        return view('admin.groupTemplate.create', compact('groups', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupTemplateRequest $request)
    {
        GroupTemplate::create([
            'group_id' => $request->group_id,
            'template_id' => $request->template_id,
        ]);
        event(new AttachmentEvent($request->group_id, $request->template_id));
        toastr()->success('Generate has been saved successfully!');
        return redirect()->route('generate.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id,$course_id,$templateId)
    {
        $hash = Hashids::decode($id);
        $student = Student::with(['courses.groups.templates'])
            ->where('id', $hash[0])
            ->first();
        $studentId = $student->id;
        $studentName = $student->name;
        $courseName = Course::findOrFail($course_id)['name'];
        $templateId = Template::findOrFail($templateId);
        return view('admin.groupTemplate.show', compact('studentId', 'studentName','course_id', 'courseName', 'templateId'));
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
    public function download($id,$course_id,$templateId)
    {
        $hash = Hashids::decode($id);
        $student = Student::with(['courses.groups.templates'])
            ->where('id', $hash[0])
            ->first();
        $fonts = Font::get();
        $studentId = $student->id;
        $studentName = $student->name;
        $courseName = Course::findOrFail($course_id)['name'];
        $templateId = Template::findOrFail($templateId);
        $studentPdf = Pdf::loadView('admin.pdf.student', compact('studentId', 'studentName', 'courseName','course_id', 'templateId'));
        return $studentPdf->download($student->name.'_'.$courseName . '.pdf');
    }
}
