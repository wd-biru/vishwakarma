<?php

namespace App\Http\Controllers\Employee;

use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeProfile;
use App\User;
use App\Models\Portal;
use App\Models\Client;
use App\Models\DesignationMaster;
use App\Models\EmployeeOtherDetail;
use App\Models\DepartmentMaster;
use App\Models\EmployeeLeaveStatus; 
use Auth;
use Storage;
use Validator;
use session;
use Log;
use DB;
use Carbon\Carbon;

class DashboardEmployee extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        $employee=EmployeeProfile::where('user_id',Auth::id())->first();
        $currentDate = Carbon::now();
        $dateNow = date('Y-m-d', strtotime($currentDate));
        $data_leaves=EmployeeLeaveStatus::where('status',1)
            ->where('start_date','>',$dateNow)
            ->where('employee_id',$employee->id)
            ->get(); 
        $apply_leave_count = count($data_leaves);
        $portal=EmployeeProfile::select('id')->where('user_id',Auth::id())->first();         
        $EmpData=EmployeeProfile::where('user_id',Auth::id())->first();
        $leave_data = EmployeeLeaveStatus::where('employee_id',$EmpData->reporting_id)
            ->where('portal_id',$EmpData->portal_id)
            ->where('start_date','>',$dateNow)
            ->get();
        $request_leave_count = count($leave_data);
        $total_leave_notification = $apply_leave_count+$request_leave_count;
        $count_on_jobs = 0;
        $jobs = DB::table('vishwa_jobs')->where('worker_id',$employee->id)->get();
        $jobs_count = count($jobs);
        foreach ($jobs as $key => $value) {
            $tasks = DB::table('vishwa_tasks')            ->where('job_id',$value->id)            ->get();
            $count_on_jobs += count($tasks);
        }
    
        $jobs = $jobs->groupBy('project_id');
        $project_count = count($jobs);
        
        $clients = Client::where('portal_id',Auth::user()->getEmp->portal_id)->get();

        $project_list=Project::where('portal_id',$EmpData->portal_id)
            ->get();
        return view('employee.dashboard',compact('project_list','leave_data','total_leave_notification','apply_leave_count','request_leave_count','project_count','jobs_count','count_on_jobs','clients'));
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

    public function getNotifications()
    {
        return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $employee=EmployeeProfile::where('user_id',Auth::id())->first();
        $Employee = EmployeeProfile::where('id',$employee->id)->first(); 
        $department=DepartmentMaster::where('status',1)->get();
        $desination=DesignationMaster::where('status',1)->get();
        $employee_other_details=EmployeeOtherDetail::where('employee_id',$employee->id)->where('portal_id',$employee->portal_id)->first(); 
        $nationality_data = DB::table('vishwa_nationalities')->get();
        
        // if($Emp != null){
        //     $depart_dataa=DepartmentMaster::where('id',$Emp->department_id)->where('status',1)->first();
        //     $desination_data=DesignationMaster::where('id',$Emp->designation_id)->where('status',1)->first();
        // //dd($desination);
        //     return view('employee.profile.show',compact('Emp','Employee','employee','employee_other_details','department','depart_dataa','desination','desination_data','nationality_data'));
        // }
        $depart_dataa = Null;
        $desination_data = Null;
        return view('employee.profile.show',compact('desination_data','desination','depart_dataa','Employee','employee','employee_other_details','department','nationality_data'));

        

        //dd($Employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
 
     
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Log::info('employee Update data DashboardEmployee@update ==:'.print_r($request->all(),true));

       $user_id = $request->input('user_id');
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' =>'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:users,mobile_no,'.$user_id,
            'other_phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'address' => 'required',
            'dob'=>'required',
            
        ]);
        //dd($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user_data = User::where('id',$user_id)->update([
            'name'=>$request->first_name,
            'mobile_no'=>$request->phone,
        ]);
        $data = EmployeeProfile::where('id',$id)->update([

            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'gender'=>$request->input('gender'),
            'phone'=>$request->input('phone'),
            'other_phone'=>$request->input('other_phone'),
            'address'=>$request->input('address'),
            'dob'=>$request->input('dob'),

            'Postal_code'=>$request->input('Postal_code'),
            'Personal_email'=>$request->input('Personal_email'),
            'Emergency_contact'=>$request->input('Emergency_contact'),
            'Emergency_tel'=>$request->input('Emergency_tel'),
            'Marital_status'=>$request->input('Marital_status'),
            'Id_number'=>$request->input('Id_number'),
            'Nationality'=>$request->input('Nationality'),
            'Town'=>$request->input('Town'),
        
       ]);
        $info_save = EmployeeProfile::find($id);
        if($request->hasfile('profile_image')) 
            { 
                $file = $request->file('profile_image');
                //dd($file);
                $extension = $file->getClientOriginalExtension();
                $fileName =time().'.'.$extension;
                if(Storage::disk('uploads')->put('profile_images/'.$fileName,
                    file_get_contents($request->file('profile_image')))){
                    $info_save->profile_image= $fileName;
                }
            }
            $info_save->save();
        $request->session()->flash('success_message','Update Successfully!!');
        return redirect()->route('employee.profile');
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
