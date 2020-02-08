<?php

namespace App\Http\Controllers\Employee\Others;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeOtherDetail;
use App\Models\DesignationMaster;
use Auth;
use Storage;
use App\Models\EmployeeBusiness;
use Validator;
use session;
use Log;
class EmployeeOtherDetails extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

     public function getdesignationJSON($id)
    {
      Log::info('id EmployeeOtherDetails@getdesignationJSON==:'.print_r($id,true));
      $data=DesignationMaster::where('department_id',$id)->where('status',1)->get();
      $this->jsonResponse['success'] = true;
      $this->jsonResponse['data'] = $data;
      return response()->json($this->jsonResponse);
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
        Log::info('employee info store EmployeeOtherDetails@store=='.print_r($request->all(),true));
            $postData=$request->all();
        //dd($request->all());
            $id=$request->input('employee_id');
            $data=EmployeeBusiness::where('employee_id', $id)->first();
            if(!empty($data))
            {   
                   $validator = Validator::make($request->all(),[
                        'employee_id' => 'required',
                        'department_id' => 'required',   
                        'designation_id' => 'nullable',
                        'office_phone' => 'nullable|numeric',
                        'extension_number' => 'nullable|numeric',
                        'business_email'=>'nullable|email',
                        'hourly_charge'=>'nullable',
                    ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                        $employee_info_update=EmployeeBusiness::where('employee_id', $id)->update([

                       
                        'department_id' =>  $request->input('department_id'), 
                        'designation_id'=>$request->input('designation_id'),
                        'office_phone'=>$request->input('office_phone'),
                        'extension_number' => $request->input('extension_number'),
                        'business_email'=>$request->input('business_email'),
                        'hourly_charge'=>$request->input('hourly_charge'),

                   ]);
                    $request->session()->flash('success_message','Update Successfully!!');
            return redirect()->route('employee.profile');
            }  
          else          {
                $validator = Validator::make($request->all(),[
                        'employee_id' => 'required',
                        'department_id' => 'required',   
                        'designation_id' => 'nullable',
                        'office_phone' => 'nullable|numeric',
                        'extension_number' => 'nullable|numeric',
                        'business_email'=>'nullable|email',
                        'hourly_charge'=>'nullable',
                    ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                $store_detail = new EmployeeBusiness();
                $store_detail->employee_id = $request->input('employee_id');
                $store_detail->department_id = $request->input('department_id'); 
                $store_detail->designation_id = $request->input('designation_id'); 
                $store_detail->office_phone = $request->input('office_phone'); 
                $store_detail->extension_number = $request->input('extension_number');
                $store_detail->business_email = $request->input('business_email');
                $store_detail->hourly_charge = $request->input('hourly_charge');
                $store_detail->save();
           $request->session()->flash('success_message','ADD Successfully!!');
        return redirect()->route('employee.profile');
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($portal_id,$employee_id)
    {
        $data=EmployeeOtherDetail::where('portal_id',$portal_id)->where('employee_id',$employee_id)->get();
       
        return view('employee.partials.employeeOtherinfo',compact('data'));
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
    public function update()
    {
            $postData=$request->all();
            //dd($postData);
            $id=$request->input('employee_id');
            $validator = Validator::make($request->all(),[
                'father_name' => 'required',
                'mother_name' => 'required',   
                'matrial_status' => 'required',
                'blood_group' => 'required',
                'skills' => 'required',
                'facebook_link'=>'url|nullable',
                'twitter_link'=>'url|nullable',
                'linkedin_link'=>'url|nullable',
                'skype_link'=>'url|nullable',
            ]);

            $data=EmployeeOtherDetail::where('employee_id', $id)->first();

            if ($validator->fails()||(isset($data))) {              
              $this->jsonResponse['error'] = true;
              $this->jsonResponse['message'] = "Same Entry Found!!";
              return response()->json($this->jsonResponse);  
              exit();              
            }
            $store_detail = new EmployeeOtherDetail();
            $store_detail->employee_id = $request->input('employee_id');
            $store_detail->portal_id = $request->input('portal_id'); 
            $store_detail->father_name = $request->input('father_name'); 
            $store_detail->mother_name = $request->input('mother_name'); 
            $store_detail->matrial_status = $request->input('matrial_status');
            $store_detail->blood_group = $request->input('blood_group');
            $store_detail->skills = $request->input('skills');
            $store_detail->about_yourself = $request->input('about_yourself');
            $store_detail->facebook_link = $request->input('facebook_link');
            $store_detail->twitter_link = $request->input('twitter_link');
            $store_detail->linkedin_link = $request->input('linkedin_link');
            $store_detail->skype_link = $request->input('skype_link');
            $store_detail->save();
            if ($store_detail->save()) {              
              $this->jsonResponse['success'] = true;
              $this->jsonResponse['message'] = "Employee Created SuccessFully";            
            }
           
        return response()->json($this->jsonResponse);
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
