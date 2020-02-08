<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\VishwaPurchaseOrder;
use Illuminate\Http\Request;
use App\Models\VishwaUserWorkflowRoleMapping;
use App\Models\VishwaAdminConfigs;
use App\Models\VishwaStageMaster;
use App\Models\VishwaPortalConfigs;
use App\Models\DepartmentMaster;
use App\Models\EmployeeProfile;
use App\Models\VishwaWorkFlowMaster;
use App\Models\vishwaWorkflowUserMapping;
use App\Models\WorkFlowMaster;
use App\Models\WorkflowPlace;
use App\Models\WorkflowTransitions;

use App\Models\Portal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ConfigController extends Controller
{


    public function index(Request $request)
    {
         
        $VishwaAdminConfigs = VishwaAdminConfigs::all();
        return view('Config.config',compact('VishwaAdminConfigs'));
    }


     public function store(Request $request)
    {
    
        $portals = Portal::all();
 
        foreach ($portals as $key => $value) 
        {

        $VishwaPortalConfigs = new VishwaPortalConfigs();  
        $VishwaPortalConfigs->portal_id =  $value->id;
        $VishwaPortalConfigs->field_label = $request->input('field_label');
        $VishwaPortalConfigs->field_name = $request->input('field_name');
        $VishwaPortalConfigs->input_type = $request->input('input_type');
        $VishwaPortalConfigs->config_order = $request->input('config_order');
        $VishwaPortalConfigs->option = $request->input('option');
        $VishwaPortalConfigs->value = $request->input('value');     
        $VishwaPortalConfigs->save();
 
            
        }

        $VishwaAdminConfigs = new VishwaAdminConfigs();
        $VishwaAdminConfigs->field_label = $request->input('field_label');
        $VishwaAdminConfigs->field_name = $request->input('field_name');
        $VishwaAdminConfigs->input_type = $request->input('input_type');
        $VishwaAdminConfigs->option = $request->input('option');
        $VishwaAdminConfigs->value = $request->input('value');
        $VishwaAdminConfigs->config_order = $request->input('config_order');
        $VishwaAdminConfigs->category = $request->input('category');
        $VishwaAdminConfigs->save();

        $request->session()->flash('success_message','Insert Successfully!!'); 
         return redirect()->back();
    }



    public function edit($id)
    {
       
        $VishwaAdminConfigs = VishwaAdminConfigs::find($id); 
        return view('Config.config_edit',compact('VishwaAdminConfigs'));
    }


     public function ConfigPortal(Request $request)
    {


          $portal = Auth::user()->getPortal()->first();
          $portal_config =  VishwaPortalConfigs::where('portal_id',$portal->id)->orderBy('config_order','ASC')->get();
           
 
            $portal = Auth::user()->getPortal()->first();
            if($portal!=null)
            {
                $employees = EmployeeProfile::where('portal_id',$portal->id)->get();

            }
            else
            {
                $employees = EmployeeProfile::all();

            }
             $departments = DepartmentMaster::all();

           $VishwaUserWorkflowRoleMapping = DB::table('vishwa_workflow_master')
        ->join('vishwa_user_workflow_role_mapping', 'vishwa_user_workflow_role_mapping.workflowid' ,'=', 'vishwa_workflow_master.id')
        ->join('vishwa_employee_profile', 'vishwa_employee_profile.id', '=', 'vishwa_user_workflow_role_mapping.employee_Id')
        ->where('vishwa_workflow_master.portal_id',$portal->id)
        ->select('vishwa_user_workflow_role_mapping.*','vishwa_employee_profile.*')
        ->get();

                  $VishwaUserWorkflowRoleMapping = $VishwaUserWorkflowRoleMapping->groupBy('sequence');
              
                  


        return view('Config.index',compact('portal_config','employees','departments','VishwaUserWorkflowRoleMapping'));
        
    }

    public function ConfigPortalWorkFlow(Request $request)
    {
        $workFlows = WorkFlowMaster::where('portal_id',Auth::user()->getPortal->id)->get();
        return view('Config.workflowConfig',compact('workFlows'));
    }

    public function StepProcess(Request $request)
    {
        $indent_step = $request->input('indent_step');
        $config_id = $request->input('config_id');
        $portal = Auth::user()->getPortal()->first();
        VishwaPortalConfigs::where('id', $config_id)->where('portal_id', $portal->id)->update(['value' => $indent_step]);

        $work_flow_name = $request->input('work_flow_name');
        $portal = Auth::user()->getPortal()->first();
        $id = Auth::user()->id;


        $VishwaWorkFlowMaster = new VishwaWorkFlowMaster();
        $VishwaWorkFlowMaster->workflow = $work_flow_name;
        $VishwaWorkFlowMaster->no_of_steps = $indent_step;
        $VishwaWorkFlowMaster->portal_id = $portal->id;
        $VishwaWorkFlowMaster->created_by = $id;
        $VishwaWorkFlowMaster->save();

        $work_flow_id = $VishwaWorkFlowMaster->id;


        $stagemaster = VishwaStageMaster::all();
        $departments = DepartmentMaster::all();
        $user = EmployeeProfile::all();


        return view('Config.indentstage', compact('indent_step', 'stagemaster', 'departments', 'user', 'work_flow_id'));
    }

    public function GetDeptEmployee(Request $request)
    {
        $deptid = $request->input('department_id');
        $portal = Auth::user()->getPortal()->first();
        $employees = EmployeeProfile::where('department_id', $deptid)->where('portal_id', $portal->id)->get();

        return $employees;
    }


    public function StepProcessStore(Request $request)
    {
        $work_flow_id = $request->input('work_flow_id');
        $stage_action = $request->input('stage_action');
        $sequence = $request->input('sequnce');
        $indent_step = $request->input('indent_step');

        for ($i = 1; $i <= $indent_step; $i++) {
            $step_emp = $request->input('step' . $i);

            if ($step_emp != null) {
                foreach ($step_emp as $key => $value) {

                    $VishwaUserWorkflowRoleMapping = new VishwaUserWorkflowRoleMapping();
                    $VishwaUserWorkflowRoleMapping->stage_id = $stage_action[$i - 1];
                    $stagemaster = VishwaStageMaster::find($stage_action[$i - 1]);
                    $VishwaUserWorkflowRoleMapping->stage_name = $stagemaster->name;
                    $VishwaUserWorkflowRoleMapping->sequence = $sequence[$i - 1];
                    $VishwaUserWorkflowRoleMapping->workflowid = $work_flow_id;
                    $VishwaWorkFlowMaster = VishwaWorkFlowMaster::find($work_flow_id);
                    $VishwaUserWorkflowRoleMapping->workflowname = $VishwaWorkFlowMaster->workflow;
                    $VishwaUserWorkflowRoleMapping->employee_Id = $value;
                    $employees_dept = EmployeeProfile::where('id', $value)->first();
                    $VishwaUserWorkflowRoleMapping->departmentId = $employees_dept->department_id;
                    $VishwaUserWorkflowRoleMapping->save();

                }
            }
        }

        $request->session()->flash('success_message', 'Insert Successfully!!');
        return redirect()->route('Config.portal');
    }



    public function Update(Request $request)
    {
        $id = $request->input('id');
       
        $VishwaAdminConfigs = VishwaAdminConfigs::find($id);
        $VishwaAdminConfigs->field_label = $request->input('field_label');
        $VishwaAdminConfigs->field_name = $request->input('field_name');
        $VishwaAdminConfigs->input_type = $request->input('input_type');
        $VishwaAdminConfigs->option = $request->input('option');
        $VishwaAdminConfigs->value = $request->input('value');
        $VishwaAdminConfigs->config_order = $request->input('config_order');
        $VishwaAdminConfigs->category = $request->input('category');
        $VishwaAdminConfigs->save(); 
       $request->session()->flash('success_message','Update Successfully!!');
         return redirect()->route('admin.config');


    }

    public function workflowAdd(Request $request)
    {  

        $name = $request->input('name');
        $portal_id = Auth::user()->getPortal->id;
        $WorkFlow = WorkFlowMaster::where('name',$name)->first();
        if($WorkFlow != null){ 
            $request->session()->flash('error_message',$name.' Config WorkFlow Already Exist'); 
            return back();
        } 
        $WorkFlow = WorkFlowMaster::insert(['name'=>$name,'portal_id'=>$portal_id]); 
        $request->session()->flash('success_message','This Config Added To WorkFlow Successfully!!'); 
        return back();
    }

    public function workflowEdit(Request $request, $name)
    {
        $WorkFlow = WorkflowMaster::where('name', $name)->first();
        $place = [];
        $transitions = [];
        foreach ($WorkFlow->getPlace as $key => $value) {
            $place[] = $value->place_name;
        }
        foreach ($WorkFlow->getTransaction as $key => $value) {
            $transitions[$value->trans_name]['from'] = $value->getPlaceFrom->place_name;
            $transitions[$value->trans_name]['to'] = $value->getPlaceTo->place_name;
        }
        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        $emp_list = EmployeeProfile::where('portal_id', $portal_id)->get();

        $emp_mapping = vishwaWorkflowUserMapping::where('portal_id', $portal_id)->where('workflow_id', $WorkFlow->id)->get();


        $WorkFlowDaigram = [$WorkFlow->name => [
            'type' => 'workflow', // or 'state_machine'
            'marking_store' => [
                'type' => 'single_state',
                'arguments' => [$WorkFlow->arguments] // currentPlace
            ],
            'supports' => [$WorkFlow->supports], //"APP\MODELS\NAME"
            'places' => $place,
            'transitions' => $transitions,
        ]
        ];



        if ($WorkFlow == null) {
            $request->session()->flash('error_message', 'This Config WorkFlow Not Found, please contact to admin.');
            return back();
        }
        return view('Config.workflow.edit', compact('vendorId','WorkFlow', 'WorkFlowDaigram', 'emp_list', 'emp_mapping'));
    }

    public function workflowUpdate(Request $request,$id)
    {  


      //  dd($request->all());
        
        $WorkFlow = WorkFlowMaster::where('id',$id)->first(); 
        if($WorkFlow == null){
            $request->session()->flash('error_message','This Config WorkFlow Not Found, please contact to admin.'); 
            return back();
        }

        if($request->has('place_update_id')){
            foreach ($request->input('place_update_id') as $key => $value) {  
                $place_name = $request->input('place_name');              
                $place =  WorkflowPlace::find($value);
                $place->place_name =  $place_name[$key];
                $place->workflow_id =  $WorkFlow->id;
                $place->save(); 
            }
            $request->session()->flash('success_message','Places Update Successfully.');             
        }elseif($request->has('trans_update_id')){
            foreach ($request->input('trans_update_id') as $key => $value) {  
                $trans_name = $request->input('trans_name');              
                $trans_from_id = $request->input('trans_from_id');              
                $trans_to_id = $request->input('trans_to_id');              
                $trans =  WorkflowTransitions::find($value);
                $trans->trans_name =  $trans_name[$key];
                $trans->workflow_id =  $WorkFlow->id;
                $trans->place_from_id =  $trans_from_id[$key];
                $trans->place_to_id =  $trans_to_id[$key];
                $trans->save(); 
            }
            $request->session()->flash('success_message','Transitions Update Successfully.');             
        }
        elseif($request->has('trans_update_id')){
            foreach ($request->input('trans_update_id') as $key => $value) {  
                $trans_name = $request->input('trans_name');              
                $trans_from_id = $request->input('trans_from_id');              
                $trans_to_id = $request->input('trans_to_id');              
                $trans =  WorkflowTransitions::find($value);
                $trans->trans_name =  $trans_name[$key];
                $trans->workflow_id =  $WorkFlow->id;
                $trans->place_from_id =  $trans_from_id[$key];
                $trans->place_to_id =  $trans_to_id[$key];
                $trans->save(); 
            }
            $request->session()->flash('success_message','Transitions Update Successfully.');             
        }elseif($request->has('emp')){


                  if(Auth::user()->user_type=="portal")
                    {       
                         $portal_id = Auth::user()->getPortal->id;
                    }


                $trans_id = $request->input('trans_id'); 
                $trans_name = $request->input('trans_name');             
 
                $input_value = '';

                vishwaWorkflowUserMapping::where('portal_id',$portal_id)->where('workflow_id',$WorkFlow->id)->delete();
   
                    // dd($request->all());

            foreach($request->input('trans_id') as $key => $value) 
            {  
                $input_value =  $key.'emp';
                if($request->input($input_value)){
                    foreach($request->input($input_value) as $input_key => $input_value){
                        $vishwaWorkflowUserMapping = new vishwaWorkflowUserMapping();
                        $vishwaWorkflowUserMapping->portal_id =  $portal_id;
                        $vishwaWorkflowUserMapping->workflow_id =  $WorkFlow->id;
                        $vishwaWorkflowUserMapping->Workflow_place_id = $trans_name[$key];
                        $vishwaWorkflowUserMapping->emp_id =  $input_value;
                        $vishwaWorkflowUserMapping->save();
                    }
                } 
            }
            $request->session()->flash('success_message','Add Employee Successfully.');             
        }elseif(!$request->has('place_update_id') && !$request->has('trans_update_id') && !$request->has('trans_name')){
            foreach ($request->input('place_name') as $key => $value) {
                $place = new WorkflowPlace();
                $place->place_name =  $value;
                $place->workflow_id =  $WorkFlow->id;
                $place->save(); 
            }
            $request->session()->flash('success_message','Places Add Successfully.');          
        }else{
            foreach ($request->input('trans_name') as $key => $value) {
                $trans_from_id = $request->input('trans_from_id');              
                $trans_to_id = $request->input('trans_to_id');    
                $trans = new WorkflowTransitions();
                $trans->trans_name =  $value;
                $trans->workflow_id =  $WorkFlow->id;
                $trans->place_from_id =  $trans_from_id[$key];
                $trans->place_to_id =  $trans_to_id[$key];
                $trans->save(); 
            }
            $request->session()->flash('success_message','Transitions Add Successfully.'); 
                 
        } 

        return redirect()->route('workflow.edit',$WorkFlow->name); 
    } 

     
    }

 
