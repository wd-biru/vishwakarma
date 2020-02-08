<?php

namespace App\Http\Controllers\ActivityGroups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Groups\Vishwa_man_power;


class ManPowerController extends Controller
{
    public function index(){
    	return view('Groups.manpower.manpowerForm');
    }


    public function manPowerStore(Request $request){
    	$request->validate([

    		'man_power_type' => 'required | unique:vishwa_man_powers',
    	]);
    	$manpower = new Vishwa_man_power;
    	$manpower->man_power_type=$request->input('man_power_type');

    	$manpower->save();
    	 echo "<script>alert('Your Data Inserted Successfully') </script>";
    	$user = Vishwa_man_power::get()->toArray();
    	return view('Groups.manpower.manpowerShow',compact('user'));


    }

    public function manPowerShow()
    {
    	$user = Vishwa_man_power::get()->toArray();
    	 return view('Groups.manpower.manpowerShow',compact('user'));

    }

    public function manPowerEdit($id){
        $id = convert_uudecode(base64_decode($id));
        $editdata = Vishwa_man_power::where('id',$id)->first()->toArray();
        return view('Groups.manpower.manpowerEditForm',compact('editdata'));
    }

    public function manPowerDelete(Request $request,$id){
    	$id = convert_uudecode(base64_decode($id));
    	Vishwa_man_power::where('id',$id)->delete();
    	echo "<script>alert('Your Data Deleted Successfully') </script>";

    	 $user = Vishwa_man_power::get()->toArray();
    	 return view('Groups.manpower.manpowerShow',compact('user'));

    }

    public function manPowerUpdate(Request $request){
    	$data=$request->all();
    	  $request->validate([

    		'man_power_type' => 'required',
    	]);

    	  Vishwa_man_power::where('id',$data['user_id'])->update([
                          'man_power_type' => $data['man_power_type'],
    	  ]);

    	  echo "<script>alert('Your Data Updated Successfully') </script>";
          $user = Vishwa_man_power::get()->toArray();
    	 return view('Groups.manpower.manpowerShow',compact('user'));
    }
}
