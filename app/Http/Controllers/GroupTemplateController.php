<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupTemplateRequest;
use App\Models\Group;
use App\Models\GroupTemplate;
use App\Models\Student;
use App\Models\Template;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class GroupTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::get();
        $templates = Template::get();
        // Fetch all GroupTemplates with related data
        $groupTemplates = GroupTemplate::with([
            'template',
            'group.studentCourses.student.courses',
        ])->get();

        // Prepare unique students data
        $students = $groupTemplates->flatMap(function ($groupTemplate) {
            return $groupTemplate->group->studentCourses->map(function ($studentCourse) use ($groupTemplate) {
                return [
                    'id' => $studentCourse->student->id,
                    'name' => $studentCourse->student->name,
                    'email' => $studentCourse->student->email,
                    'uuid' => $studentCourse->student->uuid,
                    'phone' => $studentCourse->student->phone,
                    'courses' => $studentCourse->student->courses->pluck('name')->toArray(),
                    'template' => $groupTemplate->template->name,
                ];
            });
        })->unique('id');
        return view('admin.groupTemplate.index', compact('groups', 'templates', 'students'));
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
        toastr()->success('Generate has been saved successfully!');
        return redirect()->route('generate.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hash = Hashids::decode($id);
        $student = Student::with(['courses.groups.templates'])
            ->where('id', $hash[0])
            ->first();
        $studentName = $student->name;
        $courseName = $student->courses->first()->name;
        $templateId = $student->courses->first()->groups->first()->templates->first();
        $groupTemplate = GroupTemplate::findOrFail($hash[0])->with('template', 'group')->first();
        return view('admin.groupTemplate.show', compact('studentName','courseName','templateId'));
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
}
