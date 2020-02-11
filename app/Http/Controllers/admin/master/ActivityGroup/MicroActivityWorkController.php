<?php

namespace App\Http\Controllers\admin\master\ActivityGroup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaActivityGroup;
use App\Models\VishwaMicroActivityWork;
use App\Models\VishwaSubActivityWork;
use DB;

class MicroActivityWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $microActivities = VishwaMicroActivityWork::join('vishwa_activity_groups','vishwa_activity_groups.id','vishwa_micro_activity_works.activity_group_id')
        ->join('vishwa_sub_activity_works','vishwa_sub_activity_works.id','vishwa_micro_activity_works.sub_activity_work_id')
        ->select('vishwa_activity_groups.activity_group','vishwa_sub_activity_works.sub_activity_work','vishwa_micro_activity_works.*')
        ->get();
        return view('admin.master.MicroActivity.index' ,compact('microActivities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activityGroups = VishwaActivityGroup::all();
        return view('admin.master.MicroActivity.create' , compact('activityGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $microActivity = new VishwaMicroActivityWork();
        $microActivity->activity_group_id = $request->activity_group_id;
        $microActivity->sub_activity_work_id = $request->sub_activity_id;
        $microActivity->micro_activity_work = $request->micro_activity_name;
        $microActivity->save(); 
        $request->Session()->flash('success_message','Micro Activity Work Created Successfully!!');
        return redirect()->route('microAcivity.index') ; 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activityGroups = VishwaActivityGroup::all();
        $subActivityWorks = VishwaSubActivityWork::all();
        $microActivity =  VishwaMicroActivityWork::find($id);
        return view('admin.master.MicroActivity.edit' , compact('activityGroups','microActivity','subActivityWorks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $microActivity = VishwaMicroActivityWork::find($id);
        $microActivity->activity_group_id = $request->activity_group_id;
        $microActivity->sub_activity_work_id = $request->sub_activity_id;
        $microActivity->micro_activity_work = $request->micro_activity_name;
        $microActivity->save(); 
        $request->Session()->flash('success_message','Micro Activity Work Updated Successfully!!');
        return redirect()->route('microAcivity.index') ; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMicroActivity($id)
    {
        $microActivity = VishwaMicroActivityWork::find($id)->delete();
        Session()->flash('success_message','Micro Activity Work Deleted Successfully!!');
        return redirect()->route('microAcivity.index') ;
    }

    public function getSubActivity(Request $request)
    {
        $activity_id = $request->activity_id;
        $data =  VishwaSubActivityWork::where('activity_group_id', $activity_id)->get();
        return Response()->json($data);
    }


}
