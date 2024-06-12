<?php

namespace App\Http\Controllers;

use App\Exports\GroupExport;
use App\Http\Requests\StoreGroupRequest;
use App\Imports\GroupImport;
use App\Models\Group;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Vinkla\Hashids\Facades\Hashids;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups=Group::get();
        return view('admin.group.index',compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        Group::create(['name' => $request->name]);

        Excel::import(new GroupImport($request->name), $request->file('file'));
        toastr()->success('Group has been saved successfully!');
        return redirect()->route('group.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hash = Hashids::decode($id);
        $students = Group::find($hash[0])
        ->studentCourses()
        ->with(['student.courses'])
        ->get()
        ->pluck('student')
        ->unique('id')
        ->values();
        return view('admin.group.show',compact('students'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
    public function export(){
        return Excel::download(new GroupExport,'group.xlsx');
    }
}
