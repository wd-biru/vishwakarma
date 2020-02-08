<?php

namespace App\Http\Controllers\Bbproject;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vishwa_asset_sevice_detail;

class DieselController extends Controller
{
    //
    Public function index()
    {
    	return view('DieselView.dieselForm');
    }

    
    public function store(Request $request){

    	//echo "<script>alert('jiji') </script>";
        //echo "hihi";
        //die();
            $request->validate([
              'diesel_id' => 'required|max:255',
              'service_id' => 'required|string|max:255',
              'service_due_date' => 'required|string|max:255',
              'due_on_type' => 'required|string|max:255',
              'v_details' => 'required|string|max:255',
              'portal_id' => 'required|string|max:255',               
          ]);

    	$vishwa_portal = new Vishwa_asset_sevice_detail;

        $vishwa_portal->diesel_id = $request->input('diesel_id');
        $vishwa_portal->service_id = $request->input('service_id');
        $vishwa_portal->service_due_date = $request->input('service_due_date');
        $vishwa_portal->due_on_type = $request->input('due_on_type');
        $vishwa_portal->v_details = $request->input('v_details');
        $vishwa_portal->portal_id = $request->input('portal_id');   	

    	$vishwa_portal->save();
    	echo "<script>alert('Your Data Inserted Successfully') </script>";

        $users=Vishwa_asset_sevice_detail::get()->toArray();
           
    	return view('DieselView.showDieselData',['users'=>$users]);
    	    }

    public function editdata($id){
        $id = convert_uudecode(base64_decode($id));
        $editdata = Vishwa_asset_sevice_detail::where('id',$id)->first()->toArray();
        return view('DieselView.editDieseldata',['data'=>$editdata]);
            }


     public function updatedata(Request $request)
    {
        $data=$request->all();

         $request->validate([
              'diesel_id' => 'required|max:255',
              'service_id' => 'required|string|max:255',
              'service_due_date' => 'required|string|max:255',
              'due_on_type' => 'required|string|max:255',
              'v_details' => 'required|string|max:255',
              'portal_id' => 'required|string|max:255',               
            ]);
         
        Vishwa_asset_sevice_detail::where('id',$data['user_id'])->update([
                   // $vishwa_portal->portal_Id = $request->input('portal_Id');
                                      'diesel_id'=>$data['diesel_id'],
                                      'service_id'=>$data['service_id'],
                                      'service_due_date'=>$data['service_due_date'],
                                      'due_on_type'=>$data['due_on_type'],
                                      'v_details'=>$data['v_details'],
                                      'portal_id'=>$data['portal_id'],                                     
            ]);
               

           echo "<script>alert('Your Data Updated Successfully') </script>";
       $users=Vishwa_asset_sevice_detail::get()->toArray();   
      	return view('DieselView.showDieselData',['users'=>$users]);

    }

    public function deletedata(Request $request,$id){
        $id = convert_uudecode(base64_decode($id));
        Vishwa_asset_sevice_detail::where('id',$id)->delete();
        echo "<script>alert('Your Data Deleted Successfully') </script>";
//        return redirect()->back();
         $users=Vishwa_asset_sevice_detail::get()->toArray();   
      	return view('DieselView.showDieselData',['users'=>$users]);

    }
    public function assetServiceShow()
    {
         $users=Vishwa_asset_sevice_detail::get()->toArray();   
        return view('DieselView.showDieselData',['users'=>$users]);
    }
}
