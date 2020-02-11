<?php

namespace App\Http\Controllers\admin\master\ActivityGroup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaSubActivityWork;
use App\Models\VishwaActivityGroup;
use DB;

class SubActivityWorkController extends Controller
{

    public function index()
    {
        $subActivities = VishwaSubActivityWork::join('vishwa_activity_groups','vishwa_activity_groups.id','vishwa_sub_activity_works.activity_group_id')
        ->select('vishwa_activity_groups.activity_group','vishwa_sub_activity_works.*')
        ->get();
        return view('admin.master.SubActivity.index', compact('subActivities'));
    }

    public function create()
    {
        $activityGroups = VishwaActivityGroup::all();
        return view('admin.master.SubActivity.create' , compact('activityGroups'));
    }

    public function store(Request $request)
    {
        $subActivity = new VishwaSubActivityWork();
        $subActivity->activity_group_id = $request->activity_group_id;
        $subActivity->sub_activity_work = $request->sub_activity_name;
        $subActivity->save(); 
        $request->Session()->flash('success_message','Sub Activity Added Successfully!!');
        return redirect()->route('subActivity.index') ; 
    }

    public function edit($id)
    {
        $activityGroups = VishwaActivityGroup::all();
        $subActivity = VishwaSubActivityWork::find($id);
        return view('admin.master.SubActivity.edit' ,compact('subActivity','activityGroups'));
    }


    public function update(Request $request , $id)
    {
        $subActivity = VishwaSubActivityWork::find($id);
        $subActivity->activity_group_id = $request->activity_group_id;
        $subActivity->sub_activity_work = $request->sub_activity_name;
        $subActivity->save(); 
        $request->Session()->flash('success_message','Sub Activity Updated Successfully!!');
        return redirect()->route('subActivity.index') ; 
    }

    public function delete($id)
    {
        $subActivity = VishwaSubActivityWork::find($id)->delete();
        Session()->flash('success_message','Sub Activity Deleted Successfully!!');
        return redirect()->route('subActivity.index') ; 
    }

}
