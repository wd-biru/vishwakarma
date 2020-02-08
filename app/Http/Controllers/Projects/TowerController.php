<?php

namespace App\Http\Controllers\Projects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\VishwaProjectStore;
use App\Models\DepartmentMaster;
use App\Models\DesignationMaster;
use App\Models\VishwaStoreInventoryQuantity;
use App\Models\VishwaVendorsRegistration;
use Session;
use Response;
use Validator;
use App\Models\EmployeeProfile;
use App\Models\VishwaProjectTowerDetails;
use App\Models\MasterMaterialsGroup;
use App\Models\MaterialItem;  
use App\Models\VishwaProjectTower;
use App\Models\ProjectMapping;
use App\Models\Portal;
use Carbon\Carbon;
use DB;
use App\Entities\Projects\Project;

/**
 * Project Jobs Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class TowerController extends Controller
{

	 public function index(Project $project)
    {


            
            $id = Auth::user()->id;
            $emp_id = null;
            $VishwaProjectTowerdetails =null;
            if(Auth::user()->user_type=="employee")
            {
             $result = EmployeeProfile::where('user_id',$id)->pluck('portal_id')->first();
             $portal_id = Portal::where('id',$result)->first();
             $emp_id = EmployeeProfile::where('user_id',$id)->pluck('id')->first();
            }
            else
            {
            $portal_id = Portal::where('user_id',$id)->first();
            }


             $emp_list = DB::table('vishwa_employee_project_mapping')
            ->join('vishwa_employee_profile', 'vishwa_employee_profile.id', '=','vishwa_employee_project_mapping.employee_id')
             ->where('vishwa_employee_project_mapping.portal_id',$portal_id->id)
             ->where('vishwa_employee_project_mapping.project_id',$project->id)
             ->select('vishwa_employee_profile.*')
             ->get();

             $store_detail = VishwaProjectTower::where('project_id',$project->id)->get();



            return view('projects.Tower.index',compact('project','emp_list','emp_id','store_detail','VishwaProjectTowerdetails'));

    }
 
    public function create(Project $project)
    {
            
            $id = Auth::user()->id;
            $emp_id = null;
            if(Auth::user()->user_type=="employee")
            {
             $result = EmployeeProfile::where('user_id',$id)->pluck('portal_id')->first();
             $portal_id = Portal::where('id',$result)->first();
             $emp_id = EmployeeProfile::where('user_id',$id)->pluck('id')->first();
            }
            else
            {
            $portal_id = Portal::where('user_id',$id)->first();
            }


             $emp_list = DB::table('vishwa_employee_project_mapping')
            ->join('vishwa_employee_profile', 'vishwa_employee_profile.id', '=','vishwa_employee_project_mapping.employee_id')
             ->where('vishwa_employee_project_mapping.portal_id',$portal_id->id)
             ->where('vishwa_employee_project_mapping.project_id',$project->id)
             ->select('vishwa_employee_profile.*')
             ->get();


            $store_detail = VishwaProjectTower::where('project_id',$project->id)->get();



            return view('projects.Tower.create',compact('project','emp_list','emp_id','store_detail'));

    }



    public function store(Request $request,$project_id)
    { 


        //dd($request->all());
 
          $validator = Validator::make($request->all(),[
                'tower_name' => 'required|unique:vishwa_project_tower'
            ]);
          if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

        $VishwaProjectTower = new VishwaProjectTower();
        $VishwaProjectTower->tower_name = trim($request->input('tower_name'));          
        $result = VishwaProjectTower::where('tower_name',trim($VishwaProjectTower->tower_name))->first();  
        $tower_id = $request->input('tower_keeper_id');

        if($result==null)
        {
            $tower_id = implode(',', $tower_id);
            $VishwaProjectTower->project_id =  $request->input('project_id');
            $VishwaProjectTower->tower_keeper_id = $tower_id;
            $VishwaProjectTower->save();
           
        }
        else
        {
            Session::flash('error_message', 'Tower  Already Exits !!'); 
        }

         Session::flash('success_message', 'Tower save Successfully!!');
         return redirect()->route('Tower.Index',$project_id);


    }

    public function getTowerDetails(Request $request,$project)
    { 

      
         $store_detail = 0;

            $id = Auth::user()->id;
            if(Auth::user()->user_type=="employee")
            {
             $result = EmployeeProfile::where('user_id',$id)->pluck('portal_id')->first();
             $portal_id = Portal::where('id',$result)->first();
             $emp_id = EmployeeProfile::where('user_id',$id)->pluck('id')->first();
            }
            else
            {
            $portal_id = Portal::where('user_id',$id)->first();
            }

            $tower_id = $request->input('tower_id');

             $VishwaProjectTowerdetails = VishwaProjectTowerDetails::where('portal_id',$portal_id->id)
                                                             ->where('project_id',$project)
                                                             ->where('tower_id',$tower_id)
                                                             ->get();



             $emp_list = DB::table('vishwa_employee_project_mapping')
            ->join('vishwa_employee_profile', 'vishwa_employee_profile.id', '=','vishwa_employee_project_mapping.employee_id')
             ->where('vishwa_employee_project_mapping.portal_id',$portal_id->id)
             ->where('vishwa_employee_project_mapping.project_id',$project)
             ->select('vishwa_employee_profile.*')
             ->get();

             $store_detail = VishwaProjectTower::where('project_id',$project)->get();
                     $project = Project::find($project);
           
            return view('projects.Tower.index',compact('project','emp_list','emp_id','store_detail','VishwaProjectTowerdetails'));


    }


    public function DetailStore(Request $request,$project)
    { 

            $id = Auth::user()->id;
            if(Auth::user()->user_type=="employee")
            {
             $result = EmployeeProfile::where('user_id',$id)->pluck('portal_id')->first();
             $portal_id = Portal::where('id',$result)->first();
             $emp_id = EmployeeProfile::where('user_id',$id)->pluck('id')->first();
            }
            else
            {
            $portal_id = Portal::where('user_id',$id)->first();
            }

            $VishwaProjectTowerDetails = new VishwaProjectTowerDetails();
            $VishwaProjectTowerDetails->floor_name = trim($request->input('floor_name')); 
            $VishwaProjectTowerDetails->area = $request->input('area');
            $VishwaProjectTowerDetails->tower_id = $request->input('tower_id');       
            $VishwaProjectTowerDetails->portal_id =  $portal_id->id;  
            $VishwaProjectTowerDetails->project_id = $project ;   
            $VishwaProjectTowerDetails->save();         
     

       

         Session::flash('success_message', 'Tower Details Save Successfully!!');
         return redirect()->route('Tower.Index',$project);
 
    }




}


    

     





     

