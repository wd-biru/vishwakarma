<?php

namespace App\Http\Controllers\admin\master\ActivityGroup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaActivityGroup;

class ActivityGroupController extends Controller
{
    public function index()
    {
        $activityGroups = VishwaActivityGroup::all();
    	return view('admin.master.ActivityGroup.index' , compact('activityGroups'));
    }

    public function create()
    {
        return view('admin.master.ActivityGroup.create');
    }


    public function store(Request $request)
    {
        $activitygroup = new VishwaActivityGroup();
        $activitygroup->activity_group = $request->group_name;
        $activitygroup->save(); 
        $request->Session()->flash('success_message','Activity Group Added Successfully!!');
        return redirect()->route('activityGroup.index') ; 
    }

    public function edit($id)
    {
        $activityGroup = VishwaActivityGroup::find($id);
        return view('admin.master.ActivityGroup.edit' ,compact('activityGroup'));
    }


    public function update(Request $request , $id)
    {
        $activitygroup = VishwaActivityGroup::find($id);
        $activitygroup->activity_group = $request->group_name;
        $activitygroup->save(); 
        $request->Session()->flash('success_message','Activity Group Updated Successfully!!');
        return redirect()->route('activityGroup.index') ; 
    }

    public function delete($id)
    {
        $activitygroup = VishwaActivityGroup::find($id)->delete();
        Session()->flash('success_message','Activity Group Deleted Successfully!!');
        return redirect()->route('activityGroup.index') ; 
    }

}
