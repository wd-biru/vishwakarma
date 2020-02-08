<?php

namespace App\Http\Controllers\Bbproject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vishwa_portal_asset;

class FormController extends Controller
{
    //
    public function index(){
    	return view('Bbproject.bForm');

    }
    
    public function store(Request $request){

    	//echo "<script>alert('jiji') </script>";
        //echo "hihi";
        //die();
            $request->validate([
              'portal_Id' => 'required|max:255',
              'asset_name' => 'required|string|max:255',
              'modelno' => 'required|string|max:255',
              'c_number' => 'required|string|max:255',
              'p_date' => 'required|string|max:255',
              'i_exprire' => 'required|string|max:255',
              'i_valid' => 'required|string|max:255',
              'text_policy_num' => 'required|string|max:255',
              'tax_valid_till' => 'required|string|max:255',
              'tax_expite_date' => 'required',
               
          ]);

    	$vishwa_portal = new Vishwa_portal_asset;

        $vishwa_portal->portal_Id = $request->input('portal_Id');
        $vishwa_portal->asset_name = $request->input('asset_name');
        $vishwa_portal->modelno = $request->input('modelno');
        $vishwa_portal->c_number = $request->input('c_number');
        $vishwa_portal->p_date = $request->input('p_date');
        $vishwa_portal->i_exprire = $request->input('i_exprire');
        $vishwa_portal->i_valid = $request->input('i_valid');
        $vishwa_portal->text_policy_num = $request->input('text_policy_num');
        $vishwa_portal->tax_valid_till = $request->input('tax_valid_till');
        $vishwa_portal->tax_expite_date = $request->input('tax_expite_date');
    	

    	$vishwa_portal->save();
    	echo "<script>alert('Your Data Inserted Successfully') </script>";
        $users=Vishwa_portal_asset::get()->toArray();
           
    	return view('Bbproject.showBproject',['users'=>$users]);
    	    }
        public function editdata($id){
        $id = convert_uudecode(base64_decode($id));
        $editdata = Vishwa_portal_asset::where('id',$id)->first()->toArray();
        //dd($editdata);
        return view('Bbproject.editportaldata',['data'=>$editdata]);
    }


     public function updatedata(Request $request)
    {
        $data=$request->all();

         $request->validate([
              'portal_Id' => 'required|max:255',
              'asset_name' => 'required|string|max:255',
              'modelno' => 'required|string|max:255',
              'c_number' => 'required|string|max:255',
              'p_date' => 'required|string|max:255',
              'i_exprire' => 'required|string|max:255',
              'i_valid' => 'required|string|max:255',
              'text_policy_num' => 'required|string|max:255',
              'tax_valid_till' => 'required|string|max:255',
              'tax_expite_date' => 'required',
               
          ]);
         
        Vishwa_portal_asset::where('id',$data['user_id'])->update([
                   // $vishwa_portal->portal_Id = $request->input('portal_Id');
                                      'portal_Id'=>$data['portal_Id'],
                                      'asset_name'=>$data['asset_name'],
                                      'modelno'=>$data['modelno'],
                                      'c_number'=>$data['c_number'],
                                      'p_date'=>$data['p_date'],
                                      'i_exprire'=>$data['i_exprire'],
                                      'i_valid'=>$data['i_valid'],
                                      'text_policy_num'=>$data['text_policy_num'],
                                      'tax_valid_till'=>$data['tax_valid_till'],
                                      'tax_expite_date'=>$data['tax_expite_date'],
                                      
                                     
        ]);
                echo "<script>alert('Your Data Updated Successfully') </script>";
       $users=Vishwa_portal_asset::get()->toArray();   
        return view('Bbproject.showBproject',['users'=>$users]);
    }

    public function deletedata(Request $request,$id){
        $id = convert_uudecode(base64_decode($id));
        Vishwa_portal_asset::where('id',$id)->delete();
        echo "<script>alert('Your Data Deleted Successfully') </script>";
//        return redirect()->back();
         $users=Vishwa_portal_asset::get()->toArray();   
        return view('Bbproject.showBproject',['users'=>$users]);

    }
    public function assetFormshow()
    {
         $users=Vishwa_portal_asset::get()->toArray();   
        return view('Bbproject.showBproject',['users'=>$users]);
    }
}
