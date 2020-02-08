<?php

namespace App\Http\Controllers\Employee\TimeSheet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeTimeSheet;
use App\Models\Client;
use App\Models\TaskMaster;
use App\Models\TimeSheet;
use App\Models\Portal;
use App\User;
use App\Models\ServiceMaster;

use App\Models\EmployeeClientPermission;
use Illuminate\Support\Facades\Auth;
use DB;

class TimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee_data = Auth::user()->getEmp;
        $portal = Portal::where('id',$employee_data->portal_id)->first();

        $client_per = EmployeeClientPermission::where('employee_id',$employee_data->id)->where('is_active',1)->get();

        if(!empty($client_per)){
            foreach ($client_per as $key => $value) {                # code...
                $client_list[] = Client::where('portal_id',$portal->id)->where('id',$value->client_id)->first();
            }
        }
        //dd($client_list);
        
        $work_type = DB::table('acc_master_time_log_work_type')            
            ->where('is_active',1)->get();
        // dd($portal,$client_list,$work_type);
        $time_sheet_list = EmployeeTimeSheet::LEFTjoin('acc_master_time_log_work_type','acc_master_time_log_work_type.id','=','acc_employee_time_sheet.task_id')
        ->select( 'acc_employee_time_sheet.*','acc_master_time_log_work_type.work_type')
       ->where('acc_employee_time_sheet.employee_id',$employee_data->id)->get();
       // dd($time_sheet_list);
        return view('employee.timeSheet.index',compact('client_list','work_type','time_sheet_list'));
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
        $date = $request->input('from_date');
        $date1 = str_replace('/', '-', $date);
        $from_date = date('Y-m-d', strtotime($date1));
        $save_time_sheet = new EmployeeTimeSheet();
        $save_time_sheet->employee_id =Auth::user()->getEmp->id;
        $save_time_sheet->portal_id =Auth::user()->getEmp->portal_id;
        $save_time_sheet->client_id = $request->input('client_id');
        $save_time_sheet->task_id = $request->input('task_type');
        $save_time_sheet->comment = $request->input('comment');
        $save_time_sheet->from_date = $from_date;
        $save_time_sheet->hour = $request->input('hour');
        $save_time_sheet->save();
        $request->session()->flash('success','ENTRY CREATED');
        return redirect()->route('employee.timeSheet');
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
    public function update(Request $request)
    {
        $date = $request->input('from_date');
        $date1 = str_replace('/', '-', $date);
        $from_date = date('Y-m-d', strtotime($date1));
        $id= $request->input('update_id');
        $save_time_sheet = EmployeeTimeSheet::find($id);

        $save_time_sheet->employee_id =Auth::user()->getEmp->id;
        $save_time_sheet->portal_id =Auth::user()->getEmp->portal_id;

        $save_time_sheet->client_id = $request->input('client_id');
        $save_time_sheet->task_id = $request->input('task_type');
        $save_time_sheet->comment = $request->input('comment');
        $save_time_sheet->from_date = $from_date;
        $save_time_sheet->hour = $request->input('hour');
        $save_time_sheet->save();
        $request->session()->flash('success','ENTRY UPDATED');
        return redirect()->route('employee.timeSheet');
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
