<?php

namespace App\Http\Controllers\ActivityGroups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Groups\Vishwa_activity_group;

class ActivityGroupController extends Controller
{
    public function index(){

    	return view('Groups.activitygroups.activitygroupForm');
    }
    public function store(Request $request){
    	$request->validate([

    		'activity_group' => 'required | unique:vishwa_activity_groups',
    	]);

    	$activitygroups = new Vishwa_activity_group;
    	$activitygroups->activity_group=$request->input('activity_group');

    	$activitygroups->save();
    	 echo "<script>alert('Your Data Inserted Successfully') </script>";
    	return view('Groups.activitygroups.activitygroupForm');


    }

    public function activityShow()
    {
    	$user = Vishwa_activity_group::get()->toArray();
    	 return view('Groups.activitygroups.activitygroupShow',['users'=>$user ]);

    }

    public function editActivity($id){
        $id = convert_uudecode(base64_decode($id));
        $editdata = Vishwa_activity_group::where('id',$id)->first()->toArray();
        return view('Groups.activitygroups.activitygroupEditForm',compact('editdata'));
    }

    public function deleteActivity(Request $request,$id){
    	$id = convert_uudecode(base64_decode($id));
    	//Vishwa_activity_group::where('id',$id)->delete();
    	echo "<script>alert('Your Data Deleted Successfully') </script>";

    	 $user = Vishwa_activity_group::get()->toArray();
         return view('Groups.activitygroups.activitygroupShow',['users'=>$user]);

    }

    public function updateActivityGroup(Request $request){
    	$data=$request->all();
    	  $request->validate([

    		'activity_group' => 'required',
    	]);

    	  Vishwa_activity_group::where('id',$data['user_id'])->update([
                          'activity_group' => $data['activity_group'],
    	  ]);

    	  echo "<script>alert('Your Data Updated Successfully') </script>";
          $user = Vishwa_activity_group::get()->toArray();
         return view('Groups.activitygroups.activitygroupShow',['users'=>$user]);
    }
}
