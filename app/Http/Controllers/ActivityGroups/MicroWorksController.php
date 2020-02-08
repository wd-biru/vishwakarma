<?php

namespace App\Http\Controllers\ActivityGroups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Groups\Vishwa_micro_activity_work;

class MicroWorksController extends Controller
{
    public function index(){
            $activity_group = DB::table("vishwa_activity_groups")->pluck("activity_group","id");
     	    return view('Groups.microactivityworks.microactivityworksForm',compact('activity_group'));
          }

    public function microactivityworksStore(Request $request){

    	$request->validate([

    		'micro_activity_work' => 'required | unique:vishwa_micro_activity_works',
    	]);
      //dd($request);
    	$microactivityworks = new Vishwa_micro_activity_work;
    	$microactivityworks->activity_group_id  = $request->input('activity_group_id');
    	$microactivityworks->micro_activity_work  = $request->input('micro_activity_work');

    	$microactivityworks->save();
    	 echo "<script>alert('Your Data Inserted Successfully') </script>";
          $user = Vishwa_micro_activity_work::get()->toArray();
         return view('Groups.microactivityworks.microactivityworksShow',compact('user') );
         
    }

    public function microactivityworksShow()
    {
    	$user = Vishwa_micro_activity_work::get()->toArray();
    	 return view('Groups.microactivityworks.microactivityworksShow',compact('user') );

    }

    public function microactivityworksEdit($id){    
        $id = convert_uudecode(base64_decode($id));
        $user = Vishwa_micro_activity_work::where('id',$id)->first()->toArray();
        //dd($user);
        return view('Groups.microactivityworks.microactivityworksEditForm',compact('user'));
    }

    public function microactivityworksDelete(Request $request,$id){
    	$id = convert_uudecode(base64_decode($id));
    	Vishwa_micro_activity_work::where('id',$id)->delete();
    	echo "<script>alert('Your Data Deleted Successfully') </script>";

    	 $user = Vishwa_micro_activity_work::get()->toArray();
         return view('Groups.microactivityworks.microactivityworksShow',compact('user') );

    }

    public function microactivityworksUpdate(Request $request){
    	$data=$request->all();
    	  $request->validate([
    		   'micro_activity_work' => 'required',
    	    ]);

    	  Vishwa_micro_activity_work::where('id',$data['user_id'])->update([
                          'micro_activity_work' => $data['micro_activity_work'],
    	  ]);

    	  echo "<script>alert('Your Data Updated Successfully') </script>";
          $user = Vishwa_micro_activity_work::get()->toArray();
         return view('Groups.microactivityworks.microactivityworksShow',compact('user') );
    }
}
