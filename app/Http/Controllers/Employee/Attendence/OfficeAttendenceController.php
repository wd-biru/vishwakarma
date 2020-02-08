<?php

namespace App\Http\Controllers\Employee\Attendence;

use App\Models\DepartmentMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon\Carbon;

class OfficeAttendenceController extends Controller
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
       // dd($portal_id);

         $department_filter_data = collect();
        $department_id = $request->input('department_id');
        $dateFilter = $request->input('dateFilter');

         if($dateFilter != null ){
            $_dates = new Carbon(str_replace('/', '-',$dateFilter)); 
            $date = date('Y-m-d', strtotime($_dates)); 
        }else{
            $date = date('Y-m-d');
        }


        $attend_all_list = DB::table('vishwa_employee_attendence')->join('vishwa_employee_profile','vishwa_employee_attendence.employee_id','vishwa_employee_profile.id')
             ->join('vishwa_department_master','vishwa_employee_profile.department_id','vishwa_department_master.id')
            ->where('vishwa_employee_attendence.portal_id',$portal_id)
            ->whereDate('vishwa_employee_attendence.punch_in',$date)
            ->where('vishwa_employee_profile.status',1)
            ->select('vishwa_employee_attendence.*','vishwa_employee_profile.first_name','vishwa_employee_profile.last_name',
                'vishwa_department_master.department_name','vishwa_employee_profile.department_id')
            ->get();

        // dd($attend_all_list);
      
         // dd($department_filter_data = DB::table('vishwa_department_master')->where('portal_id',$portal_id)->get());
        $department_filter_data = DepartmentMaster::all();

        if($dateFilter != null || $department_id != null){ 

               if($request->input('department_id')!='ALL'){ 
                $attend_all_list = $attend_all_list->where('department_id',$department_id);
            }else{
                $attend_all_list = $attend_all_list;
            }
        } 
 
        return view('attendence.office.index',compact('attend_all_list','portal_id','department_filter_data'));
//        return($portal_id);
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
    public function update(Request $request, $id)
    {

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
