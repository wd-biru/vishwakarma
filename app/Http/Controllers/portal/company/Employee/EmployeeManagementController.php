<?php

namespace App\Http\Controllers\portal\company\Employee;

use App\Exports\Models\EmployeeExport;
use App\Imports\Models\EmployeeImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeProfile;
use App\User;
use App\Models\Portal;
use App\Models\Client;
use App\Models\DesignationMaster;
use DB;
use App\Models\DepartmentMaster;
use App\Models\EmployeeClientPermission;
use Auth;
Use Log;
use App\Lead;
use Storage;
use Carbon\Carbon;
use Validator;
use File;
use Maatwebsite\Excel\Facades\Excel;


class EmployeeManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $portal_id = Auth::user()->getPortal->id;

      // $employee_list = EmployeeProfile::where('portal_id',$portal_id)->get();



        $employee_list = DB::table('vishwa_employee_profile')->where('portal_id',$portal_id)
            ->get();

          //  dd($employee_list);



      return view('portal.company.employee.index',compact('employee_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $portal_id = Auth::user()->getPortal->id;
      Log::info('Employee create on Portal id EmployeeManagementController@create==:'.print_r($portal_id,true));
      // $get_client = Client::where('portal_id',$portal_id)->get();
      // return view('portal.company.employee.create',compact('get_client'));

      //Log::info('edit id EmployeeManagementController@edit==:'.print_r($id,true));
      $portal=Portal::select('id')->where('user_id',Auth::id())->first();
      $get_client = Client::where('portal_id',$portal_id)->get();
      //$get_reporting=EmployeeProfile::all(); //where('portal_id',$portal->id)->get();
    //  $get_reportingPerson=$get_reporting->whereNotIn('id',$id);
      $ab=$portal->id;
      $editEmployee = EmployeeProfile::all(); //where('id',$id)->get();

     $Employee = EmployeeProfile::where('portal_id',$portal_id)->get();

      $department=DepartmentMaster::all(); //where('status',1)->get();
      $designation=DesignationMaster::all();
      //$dataa=DepartmentMaster::where('id',$Employee->department_id)->where('status',1)->first();
      $desination=DesignationMaster::all(); //where('id',$Employee->designation_id)->where('status',1)->first();
      return view('portal.company.employee.create',compact('editEmployee','get_client','department','designation','Employee'));


    }

    public function findDesignationName(Request $request)
    {

        $data=DesignationMaster::select('designation','id')->where('department_id',$request->id)
            ->take(100)->get();
        return response()->json($data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//       dd($request->all());
      Log::info('Employee Data store EmployeeManagementController@store==:'.print_r($request->all(),true));
      $portal_id = Auth::user()->getPortal->id;
      Log::info('Employee Store on Portal id EmployeeManagementController@store==:'.print_r($portal_id,true));
      $validator = Validator::make($request->all(),[
        'first_name' => 'bail|required|regex:/^[\pL\s\-]+$/u',
        'last_name' => 'required|regex:/^[\pL\s\-]+$/u',
        'gender'=>'required',
        'email' => 'required|email|unique:users,email,',
        'password' => 'required',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
        'other_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
        'address' => 'required',
        'status' => 'required|max:2',
        'dob'=>'required',
        'department_name'=>'required',
        'designation_name'=>'required',
        'reporting_id'=>'required',
        'date_of_joining'=>'required',

      ]);
      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }


      $email  = $request->input('email');
      $store_login_detail = new User();
      $store_login_detail->email = $request->input('email');
      $store_login_detail->password = bcrypt($request->input('password'));
      $store_login_detail->name = $request->input('first_name');
      $store_login_detail->mobile_no = $request->input('phone');
      $store_login_detail->user_type = 'employee';
      $store_login_detail->save();
      Log::info('New emp Login id EmployeeManagementController@store==:'.print_r($store_login_detail->id,true));
      $get_user_id = User::where('email',$email)->value('id');

      $info_save = new EmployeeProfile();

      $info_save->user_id = $get_user_id;
      $info_save->portal_id = $portal_id;

      $info_save->first_name = $request->input('first_name');
      $info_save->last_name = $request->input('last_name');
      $info_save->gender = $request->input('gender');
      $info_save->dob = $request->input('dob');
      $info_save->phone = $request->input('phone');
      $info_save->other_phone = $request->input('other_phone');
      $info_save->address = $request->input('address');
      $info_save->status = $request->input('status');
      $info_save->department_id = $request->input('department_name');
      $info_save->designation_id = $request->input('designation_name');
      $info_save->date_of_joining = $request->input('date_of_joining');

      $isDirector=$request->input('isDirector');

      if($isDirector == "yes")
      {
          $info_save->reporting_id = 0;
      }
      else
      {
          $info_save->reporting_id = $request->input('reporting_id');
      }
      if($request->hasfile('profile_image'))
          {
              $file = $request->file('profile_image');
              $extension = $file->getClientOriginalExtension();
              $fileName =time().'.'.$extension;
              if(Storage::disk('uploads')->put('admin_images/'.$fileName,file_get_contents($request->file('profile_image')))){
                  $info_save->profile_image = $fileName;
              }
          }

      $info_save->save();
      Log::info('New emp Profile data id EmployeeManagementController@store==:'.print_r($info_save->id,true));
      $request->session()->flash('success_message','Add Successfully!!');

      return redirect()->route('companyemployee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    public function modulesMenu(Request $request,$id)
    {

      Log::info('Employee Id EmployeeManagementController@modulesMenu==:'.print_r($id,true));
      $employee_data = EmployeeProfile::where('id',$id)->first();
      $data = Auth::user()->where('id',$employee_data->user_id)->first();
      $portal_id = Auth::user()->getPortal->id;
      Log::info('portal id data CompanyManagementController@index--:'.print_r($portal_id,true));
      $menus=DB::table('vishwa_menu_master')->where('menu_config',2)->get();
      $portal_user_id = Portal::find($portal_id);
      $client_list = Client::where('portal_id',$portal_id)->where('status',1)->get();
    $portal_menu_per = DB::table('vishwa_menu_permission')->where('user_id', $portal_user_id->user_id)->where('is_active',1)->get();

      $portal_permission = DB::table('vishwa_menu_permission')
            ->join('vishwa_menu_master', 'vishwa_menu_master.id', 'vishwa_menu_permission.menu_id')
            ->where('vishwa_menu_permission.user_id', $portal_user_id->user_id)
            ->where('vishwa_menu_permission.is_active',1)
            ->get(['menu_name']);

          //  dd($portal_permission);



      $client_permission  = Client::all();
      $employee_menu = DB::table('vishwa_menu_permission')->where('user_id',$employee_data->user_id)->where('is_active',1)->get();
      //dd($employee_menu);
      return view('portal.company.employee.module-permission',compact('client_permission','employee_data','data','menus','employee_menu','portal_permission','client_list'));

    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modulesMenuStore(Request $request)
    {


      $postData = $request->all();
      Log::info('EmployeeManagementController@modulesMenuStore INPUT DATA IDs==:'.print_r($postData,true));
      $employee=$postData['employee_id'] ;
      Log::info('EmployeeManagementController@modulesMenuStore ON employee id SAVE DATA==:'.print_r($employee,true));
      $user_login_id =EmployeeProfile::where('id',$employee)->value('user_id');
      Log::info('EmployeeManagementController@modulesMenuStore ON login id ==:'.print_r($user_login_id,true));
      $check_data_ = DB::table('vishwa_menu_permission')->where('user_id',$user_login_id)->where('menu_id',$postData['menu_id'])->first();

      if (!empty($check_data_)) {
        if ($check_data_->is_active===0) {
          $check_data_ = DB::table('vishwa_menu_permission')->where('user_id',$user_login_id)->where('menu_id',$postData['menu_id'])->update([
            'is_active'=> 1,
            'updated_at' => Carbon::now(),
          ]);
          if($check_data_==true){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "PERMISSON GARANTED";
          }
          return response()->json($this->jsonResponse);
        }else{
          $check_data_ = DB::table('vishwa_menu_permission')->where('user_id',$user_login_id)->where('menu_id',$postData['menu_id'])->update([
            'is_active'=> 0,
            'updated_at' => Carbon::now(),
          ]);
          if($check_data_==true){
            $this->jsonResponse['error'] = true;
            $this->jsonResponse['message'] = "PERMISSON REVOKED";
          }
          return response()->json($this->jsonResponse);
        }

      } else {
        $save_info_menu = DB::table('vishwa_menu_permission')->insert([
          'user_id' => $user_login_id,
          'menu_id' => $postData['menu_id'],
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);
        Log::info('EmployeeManagementController@modulesMenuStore new id data ==:'.print_r($save_info_menu,true));
        if($save_info_menu==true){
          $this->jsonResponse['success'] = true;
          $this->jsonResponse['message'] = "PERMISSON GARANTED";
        }
        return response()->json($this->jsonResponse);
      }
    }

    public function modulesMenuStoreClient(Request $request)
    {

      $postData = $request->all();
      Log::info('EmployeeManagementController@modulesMenuStoreClient INPUT DATA IDs==:'.print_r($postData,true));
      $employee_id=$postData['employee_id'] ;
      $client_id=$postData['client_id'] ;
      $portal_id = Auth::user()->getPortal->id;
      Log::info('employee_id SAVE DATA==:'.print_r($employee_id,true));
      Log::info('client_id SAVE DATA==:'.print_r($client_id,true));
      Log::info('portal_id SAVE DATA==:'.print_r($portal_id,true));
      //dd($portal_id,$employee_id,$client_id);
      $check_data_ =EmployeeClientPermission::where('employee_id',$employee_id)->where('client_id',$client_id)->where('portal_id',$portal_id)->first();
      Log::info('check_data_ ==:'.print_r($check_data_,true));

      if (!empty($check_data_)) {
        if ($check_data_->is_active===0) {
          $check_data_ = EmployeeClientPermission::where('id',$check_data_->id)->update([
            'is_active'=> 1,
            'updated_at' => Carbon::now(),
          ]);
          if($check_data_==true){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "PERMISSON GARANTED";
          }
          return response()->json($this->jsonResponse);
        }else{
          $check_data_ = EmployeeClientPermission::where('id',$check_data_->id)->update([
            'is_active'=> 0,
            'updated_at' => Carbon::now(),
          ]);
          if($check_data_==true){
            $this->jsonResponse['error'] = true;
            $this->jsonResponse['message'] = "PERMISSON REVOKED";
          }
          return response()->json($this->jsonResponse);
        }

      } else {
        $save_info_menu = EmployeeClientPermission::insert([
          'employee_id' => $employee_id,
          'client_id' => $client_id,
          'portal_id' => $portal_id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);
        Log::info('EmployeeManagementController@modulesMenuStoreClient new id data ==:'.print_r($save_info_menu,true));
        if($save_info_menu==true){
          $this->jsonResponse['success'] = true;
          $this->jsonResponse['message'] = "PERMISSON GARANTED";
        }
        return response()->json($this->jsonResponse);
      }
    }


    public function getdesignationJSON($id)
    {
      Log::info('id EmployeeManagementController@getdesignationJSON==:'.print_r($id,true));
      $data=DesignationMaster::where('department_id',$id)->where('status',1)->get();
      $this->jsonResponse['success'] = true;
      $this->jsonResponse['data'] = $data;
      return response()->json($this->jsonResponse);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      Log::info('edit id EmployeeManagementController@edit==:'.print_r($id,true));
      $portal=Portal::select('id')->where('user_id',Auth::id())->first();
      $get_reporting=EmployeeProfile::where('portal_id',$portal->id)->get();
       $editEmployee = EmployeeProfile::where('id',$id)->get();

      $Employee = EmployeeProfile::where('id',$id)->first();
      $abc=$Employee->reporting_id;
      $oneEmp=EmployeeProfile::where('id',$abc)->first();
      $department=DepartmentMaster::where('status',1)->get();
      $dataa=DepartmentMaster::where('id',$Employee->department_id)->where('status',1)->first();
      $desination=DesignationMaster::where('id',$Employee->designation_id)->where('status',1)->first();
      $designation=DepartmentMaster::find($desination->department_id)->department_name;
      $desig_whole=DesignationMaster::all();
      $depart_whole=DepartmentMaster::all();

      return view('portal.company.employee.edit',compact('oneEmp','editEmployee','id','department','dataa','desination','get_reporting','Employee','designation','desig_whole','depart_whole','emp_whole'));
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

//       $request->all();
      Log::info('Request data for update id EmployeeManagementController@update==:'.print_r($request->all(),true));
      $portal_id = Auth::user()->getPortal->id;
      Log::info('Portal_id id EmployeeManagementController@update==:'.print_r($portal_id,true));
      $id = $request->input('update_id');
      $phone =  $request->input('phone');
      $user_id = $request->input('user_id');
      $validator = Validator::make($request->all(),[
        'first_name' => 'bail|required|regex:/^[\pL\s\-]+$/u',
        'last_name' => 'required|regex:/^[\pL\s\-]+$/u',
        'gender'=>'required',
        'email' => 'required|email|unique:users,email,'.$user_id,
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:users,mobile_no,'.$user_id,
        'other_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
        'address' => 'required',
        'status' => 'required|max:2',
        'dob'=>'required|date',
        'department_name'=>'required',
        'designation_name'=>'required',
        'reporting_id'=>'required',
        'date_of_joining'=>'required',

      ]);
      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $user_data = User::where('id',$user_id)->update([
        'name'=> $request->input('first_name'),
        'email'=>$request->input('email'),
        'mobile_no'=> $request->input('phone'),
        'password'=>bcrypt($request->input('password')),

      ]);

        $info_save = EmployeeProfile::find($id);
        $info_save->first_name = $request->input('first_name');
        $info_save->last_name = $request->input('last_name');
        $info_save->gender = $request->input('gender');
        $info_save->dob = $request->input('dob');
        $info_save->phone = $request->input('phone');
        $info_save->other_phone = $request->input('other_phone');
        $info_save->address = $request->input('address');
        $info_save->status = $request->input('status');
        $info_save->department_id = $request->input('department_name');
        $info_save->designation_id = $request->input('designation_name');
        $info_save->date_of_joining = $request->input('date_of_joining');
        $isDirector=$request->input('isDirector');

        if($isDirector == "yes")
        {
            // return "ok";
            $info_save->reporting_id = 0;
        }
        else
        {
            $info_save->reporting_id = $request->input('reporting_id');
        }
      if($request->hasfile('profile_image'))
      {
        $file = $request->file('profile_image');
        $extension = $file->getClientOriginalExtension();
        $fileName =time().'.'.$extension;
        if(Storage::disk('uploads')->put('profile_images/'.$fileName,
          file_get_contents($request->file('profile_image')))){
            $oldfile = $info_save->profile_image;
            $info_save->profile_image= $fileName;
            File::delete(public_path('uploads/profile_image/'. $oldfile));
          $info_save->profile_image= $fileName;
      }
    }
    $info_save->save();
    $request->session()->flash('success_message','update Successfully!!');
    return redirect()->route('companyemployee');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


      Log::info('Employee Delete_id EmployeeManagementController@destroy==:'.print_r($id,true));
      $Employee = EmployeeProfile::where('id',$id)->first();
      $users = User::where('id',$Employee->user_id)->first();

      $users->delete();
      $Employee->delete();
      return redirect()->route('companyemployee')->with('success_message','Record Deleted Successfully');
      // return($users);
    }


    //Importing Data Into Excel

    public function importExportView()
    {
        return view('import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function export()
    {
       //return "abc";

        return Excel::download(new EmployeeExport, 'EmployeeProfile.xls');
//            return new EmployeeExport();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import()
    {
//        Excel::import(new EmployeeImport,request()->file('file'));

        return back();
    }

  }
