<?php

namespace App\Http\Controllers\admin\portals;

use App\Models\EmployeeProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaVendorPortalMapping;
use App\Models\VishwaVendorsRegistration;
use App\Models\States;
use App\User;
use Auth;
use Carbon\Carbon;
use Storage;
use DB;
use File;
use Log;
use App\Models\Portal;
use App\Models\Client;
use Validator;


class PortalManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portal_list = Portal::all();
        $portal_state = States::all();
        return view('admin.portal.index',compact('portal_list','portal_state'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $portal_state = States::all();
        return view('admin.portal.create',compact('portal_list','portal_state'));
    }


    public function vendorGetStateCode(Request $request)
    {   
       
        $state_id = $request->input('state_id');
        $state_code = States::where('id',$state_id)->first();
        return $state_code;
         
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
        Log::info('Data for store PortalManagement@store==:'.print_r($request->all(),true));
        $email = $request->input('email');
        $validator = Validator::make($request->all(),[
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'surname' => 'required|regex:/^[\pL\s\-]+$/u',
            'mobile' => 'required|unique:vishwa_portals,mobile|min:10',
            'other_mobile' => 'numeric|nullable',
            'address' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required',
            'state_code' => 'required',
            'gstn_uin' => 'required',
            'pan' => 'required',
            'state' => 'required',
            'contact_person'=>'required',
            'company_mail'=>'required|email',
            'company_address'=>'required',
            'company_mobile'=> 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $store_login_detail = new User();
        $store_login_detail->email = $email;
        $store_login_detail->password = bcrypt($request->input('password'));
        $store_login_detail->name = $request->input('name');
        $store_login_detail->mobile_no = $request->input('mobile');
        $store_login_detail->user_type = 'portal';
        $store_login_detail->save();
        Log::info('Nwe Portal Login id PortalManagement@store==:'.print_r($store_login_detail->id,true));
        $get_user_id = User::where('email',$email)->first();
        Log::info('protal creaded on user PortalManagement@store==:'.print_r($get_user_id,true));

        //portal detiails
        $store_portal_detali = new Portal();
        $store_portal_detali->user_id = $get_user_id->id;
        $store_portal_detali->name = $request->input('name');
        $store_portal_detali->surname = $request->input('surname');
        $store_portal_detali->mobile = $request->input('mobile');
        $store_portal_detali->other_mobile = $request->input('other_mobile');
        $store_portal_detali->status = $request->input('status');
        $store_portal_detali->address = $request->input('address');
        $store_portal_detali->state = $request->input('state');
        $store_portal_detali->state_code = $request->input('state_code');
        $store_portal_detali->gstn_uin = $request->input('gstn_uin');
        $store_portal_detali->cin = $request->input('cin');




        // Check if profile image selected and uploaded
        if($request->hasfile('logo_img'))  {
            $file = $request->file('logo_img');
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $filename = $file->getClientOriginalName();
            $name = $timestamp . '-' . $filename;
            if($file->move('public/uploads/portal_images/', $name)){
                $postData['logo_img'] = $name;
            }
        }

        $store_portal_detali->logo_img = $name;
        $store_portal_detali->company_name = $request->input('company_name');
        $store_portal_detali->contact_person = $request->input('contact_person');
        $store_portal_detali->company_mail = $request->input('company_mail');
        $store_portal_detali->company_address = $request->input('company_address');
        $store_portal_detali->company_mobile = $request->input('company_mobile');
        $store_portal_detali->vat_tin = $request->input('vat_tin');
        $store_portal_detali->cst_no = $request->input('cst_no');
        $store_portal_detali->service_tax_no = $request->input('service_tax_no');
        $store_portal_detali->pan = $request->input('pan');
        $store_portal_detali->save();
        Log::info('new Portal created id PortalManagement@store==:'.print_r($store_portal_detali->id,true));
        $request->session()->flash('success_message','Portal created Successfully!!');





        return redirect()->route('portal');
    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function EmpStore(Request $request,$id)
    {

        Log::info('Emp data from request PortalManagement@EmpStore==:'.print_r($request->all(),true));
        $portal_id = $id;
        Log::info('Emp data created on Portal id PortalManagement@EmpStore==:'.print_r($id,true));
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|unique:users,email|email',
            'password' => 'required',
            'phone' => 'required|unique:vishwa_employee_profile,phone|min:10',
            'other_mobile' => 'required',
            'address' => 'required',
            'status' => 'required|max:2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $email  = $request->input('email');
        $store_login_detail = new User();
        $store_login_detail->email = $request->input('email');
        $store_login_detail->password = bcrypt($request->input('password'));
        $store_login_detail->name = $request->input('first_name');
        $store_login_detail->mobile_no = $request->input('mobile');
        $store_login_detail->user_type = 'employee';
        $store_login_detail->save();
        Log::info(' New Emp Login created Id PortalManagement@EmpStore==:'.print_r($store_login_detail->id,true));
        $get_user_id = User::where('email',$email)->value('id');
        Log::info(' New Emp created Id on PortalManagement@EmpStore==:'.print_r($get_user_id,true));
        $info_save = new EmployeeProfile();
        $info_save->first_name = $request->input('first_name');
        $info_save->user_id = $get_user_id;
        $info_save->portal_id = $portal_id;
        $info_save->last_name = $request->input('last_name');
        $info_save->status = $request->input('status');
        $info_save->phone = $request->input('phone');
        $info_save->other_phone = $request->input('other_mobile');
        $info_save->address = $request->input('address');
        $info_save->save();
        Log::info(' New Emp created Id PortalManagement@EmpStore==:'.print_r($info_save->id,true));
        $request->session()->flash('success_message','Add Successfully!!');

        return redirect()->route('companyemployee');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('portal ShoW Id PortalManagement@show==:'.print_r($id,true));
        $companies = Client::where('portal_id',$id)->get();
        $portal_show_values = Portal::find($id);
        $email = User::where('id',$portal_show_values->user_id)->value('email');
        return view('admin.portal.show',compact('portal_show_values','email','companies'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Log::info('Portal Edit Id PortalManagement@edit==:'.print_r($id,true));
        $portal_edit_values = Portal::find($id);
        $portal_state = States::all();
        $data = Auth::user()->where('id',$portal_edit_values->user_id)->first();
        $menus=DB::table('vishwa_menu_master')->where('menu_config',1)->get();
        $portals_menu = DB::table('vishwa_menu_permission')->where('user_id',$portal_edit_values->user_id)->where('is_active',1)->get();
        return view('admin.portal.edit',compact('portal_edit_values','data','menus','portals_menu','portal_state'));
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

        // $request->all();


        Log::info('Update Request Data PortalManagement@update==:'.print_r($request->all(),true));
        $update_id = $request->input('update_id');

        $update_portal_details = Portal::find($update_id);
        $abc=$update_portal_details->user_id;
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'surname' => 'required',
            'mobile' => 'required',
            'other_mobile' => 'required|max:10',
            'address' => 'required',
            'status' => 'required|max:2',
            'state_code' => 'required',
            'pan' => 'required',
            'gstn_uin' => 'required',
            'state' => 'required',
            'company_mail'=>'required|unique:users,email,'.$abc,
            'company_name'=> 'required',
            'contact_person'=> 'required',
            'company_mobile'=> 'required|max:10',
            'company_address'=> 'required',
            'email'=>'required|unique:users,email,'.$abc,

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Log::info('Update portal on id PortalManagement@update==:'.print_r($update_id,true));
        $update_portal_details = Portal::find($update_id);
        $data = Auth::user()->where('id',$update_portal_details->user_id)->first();
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->mobile_no = $request->input('mobile');
        if($request->input('password')!=null)
        {
             $data->password = bcrypt($request->input('password'));
        }

        $data->save();


        $update_portal_details->name = $request->input('name');
        $update_portal_details->surname = $request->input('surname');
        $update_portal_details->mobile = $request->input('mobile');
        $update_portal_details->other_mobile = $request->input('other_mobile');
        $update_portal_details->status = $request->input('status');
        $update_portal_details->address = $request->input('address');
        $update_portal_details->state = $request->input('state');
        $update_portal_details->state_code = $request->input('state_code');
        $update_portal_details->gstn_uin = $request->input('gstn_uin');
        $update_portal_details->cin = $request->input('cin');
        if($request->hasfile('logo_img'))
        {
            $file = $request->file('logo_img');
            $extension = $file->getClientOriginalExtension();
            $fileName =time().'.'.$extension;
            if(Storage::disk('uploads')->put('portal_images/'.$fileName,file_get_contents($request->file('logo_img')))){
                $oldfile = $update_portal_details->logo_img;
                $update_portal_details->logo_img = $fileName;
                File::delete(public_path('uploads/portal_images/'. $oldfile));
            }
        }
        $update_portal_details->company_name = $request->input('company_name');
        $update_portal_details->contact_person = $request->input('contact_person');
        $update_portal_details->company_mail = $request->input('company_mail');
        $update_portal_details->company_address = $request->input('company_address');
        $update_portal_details->company_mobile = $request->input('company_mobile');
        $update_portal_details->vat_tin = $request->input('vat_tin');
        $update_portal_details->cst_no = $request->input('cst_no');
        $update_portal_details->service_tax_no = $request->input('service_tax_no');
        $update_portal_details->pan = $request->input('pan');
        $update_portal_details->save();

        $request->session()->flash('success_message','Portal Updated Successfully!!');
        return redirect()->route('portal');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info('Portal Delted Id PortalManagement@destroy==:'.print_r($id,true));
        $delete_portal = Portal::find($id);
        $data = Auth::user()->where('id',$delete_portal->user_id)->delete();
        $delete_portal->delete();
        return redirect()->route('portal');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function empShow($id)
    {
        Log::info('Employee Show on portal id PortalManagement@empShow==:'.print_r($id,true));
        $employees = EmployeeProfile::where('portal_id',$id)->get();
        return view('admin.portal.employeeShow',compact('employees'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function portal_vendor_mapping()
    {
        $portal_list = Portal::all();
        $vendor      = collect();
        return view('admin.portal.portal_vendor_mapping',compact('portal_list','vendor'));
    }

    public function Getvendoritem(Request $request,$id)
    { 
     
        $vendor_ids  = VishwaVendorPortalMapping::where('portal_id',$id)->pluck('vendor_id','id')->toArray();

        $vendor      = VishwaVendorsRegistration::whereIn('id',$vendor_ids)->get();         
        $portal_list = Portal::all();
        return view('admin.portal.portal_vendor_mapping',compact('portal_list','vendor'));
        
    }
}
