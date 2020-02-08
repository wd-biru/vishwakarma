<?php

namespace App\Http\Controllers\admin\master\department;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DepartmentMaster;
use App\Models\DesignationMaster;
use Validator;
use DB;
use Log;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments=DepartmentMaster::where('portal_id',null)->where('status',1)->get();
        //dd($departments);
        return view('admin.master.department.index',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
      $d_name=$request->input('department_name');
      $depatment_name=strtoupper($d_name);
      $department = DB::table('vishwa_department_master')->where('department_name', $depatment_name)
      ->where('status','=',0)->get();
      if(count($department)>0)
      {
      $department = DB::table('vishwa_department_master')
           ->where('department_name', $depatment_name)
            ->update(['status' => 1]);
        if($department==true)
        {
          $this->jsonResponse['success'] = true;
          $this->jsonResponse['message'] = "Successfully saved info";
        }
        return response()->json($this->jsonResponse);
      }
      else
      {
        $department = DB::table('vishwa_department_master')->where('department_name', $depatment_name)
      ->where('status','=',1)->get();
             if(count($department)>0)
      {
         $this->jsonResponse['success'] = false;
          $this->jsonResponse['message'] = "already Exist";

      }
      else
      {
        $d_name=$request->input('department_name');
        $depatment_name=strtoupper($d_name);
        $departmentInfo=new DepartmentMaster();
        $departmentInfo->department_name=$depatment_name;
        $departmentInfo->save();
        if($departmentInfo==true){
          $this->jsonResponse['success'] = true;
          $this->jsonResponse['message'] = "Successfully saved info";
        }
        
      }

      }   
        

        return response()->json($this->jsonResponse);
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function designationStore(Request $request)
    {

    

      $designation=$request->input('designation_name');
      $depart_id=$request->input('depart_id');
      $designation_name=strtoupper($designation);
      $designationcount = DB::table('vishwa_designation_master')->where('designation', $designation_name)
      ->where('department_id','=',$depart_id)
      ->where('status','=',1)->get();
      if(count($designationcount)>0)
      {
     
      
         $this->jsonResponse['success'] = false;
          $this->jsonResponse['message'] = "already Exist";

      }
      else
      {

        $designationInfo=new DesignationMaster();
        $designationInfo->department_id=$request->input('depart_id');
        $designationInfo->designation=$designation_name;
        $designationInfo->save();
        if($designationInfo==true)
        {
          $this->jsonResponse['success'] = true;
          $this->jsonResponse['message'] = "Successfully saved info";
        }
        
      }

        return response()->json($this->jsonResponse);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $departments=DepartmentMaster::where('portal_id',null)->where('status',1)->get();
        return view('admin.master.department.partials.depart_list',compact('departments'));
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
    
        $update_id=$request->input('update_id');
        $d_name=$request->input('department_name');
        $depatment_name=strtoupper($d_name);
      
        $chk = DepartmentMaster::where('department_name',$depatment_name)->get();
        if(count($chk)>0)
        {
          $this->jsonResponse['success'] = false;
          $this->jsonResponse['message'] = "Department Already Exist";
        }

        else
        {
            $departmentInfo= DepartmentMaster::where('id',$update_id)->first();
            $departmentInfo->department_name=$depatment_name;
            $departmentInfo->save();
        if($departmentInfo==true){
          $this->jsonResponse['success'] = true;
          $this->jsonResponse['message'] = "Successfully Update info";
        }

        }

       
        return response()->json($this->jsonResponse);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function designationUpdate(Request $request)
    {

        //dd($request->all());
        Log::info("update id or desig modal DepartmentController@designationUpdate ==:".print_r($request->all(),true));
        $update_id=$request->input('deg_id');
        $status=$request->input('status');
        $d_name=$request->input('designation_name');
        $designation_name=strtoupper($d_name);
        $Info= DesignationMaster::where('id',$update_id)->first();
        $Info->designation=$designation_name;
        $Info->status=$status;
        $Info->save();
        if($Info==true){
          $this->jsonResponse['success'] = true;
          $this->jsonResponse['message'] = "Successfully Update info";
        }
        return response()->json($this->jsonResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Log::info("deleted id or desig modal DepartmentController@destroy ==:".print_r($request->all(),true));
        $delete_id = $request->input('dept_id');
        if (!empty($delete_id)) {
            foreach ($delete_id as $key => $value) {
                $del= DepartmentMaster::where('id',$value)->first();
                $del->status=0;
                $del->save();
            }
            $request->session()->flash('error_message','Depatment DELETED');
        }else{
            $request->session()->flash('error_message','Please select Departemnt for delete');
        }

        return redirect()->route('department.master');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkUnique(Request $request)
    {
        $d_name = $request->input('d_name');
       // dd($d_name);
        $get_data =  DepartmentMaster::where('company_id',null)->where('department_name',$d_name)->where('status',1)->first();
        if(!empty($get_data))        {
            echo "OK";
        }else{
        
        }
        exit();
    }   
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkUniquedesignation(Request $request)
    {

        $d_name = $request->input('d_name');
        $dept_id = $request->input('dept_id');
       
        $get_data =  DesignationMaster::where('designation',$d_name)->where('department_id',$dept_id)->where('status',1)->first();
        if(!empty($get_data))        {
            echo "OK";
        }else{
        
        }
        exit();
    }
}