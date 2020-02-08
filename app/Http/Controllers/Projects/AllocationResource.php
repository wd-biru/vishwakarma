<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\VishwaMasterServiceGroup;
use App\Models\DepartmentMaster;
use App\Models\DesignationMaster;
use Session;
use App\Models\EmployeeProfile;
use App\Models\ProjectMapping;
use App\Models\Portal;
use App\Entities\Projects\Project;


class AllocationResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {

          $id = Auth::user()->id;
            if(Auth::user()->user_type=="employee")
            {
             $result = EmployeeProfile::where('user_id',$id)->pluck('portal_id')->first();
             $portal_id = Portal::where('id',$result)->first();
            }
            else
            {
            $portal_id = Portal::where('user_id',$id)->first();
            }     

     //$employee=EmployeeProfile::where('portal_id',$portal_id->id)->get();
     $employee = EmployeeProfile::join('vishwa_department_master','vishwa_department_master.id','vishwa_employee_profile.department_id')
             ->join('vishwa_designation_master','vishwa_employee_profile.designation_id','vishwa_designation_master.id')
            ->where('vishwa_employee_profile.portal_id',$portal_id->id)
            ->select('vishwa_employee_profile.*','vishwa_department_master.department_name','vishwa_designation_master.designation')
            ->get();


       $allocatedEmployee=ProjectMapping::join('vishwa_employee_profile','vishwa_employee_profile.id','vishwa_employee_project_mapping.employee_id')
       ->join('vishwa_projects','vishwa_projects.id','vishwa_employee_project_mapping.project_id')
            ->where('vishwa_employee_project_mapping.portal_id',$portal_id->id)
            ->where('vishwa_employee_project_mapping.project_id',$project->id)
             ->select('vishwa_employee_project_mapping.*','vishwa_employee_profile.first_name','vishwa_employee_profile.last_name')
            ->get();
  

           // dd($allocatedEmployee);

     $roles=collect();
 
      $OPERATIONS= DepartmentMaster::where('department_name',trim('OPERATIONS'))->first();
      if($OPERATIONS !=null){

      $roles= DesignationMaster::where('department_id',$OPERATIONS->id)->get();
      }




     return view('projects.allocation.index',compact('project','department','designation','employee','roles','newEmployee','allocatedEmployee'));

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

          
          $id = Auth::user()->id;
            if(Auth::user()->user_type=="employee")
            {
             $result = EmployeeProfile::where('user_id',$id)->pluck('portal_id')->first();
             $portal_id = Portal::where('id',$result)->first();
            }
            else
            {
            $portal_id = Portal::where('user_id',$id)->first();
            }
        $check=ProjectMapping::where('portal_id',$portal_id->id)->where('employee_id',$request->input('emp_id'))->where('project_id',$request->input('project_id'))->first();

        

        if($check!=null){
           return "exist"; 
        }

        $data = new ProjectMapping;
        $data->employee_id=$request->input('emp_id');
        $data->portal_id=$portal_id->id;
        $data->project_id=$request->input('project_id');
        $data->save();



        return "ok";

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

    }


    function change_status(Request $request)
    {

     //dd($request->all());

     $actt =$request->input('actt'); 
     $mapping_id =$request->input('mapping_id');
        
         $emp_sta = ProjectMapping::where('id',$mapping_id)->update(['is_active' => $actt]);
 


            if($emp_sta==0)
             $request->session()->flash('success','Deactivated Successfully !!');
            else
             $request->session()->flash('success','Active Successfully !!');

         return back();
             
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
          $id = Auth::user()->id;
            if(Auth::user()->user_type=="employee")
            {
             $result = EmployeeProfile::where('user_id',$id)->pluck('portal_id')->first();
             $portal_id = Portal::where('id',$result)->first();
            }
            else
            {
            $portal_id = Portal::where('user_id',$id)->first();
            }

         $mapping  = $request->input('mapping_id');
         $role = $request->input('role');
         $emp_id = $request->input('emp_id');
   
        
       $result = ProjectMapping::where('id',$mapping)
          ->update(['role_id'=>$role,'employee_id'=>$emp_id,'portal_id'=>$portal_id->id]);

          Session::flash('success_message', 'Update Success'); 
          return back();
       
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $editInfo=ProjectMapping::where('id',$id)->delete();

      return redirect()->back();

    }
}
