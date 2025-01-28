<?php
namespace App\Http\Controllers;

use App\Exports\GroupExport;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Imports\GroupImport;
use App\Models\Enrollment;
use App\Models\Group;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Vinkla\Hashids\Facades\Hashids;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::get();
        return view('admin.group.index', compact('groups'));
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
        Alert::success('Success', 'Group Has Been Saved Successfully!');
        return redirect()->route('group.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hash    = Hashids::decode($id);
        $groupId = $hash[0];

        $students = Student::whereHas('enrollments', function ($query) use ($groupId) {
            $query->where('group_id', $groupId); // Filter enrollments by group ID
        })
            ->with(['enrollments' => function ($query) use ($groupId) {
                $query->where('group_id', $groupId)->with('course'); // Ensure we only get group-specific courses
            }])
            ->get();
        return view('admin.group.show', compact('students', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        $hash    = Hashids::decode($id);
        $group   = Group::findOrFail($hash[0]);
        $group->update(['name' => $request->name]);
        Alert::success('Success', 'Group Name Has Been Updated Successfully!');
        return redirect()->route('group.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hash  = Hashids::decode($id);
        $group = Group::findOrFail($hash[0]);
        Enrollment::where('group_id',$group->id)->delete();
        $group->delete();
        Alert::success('Success', 'Group Has Been Deleted Successfully!');
        return redirect()->route('group.index');

    }
    public function export()
    {
        return Excel::download(new GroupExport, 'group.xlsx');
    }
}
