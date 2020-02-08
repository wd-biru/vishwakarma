<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaVendorsRegistration;
use App\Models\MasterUnit;
use App\Models\MaterialItem;
use App\Models\States;
use App\Models\Cities;
use App\Models\MasterMaterialsGroup;
use App\User;
use Auth;
use Storage;
use Validator;
use Session;
use Log;
use DB;

class DashboardVendor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('vendor-user.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = Auth::user()->getVendor->id;
        $data = User::where('id',$id)->first();
        $vendor_edit_values = VishwaVendorsRegistration::find($id); 
        $vendor_state = States::all();
        $vendor_city = Cities::all();
        $supplier = explode(',', $vendor_edit_values->supplier_of); 
        $allmaster_material_group = MasterMaterialsGroup::all();
        $vendor_material_group=MasterMaterialsGroup::whereIn('id',$supplier)->get()->pluck('group_name','id')->toArray(); 
        //$vendor_edit_values = VishwaVendorsRegistration::where('id',$id)->first();//dd($portal_edit_values);
        return view('vendor-user.VendorPrice.profile.show',compact('data','vendor_edit_values','vendor_state','vendor_city','allmaster_material_group','vendor_material_group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       //dd($request->all());

        Log::info('Update Request Data PortalManagement@update==:'.print_r($request->all(),true));

        Log::info('Update Request Data VendorManagementController@update==:'.print_r($request->all(),true));

        $update_id = $request->input('id');
        $company_name = $request->input('company_name');
        $name = $request->input('name');
        $update_vendor_details = VishwaVendorsRegistration::find($update_id);
        $abc=$update_vendor_details->user_id;
        $validator = Validator::make($request->all(),[
            'name'         => 'required|regex:/^[\pL\s\-]+$/u|max:255|unique:vishwa_vendor_master,id,'.$update_id,
            'company_name' => 'required|max:255|unique:vishwa_vendor_master,id,'. $update_id,
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10,',
            'director_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'director_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10,',
            'supplier_of' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'state_code' => 'required',
            'gstn_uin' => 'required',
            'pincode' => 'required',
            'mode_payment' => 'required',
            'email'=>'required|unique:users,email,'.$abc,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {


        $update_vendor_details = VishwaVendorsRegistration::find($update_id);
        $data = Auth::user()->where('id',$update_vendor_details->user_id)->first();
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->mobile_no = $request->input('mobile');
        if($request->input('password')!=null)
        {
             $data->password = bcrypt($request->input('password'));
        }

        $data->save();

        $postData = $request->all();
        $supplier_of=$request->input('supplier_of');
        $supplier = implode(',', $supplier_of);

         $update_array = [
            'id'                =>$update_id,
            'name'              =>$postData['name'],
            'email'             =>$postData['email'], 
            'company_name'      =>$company_name,
            'mobile'            =>$postData['mobile'],
            'director_name'     =>$postData['director_name'],
            'director_number'   =>$postData['director_number'], 
            'supplier_of'       =>$supplier,
            'state'             =>$postData['state'],
            'city'              =>$postData['city'], 
            'latitude'          =>$postData['latitude'],
            'longitude'         =>$postData['longitude'],
            'state_code'        =>$postData['state_code'], 
            'gstn_uin'          =>$postData['gstn_uin'],
            'pincode'           =>$postData['pincode'],
            'mode_payment'      =>$postData['mode_payment'],
            'is_active'         =>$postData['is_active'], 
        ];

        VishwaVendorsRegistration::where('id',$postData['id'])->update($update_array);

        DB::commit();
          
        } catch (\Exception $e) {
            DB::rollback();
            //something went wrong
        } 
        Session::flash('success_message', 'Vendor  Updated successfully!');
        return back();   
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
