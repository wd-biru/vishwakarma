<?php

namespace App\Http\Controllers\portal\time_keeping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\TaskMaster;
use App\Models\TimeSheet;
use App\User;
use App\Models\ServiceMaster;
use App\Models\EmployeeTimeSheet;
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
        $user_id = Auth::user()->getPortal->id;
        $client_list = Client::where('portal_id',$user_id)->get();
        $task_list = ServiceMaster::All();
        $user_list = User::All();
        $work_type = DB::table('acc_master_time_log_work_type')            
            ->where('is_active',1)->get();
        $time_sheet_list = TimeSheet::LEFTjoin('acc_master_time_log_work_type','acc_master_time_log_work_type.id','=','acc_time_sheets.task_type')
        ->select( 'acc_time_sheets.*','acc_master_time_log_work_type.work_type')
        ->where('acc_time_sheets.user_id',Auth::user()->getPortal->id)->get();

        return view('portal.time_keeping.index',compact('client_list','task_list','time_sheet_list','user_list','work_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function employeeIndex()
    {
        $time_sheet_list = EmployeeTimeSheet::LEFTjoin('acc_master_time_log_work_type','acc_master_time_log_work_type.id','=','acc_employee_time_sheet.task_id')
        ->select( 'acc_employee_time_sheet.*','acc_master_time_log_work_type.work_type')
       ->where('acc_employee_time_sheet.portal_id',Auth::user()->getPortal->id)->get();
       return view('portal.company.employee.timeSheet',compact('client_list','work_type','time_sheet_list'));
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
        $save_time_sheet = new TimeSheet();
        $save_time_sheet->user_id = Auth::user()->getPortal->id;
        $save_time_sheet->client_id = $request->input('client_id');
        $save_time_sheet->task_type = $request->input('task_type');
        $save_time_sheet->comment = $request->input('comment');
        $save_time_sheet->from_date = $from_date;
        $save_time_sheet->hour = $request->input('hour');
        $save_time_sheet->save();
        $request->session()->flash('success','ENTRY CREATED');
        return redirect()->route('timeSheet');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TimeSheet  $timeSheet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,TimeSheet $timeSheet)
    {
        $date = $request->input('from_date');
        $date1 = str_replace('/', '-', $date);
        $from_date = date('Y-m-d', strtotime($date1));
        $date = $request->input('to_date');
        $date1 = str_replace('/', '-', $date);
        $to_date = date('Y-m-d', strtotime($date1));
        $task_type = $request->input('task_type');
        $client_id = $request->input('client_id');
        if((!empty($client_id))&&(!empty($task_type)))
        { 
            if ((!empty($from_date)) && (!empty($to_date))) {
                $filter_data= TimeSheet::where('client_id',$client_id)->whereIn('task_type',$task_type)->whereBetween('from_date',[$from_date,$to_date])->get();
            }else{
//dd('HIII');
            }
            $filter_data= TimeSheet::where('client_id',$client_id)->whereIn('task_type',$task_type)->get();
                //dd($filter_data);
            
        }elseif((!empty($from_date)) && (!empty($to_date))){
            $filter_data= TimeSheet::where('client_id',$client_id)->whereBetween('from_date',[$from_date,$to_date])->get();
        }
        //$filter_data= TimeSheet::where('client_id',$client_id)->get();

        $user_id = Auth::user()->getPortal->id;//dd($portal_id);
        $client_list = Client::where('portal_id',$user_id)->get();
        //$client_list = Client::All();
        $task_list = ServiceMaster::All();
        
        return view('portal.time_keeping.index',compact('client_list','task_list','filter_data','user_list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TimeSheet  $timeSheet
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeSheet $timeSheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TimeSheet  $timeSheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeSheet $timeSheet)
    {
        $date = $request->input('from_date');
        $date1 = str_replace('/', '-', $date);
        $from_date = date('Y-m-d', strtotime($date1));
        $id= $request->input('update_id');
        $update_time_sheet = TimeSheet::find($id);

        $update_time_sheet->user_id = Auth::user()->getPortal->id;
        $update_time_sheet->client_id = $request->input('client_id');
        $update_time_sheet->task_type = $request->input('task_type');
        $update_time_sheet->comment = $request->input('comment');
        $update_time_sheet->from_date = $from_date;
        $update_time_sheet->hour = $request->input('hour');
        $update_time_sheet->save();
        $request->session()->flash('success','ENTRY UPDATED');
        return redirect()->route('timeSheet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TimeSheet  $timeSheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeSheet $timeSheet)
    {
        //
    }

    public function checkHourValidation(Request $request)
    {
        $hour = $request->input('hour');
        if($hour < 8)
        {
             echo "please enter less then & equals 8";
        }
        else
        {
   
        }
        exit();
    }
}
