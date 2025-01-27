<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $student = Student::where('name', $request['name'])
            ->orWhere( 'email', $request['email'])
            ->orWhere('uuid', $request['national_id'])
            ->orWhere('phone', $request['phone'])
            ->first();
        if (! $student) {
            $student = Student::create([
                'name'  => $request['name'],
                'email' => $request['email'],
                'uuid'  => $request['national_id'],
                'phone' => $request['phone'],
            ]);
        }
        $course = Course::firstOrCreate(['name' => $request['course_name']]);
        $hash    = Hashids::decode($request['group_id']);
        $groupId = $hash[0];

       Enrollment::firstOrCreate([
            'course_id' => $course->id,
            'student_id' => $student->id,
            'group_id' => $groupId,
        ]);
        toastr()->success('Student Has Been Saved Successfully!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
