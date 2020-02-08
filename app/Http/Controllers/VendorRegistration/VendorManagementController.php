<?php

namespace App\Http\Controllers\VendorRegistration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaVendorsRegistration;
use App\Models\MasterUnit;
use App\Models\MaterialItem;
use App\Models\States;
use App\Models\Cities;
use App\Models\MasterMaterialsGroup;
use App\Models\Portal;
use App\Models\VishwaVendorPortalMapping;
use App\Models\VishwaVendorsPrice; 
use App\User;
use Session;
use DB;
use Validator;
use Log;
use Auth;

class VendorManagementController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $userType = Auth::user()->user_type;
        $vendor_reg = VishwaVendorsRegistration::where('is_active',1)->get();
        $vendor_state = States::all();
        $vendor_city = Cities::all();
        $portal_list = Portal::all();
        if($userType=='portal')
        {   
            $vendor_reg =VishwaVendorsRegistration::join('vishwa_portal_vendor_mapping', 'vishwa_vendor_master.id','=','vishwa_portal_vendor_mapping.vendor_id')
                        ->where('vishwa_portal_vendor_mapping.portal_id','=',Auth::user()->getPortal->id)
                        ->select('vishwa_vendor_master.*','vishwa_portal_vendor_mapping.portal_id as PortalId')
                        ->get();  
        }
        $vendor_material_group=MasterMaterialsGroup::all(); 
        return view('admin.master.VendorReg.vendor_index',compact('vendor_reg','vendor_state','vendor_city','vendor_material_group','portal_list','VendorPortalMapping'));
    }




    public function viewPrice()
    {   

        $vendor_material_group=MasterMaterialsGroup::all(); 
        return view('admin.master.VendorReg.vendor_view_price',compact('vendor_material_group'));
    }



    public function vendorListPrice(Request $request)
    { 
      
        $group_id=$request->group_id;
        $mat_itam_list=DB::table('vishwa_materials_item')
            ->join('vishwa_unit_masters','vishwa_materials_item.material_unit','vishwa_unit_masters.id')
            ->where('vishwa_materials_item.group_id',$group_id) 
            ->select('vishwa_materials_item.*','vishwa_unit_masters.material_unit')
            ->get(); 

        $getVendorItemPrice = VishwaVendorsPrice::all();

        return view('admin.master.VendorReg.partials.view-list',compact('mat_itam_list','getVendorItemPrice'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor_state = States::all();
        $vendor_city = Cities::all();
        $vendor_material_group=MasterMaterialsGroup::all();
        return view('admin.master.VendorReg.vendor_create',compact('vendor_state','vendor_city','vendor_material_group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



            //dd($request->all());


            $userrole =Auth::user()->user_type;
            $email = $request->input('email');
            $company_name = $request->input('company_name');
            $validator = Validator::make($request->all(),[
                'name'         => 'required|regex:/^[\pL\s\-]+$/u',
                'company_name' => 'required|max:255|unique:vishwa_vendor_master,company_name,'. $company_name,
                'mobile'     => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:users,mobile_no,',
                'director_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'director_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:users,mobile_no,',
                'supplier_of' => 'required',
                'email' => 'required|unique:users,email|email',
                'password' => 'required',
                'address' => 'required',
                'state' => 'required',
                'state_code' => 'required',
                'gstn_uin' => 'required',
                'pincode' => 'required',
                'mode_payment' => 'required',
                'city' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
        try {

            if($userrole=="portal")
            {
            
            $store_login_detail = new User();
            $store_login_detail->email = $email;
            $store_login_detail->password = bcrypt($request->input('password'));
            $store_login_detail->name = $request->input('name');
            $store_login_detail->mobile_no = $request->input('mobile');
            $store_login_detail->user_type = 'vendor';
            $store_login_detail->save();
            $get_user_id = User::where('email',$email)->first();
            $data1=$request->input('supplier_of');
            $supplier = implode(',', $data1); 
            $store_vendor_detali = new VishwaVendorsRegistration();


            $store_vendor_detali->user_id = $get_user_id->id;
            $store_vendor_detali->name = $request->input('name');
            $store_vendor_detali->email = $email;
            $store_vendor_detali->company_name = $company_name;
            $store_vendor_detali->mobile = $request->input('mobile');
            $store_vendor_detali->director_name = $request->input('director_name');
            $store_vendor_detali->director_number = $request->input('director_number');
            $store_vendor_detali->supplier_of = $supplier;
            $store_vendor_detali->address = $request->input('address');
            $store_vendor_detali->state = $request->input('state');
            $store_vendor_detali->state_code = $request->input('state_code');
            $store_vendor_detali->gstn_uin = $request->input('gstn_uin');
            $store_vendor_detali->pincode = $request->input('pincode');
            $store_vendor_detali->mode_payment = $request->input('mode_payment');
            $store_vendor_detali->city = $request->input('city');
            $store_vendor_detali->latitude = $request->input('latitude');
            $store_vendor_detali->longitude = $request->input('longitude');
            $store_vendor_detali->is_active = $request->input('is_active');
            $store_vendor_detali->save();


            $vendor_ID = VishwaVendorsRegistration::where('company_name',$company_name)->first();

           // dd($vendor_ID);

              $portal_detail = Auth::user()->getPortal()->first();

                    $portals  = Portal::find($portal_detail);
                    $store_vendor_portal_mapping = new VishwaVendorPortalMapping();
                    $store_vendor_portal_mapping->portal_id = $portal_detail->id;
                    $store_vendor_portal_mapping->vendor_id = $vendor_ID->id;
                    $store_vendor_portal_mapping->company_name = $company_name;
                    $store_vendor_portal_mapping->save();
           }
           else if($userrole=="admin")
           {
            $store_login_detail = new User();
            $store_login_detail->email = $email;
            $store_login_detail->password = bcrypt($request->input('password'));
            $store_login_detail->name = $request->input('name');
            $store_login_detail->mobile_no = $request->input('mobile');
            $store_login_detail->user_type = 'vendor';
            $store_login_detail->save();
            $get_user_id = User::where('email',$email)->first();
            $data1=$request->input('supplier_of');
            $supplier = implode(',', $data1); 
            $store_vendor_detali = new VishwaVendorsRegistration();


            $store_vendor_detali->user_id = $get_user_id->id;
            $store_vendor_detali->name = $request->input('name');
            $store_vendor_detali->email = $email;
            $store_vendor_detali->company_name = $company_name;
            $store_vendor_detali->mobile = $request->input('mobile');
            $store_vendor_detali->director_name = $request->input('director_name');
            $store_vendor_detali->director_number = $request->input('director_number');
            $store_vendor_detali->supplier_of = $supplier;
            $store_vendor_detali->address = $request->input('address');
            $store_vendor_detali->state = $request->input('state');
            $store_vendor_detali->state_code = $request->input('state_code');
            $store_vendor_detali->gstn_uin = $request->input('gstn_uin');
            $store_vendor_detali->pincode = $request->input('pincode');
            $store_vendor_detali->mode_payment = $request->input('mode_payment');
            $store_vendor_detali->city = $request->input('city');
            $store_vendor_detali->latitude = $request->input('latitude');
            $store_vendor_detali->longitude = $request->input('longitude');
            $store_vendor_detali->is_active = $request->input('is_active');
            $store_vendor_detali->save();
           
                
            }
            DB::commit();
              
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
            }    
     
            $request->session()->flash('success_message','Vendor created Successfully!!'); 
            return redirect()->route('master.vendorReg');
        

    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function portal_vendor_mapping(Request $request)
    {
        
        $vendor_id=$request->input('vendor_id');
        $userrole =Auth::user()->user_type;


        if($userrole == 'admin')
        {
            $update = VishwaVendorPortalMapping::where('vendor_id',$vendor_id)->delete();
        }
        
            $vendor_id=$request->input('vendor_id');
            $company_name_cheack = $request->input('company_name');
            foreach ($company_name_cheack as $value)
            {
                    $portals  = Portal::find($value);
                    $store_vendor_portal_mapping = new VishwaVendorPortalMapping();
                    $store_vendor_portal_mapping->portal_id = $portals->id;
                    $store_vendor_portal_mapping->vendor_id = $vendor_id;
                    $store_vendor_portal_mapping->company_name = $portals->company_name;
                    $store_vendor_portal_mapping->save();
            } 
 
            $request->session()->flash('success_message','Vendor Portal Mapping created Successfully!!');
            return redirect()->route('master.vendorReg');

    }


     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {    
        $vendor_edit_values = VishwaVendorsRegistration::find($id); 
        $vendor_state = States::all();
        $vendor_state_key=States::whereIn('id',$vendor_state)->get()->pluck('name','id')->toArray();
        $vendor_city = Cities::all();
        $supplier = explode(',', $vendor_edit_values->supplier_of); 
        $allmaster_material_group = MasterMaterialsGroup::all();
        $vendor_material_group=MasterMaterialsGroup::whereIn('id',$supplier)->get()->pluck('group_name','id')->toArray(); 
        return view('admin.master.VendorReg.vendor_edit',compact('vendor_edit_values','vendor_state','vendor_city','vendor_material_group','allmaster_material_group'));
    }



    public function GetCity(Request $request)
    {   
        
        $id = $request->input('state_id');
        $cities = Cities::where('state_id',$id)->get();
        return $cities;

         
    }


    public function vendorGetLatLong(Request $request)
    {   
    
        $state_id = $request->input('state_id');
        $city_id = $request->input('city_id');
        $LatLong = States::where('id',$state_id)->first();
       // dd($LatLong);
        return $LatLong;

         
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
            'state'             =>$postData['state'],
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
        return redirect()->route('master.vendorReg');    
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    
    //     VishwaVendorsRegistration::find($id)->delete();
    //     Session::flash('error_message', 'Vendor Record Deleted Successfully!');
    //     return redirect()->route('master.vendorReg');
    // }
}