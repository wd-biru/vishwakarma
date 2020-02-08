<?php

namespace App\Http\Controllers\Employee\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeaveMaster;
use App\Models\CompanyInfo;
use App\Models\EmployeeProfile;
use App\Models\EmployeeLeaveStatus;
use App\Models\LeavesStatusMaster;
use App\Models\Portal;
use Session\session;
use Auth;
use Carbon\Carbon;
use App\User;
use Validator;


class EmployeeLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portal=EmployeeProfile::select('portal_id','id')->where('user_id',Auth::id())->first();
        $leaves=LeaveMaster::where('is_active',1)->get();
        return view('employee.leave.applyleave',compact('leaves','portal'));
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
        $validator = Validator::make($request->all(),[
            'leave_id' => 'required',            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $date = $request->input('start_date');
        $date1 = str_replace('/', '-', $date);
        $start_date = date('Y-m-d', strtotime($date1));
        $date = $request->input('end_date');
        $date1 = str_replace('/', '-', $date);
        $end_date = date('Y-m-d', strtotime($date1));
        $leave = new EmployeeLeaveStatus();
        $leave->portal_id=$request->input('portal_id');
        $leave->employee_id=$request->input('employee_id');
        $leave->leave_id=$request->input('leave_id');
        $leave->start_date=$start_date;
        $leave->end_date=$end_date;
        $leave->status=1;
        $leave->reason=$request->input('reason');
        $leave->no_of_day=$request->input('no_days');
        $leave->save();
        $request->session()->flash('success_message','Leave Successfully!! Applied'); 
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function leaveRequest()
    {

        $portal=EmployeeProfile::select('id')->where('user_id',Auth::id())->first();
         
        $EmpData=EmployeeProfile::where('user_id',Auth::id())->first();
        $leave_data = EmployeeLeaveStatus::where('employee_id',$EmpData->reporting_id)->where('portal_id',$EmpData->portal_id)->get();
      //dd($leave_data);
        $leave_status = LeavesStatusMaster::get();
        $currentDate = Carbon::now();
        $dateNow = date('Y-m-d', strtotime($currentDate));
       
        return view('employee.leave.leaverequest',compact('EmpData','leave_data','leave_status','dateNow'));
    }

        




        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function leaveRequestStore(Request $request)
    { 
        $update_id = $request->input('leave_id');
        $status = $request->input('status');
       
        $leave_data_update = EmployeeLeaveStatus::where('id',$update_id)->first();
        $leave_data_update->status=$status;
        $leave_data_update->is_active=0;
        $leave_data_update->save();
    
       $request->session()->flash('success_message','Leave Status Updated Successfully');
        return redirect()->route('employee.leave.request');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function myLeave()
    {
        
        $EmpData=EmployeeProfile::where('user_id',Auth::id())->first();
        $leave_data = EmployeeLeaveStatus::where('employee_id',$EmpData->id)->get();
        return view('employee.leave.myLeave',compact('EmpData','leave_data'));
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
