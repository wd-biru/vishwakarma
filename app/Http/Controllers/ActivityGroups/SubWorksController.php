<?php

namespace App\Http\Controllers\ActivityGroups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Groups\Vishwa_sub_activity_group_work;

class SubWorksController extends Controller
{
    public function index(){
            $activity_group = DB::table("vishwa_activity_groups")->pluck("activity_group","id");
     	    return view('Groups.subactivityworks.subactivityworksForm',compact('activity_group'));
          }

    public function subactivityworksStore(Request $request){

    	$request->validate([

    		'sub_activity_work' => 'required | unique:vishwa_sub_activity_works',
    	]);

    	$activitygroups = new Vishwa_sub_activity_group_work;
    	$activitygroups->activity_group_id  = $request->input('activity_group_id');
    	$activitygroups->sub_activity_work  = $request->input('sub_activity_work');

    	$activitygroups->save();
    	 echo "<script>alert('Your Data Inserted Successfully') </script>";

    	 $user = Vishwa_sub_activity_group_work::get()->toArray();
    	 return view('Groups.subactivityworks.subactivityworksShow',compact('user'));
    }

    public function subactivityworksShow()
    {
    	$user = Vishwa_sub_activity_group_work::get()->toArray();
    	 return view('Groups.subactivityworks.subactivityworksShow',compact('user') );

    }

    public function subactivityworksEdit($id){

    	//$activity_group = DB::table("vishwa_activity_groups")->pluck("activity_group","id");
     	   // return view('Groups.subactivityworks.subactivityworksForm',compact('activity_group'));
    
        $id = convert_uudecode(base64_decode($id));
        $editdata = Vishwa_sub_activity_group_work::where('id',$id)->first()->toArray();
        return view('Groups.subactivityworks.subactivityworksEditForm',compact('editdata'));
    }

    public function subactivityworksDelete(Request $request,$id){
    	$id = convert_uudecode(base64_decode($id));
    	Vishwa_sub_activity_group_work::where('id',$id)->delete();
    	echo "<script>alert('Your Data Deleted Successfully33') </script>";

    	 $user = Vishwa_sub_activity_group_work::get()->toArray();
    	     	// echo "<script>alert('Your Data Deleted Successfully') </script>";

    	 return view('Groups.subactivityworks.subactivityworksShow',compact('user') );

    }

    public function subactivityworksUpdate(Request $request){
    	$data=$request->all();
    	  $request->validate([
    		   'sub_activity_work' => 'required',
    	    ]);

    	  Vishwa_sub_activity_group_work::where('id',$data['user_id'])->update([
                          'sub_activity_work' => $data['sub_activity_work'],
    	  ]);

    	  echo "<script>alert('Your Data Updated Successfully') </script>";
          $user = Vishwa_sub_activity_group_work::get()->toArray();
         return view('Groups.subactivityworks.subactivityworksShow',compact('user') );
    }
}
