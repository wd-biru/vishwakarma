<?php

namespace App\Http\Controllers\portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Vat;
use App\Models\Tax;
use App\Models\Vies;
use App\Models\Pay;
use App\Models\RentDefence;
use App\Models\SelfEmployed;
use App\Models\Employer;
use App\Models\States;
use Storage;
use App\Models\Intrastate;
use App\Models\CompanyRegister;
use App\Models\Carbon;
use App\Models\Portal;
use App\User;
Use Auth;
use DB;
use Validator;
use App\Models\ClientSelectService;

class DashboardPortal extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $companyData=Auth::user()->getPortal->getCompany;
        $portal_id = Auth::user()->getPortal->id;
        //dd($portal_id);
        $countValue=0;




        $employees = DB::table('vishwa_employee_profile') 
            ->where('vishwa_employee_profile.portal_id',$portal_id)
            ->get();

            $employee_list = DB::table('vishwa_employee_profile')->where('portal_id',$portal_id)
                ->get();
 

 
         return view('portal.dashboard',compact('countValue','employees','employee_list'));

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
        //
    }

    public function vendorGetCode(Request $request)
    {   
       
        $state_id = $request->input('state_id');
        $state_code = States::where('id',$state_id)->first();
        return $state_code;
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //dd('yasdj');
        $id = Auth::user()->getPortal->id;
        $data = User::where('id',$id)->first();
        $portal_state = States::all();
        $portal_edit_values = Portal::where('id',$id)->first();//dd($portal_edit_values);
        return view('portal.profile.show',compact('data','portal_edit_values','portal_state'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

            $Employee = EmployeeProfile::where('id',$id)->first();

            $department=DepartmentMaster::where('status',1)->get();
            $dataa=DepartmentMaster::where('id',$Employee->department_id)->where('status',1)->first();
            $desination=DesignationMaster::where('id',$Employee->designation_id)->where('status',1)->first();
            $designation=DepartmentMaster::find($desination->department_id)->department_name;

            return view('portal.company.employee.edit',compact('editEmployee','id','department','dataa','desination','get_reportingPerson','Employee','designation'));
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
//         dd( $request->all());
        $update_id = $request->input('update_id');
        $update_portal_details = Portal::where('user_id',$update_id)->first();
        $validate_id=$update_portal_details->id;
        $validator = Validator::make($request->all(),[

            'name' => 'required',
            'surname' => 'required',
            'company_mail'=>'required|unique:users,email,'.$update_id,
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:users,mobile_no,'.$update_id,
            'other_mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'address' => 'required',
            'status' => 'required|max:2',
            'company_name'=> 'required',
            'contact_person'=> 'required',
            'company_mobile'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:vishwa_portals,company_mobile,'.$validate_id,
            'company_address'=> 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = Auth::user()->getPortal->user_id;
        $data = User::where('id',$id)->first();
        $data->name=$request->input('name');
        $data->email=$request->input('company_mail');
        $data->mobile_no=$request->input('mobile');
        $data->save();


        $update_portal_details = Portal::where('user_id',$update_id)->first();

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

        // Check if profile image selected and uploaded
            if($request->hasfile('logo_img'))
            {
                $file = $request->file('logo_img');
                $extension = $file->getClientOriginalExtension();
                $fileName =time().'.'.$extension;
                if(Storage::disk('uploads')->put('portal_images/'.$fileName,file_get_contents($request->file('logo_img')))){
                    $update_portal_details->logo_img = $fileName;
                }
            }
        $update_portal_details->company_name = $request->input('company_name');
        $update_portal_details->vat_tin = $request->input('vat_tin');
        $update_portal_details->cst_no = $request->input('cst_no');
        $update_portal_details->service_tax_no = $request->input('service_tax_no');
        $update_portal_details->pan = $request->input('pan');
        $update_portal_details->contact_person = $request->input('contact_person');
        $update_portal_details->company_mail = $request->input('company_mail');
        $update_portal_details->company_address = $request->input('company_address');
        $update_portal_details->company_mobile = $request->input('company_mobile');

        $update_portal_details->save();



        $request->session()->flash('success_message','Update Successfully!!');
        return redirect()->route('portal.profile');
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
