<?php

namespace App\Http\Controllers\Employee\Attendence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon\Carbon;

class SiteAttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $portal_id = 0;
        if(Auth::user()->getEmp!=null){
            $portal_id = Auth::user()->getEmp->portal_id;
        } 
        $checkProjectAuth = DB::table('vishwa_employee_project_mapping')->where('portal_id',$portal_id)->where('employee_id',Auth::user()->getEmp->id)->get();
        if($checkProjectAuth->count()<=0){
            $msg='Un Authorised Operation,You are Not Allocate Any Projects.';
            $authority = false;
            return view('attendence.site.index',compact('authority','msg'));
        }
        $project_filter_data = collect();
        $project_id = $request->input('project_id');
        $dateFilter = $request->input('dateFilter');

        $project_filter_data = DB::table('vishwa_projects')->where('portal_id',$portal_id)->get();
        if($dateFilter != null ){
            $_dates = new Carbon(str_replace('/', '-',$dateFilter)); 
            $date = date('Y-m-d', strtotime($_dates)); 
        }else{
            $date = date('Y-m-d');
        }
        $attend_site_list = DB::table('vishwa_employee_attendence')->join('vishwa_employee_profile','vishwa_employee_attendence.employee_id','vishwa_employee_profile.id')
        ->join('vishwa_employee_project_mapping','vishwa_employee_project_mapping.employee_id','vishwa_employee_attendence.employee_id')
        ->join('vishwa_projects','vishwa_projects.id','vishwa_employee_project_mapping.project_id')
        ->join('vishwa_designation_master','vishwa_designation_master.id','vishwa_employee_project_mapping.role_id')
        ->where('vishwa_employee_attendence.portal_id',$portal_id)
        ->where('vishwa_employee_project_mapping.portal_id',$portal_id)
        ->whereDate('vishwa_employee_attendence.punch_in',$date)
        ->where('vishwa_employee_profile.status',1)
        ->select('vishwa_employee_attendence.*','vishwa_employee_profile.first_name','vishwa_employee_profile.last_name','vishwa_projects.name as project_name','vishwa_projects.id as project_id','vishwa_designation_master.designation as designation')
        ->get();  
        if($dateFilter != null || $project_id != null){ 
            if($request->input('project_id')!='ALL'){ 
                $attend_site_list = $attend_site_list->where('project_id',$project_id);
            }else{
                $attend_site_list = $attend_site_list;
            }
        } 
 
        return view('attendence.site.index',compact('attend_site_list','project_filter_data'));
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
   
    public function approvedAttendence(Request $request)
    { 
        $update = DB::table('vishwa_employee_attendence')->where('id',$request->input('update_id'))->update([
            'working_hours'=>$request->input('working_hour'),
            'approve_by'=>Auth::user()->getEmp->id,
            'approve_date'=> date('Y-m-d')          
        ]);
        // dd(Auth::user()->getEmp->id,$update,date('Y-m-d') );
        if($update){
            return 'ok';
        }else{
            return 'ok';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

   
}
