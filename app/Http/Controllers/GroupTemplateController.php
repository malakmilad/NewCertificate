<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupTemplateRequest;
use App\Models\Group;
use App\Models\GroupTemplate;
use App\Models\Template;
use Illuminate\Http\Request;

class GroupTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups=Group::get();
        $templates=Template::get();
        $groupTemplates=GroupTemplate::get();
        dd($groupTemplates);
        return view('admin.groupTemplate.index',compact('groups','templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups=Group::get();
        $templates=Template::get();
        return view('admin.groupTemplate.create',compact('groups','templates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupTemplateRequest $request)
    {
        GroupTemplate::create([
            'group_id'=>$request->group_id,
            'template_id'=>$request->template_id
        ]);
        toastr()->success('Generate has been saved successfully!');
        return redirect()->route('generate.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(GroupTemplate $groupTemplate)
    {
        //
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
