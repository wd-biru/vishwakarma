<?php

namespace App\Http\Controllers\MaterialRequest;

use App\Models\IndentMaster;
use App\Models\IndentStatus;
use App\Models\MaterialRequestFlow;
use App\Models\MaterialRequestItem;
use App\Models\MaterialRequestStatus;
use App\Models\MaterialRequestTrack;
use App\Models\WorkFlowMaster;
use App\Models\WorkflowPlace;
use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Projects\Project;
use App\Models\VishwaProjectStore;
use DB;
use Auth;

class MaterialRequestController extends Controller
{
    public function index(Project $project)
    {
        $user_type = Auth::user()->user_type;
        $portal_id = '';
        if ($user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        } elseif ($user_type == "employee") {
            $portal_id = Auth::user()->getEmp->getUserPortal->id;

        }

        $mrRequests=MaterialRequestFlow::where('portal_id', $portal_id)
            ->join('vishwa_project_tower','vishwa_material_request_flow.tower_id','vishwa_project_tower.id')
//            ->where('vishwa_project_tower.project_id',$project->id)
            ->get();

//dd($mrRequests,$project);

        return view('MaterialRequest.index', compact('project','mrRequests'));

    }

    public function create()
    {
        $user_type = Auth::user()->user_type;
        $portal_id = '';
        if ($user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        } elseif ($user_type == "employee") {
            $portal_id = Auth::user()->getEmp->getUserPortal->id;

        }
        $projects = Project::where('portal_id', $portal_id)->get();
        return view('MaterialRequest.create', compact('projects', 'store_names'));

    }

    public function getStoreNameByProject(Request $request)
    {

        $project_stores = DB::table("vishwa_project_store")
            ->where("project_id", $request->input('project_id'))
            ->get();

        $project_towers = DB::table("vishwa_project_tower")
            ->where("project_id", $request->input('project_id'))
            ->get();
        return response()->json(array('project' => $project_stores, 'tower' => $project_towers));
    }

//

    public function fetch(Request $request)
    {


        $query = strtolower($request->get('query'));

        $data = DB::table('vishwa_materials_item')->join('vishwa_unit_masters', 'vishwa_materials_item.material_unit', 'vishwa_unit_masters.id')
            ->where(strtolower('material_name'), 'LIKE', "%{$query}%")
            ->select('vishwa_materials_item.id as item_id','vishwa_materials_item.*','vishwa_unit_masters.material_unit')
            ->get();



        $output = '<ul class="dropdown-menu" style="display:block !important; position:relative !important;">';
        foreach ($data as $row) {

            $output .= '<li><a href="#" id="item_' . $row->item_id . '" data-id="' . $row->item_id . '" onclick="fadeout(this)" data-name="' . $row->material_name . '" data-unit="' . $row->material_unit . '">' . $row->material_name.'<strong>('.$row->material_unit.')</strong>' . '</a></li>';
        }
        $output .= '</ul>';

        echo $output;

//    	return response()->json($data);
    }

    public function materialRequestStore(Request $request)
    {


        $user_type = Auth::user()->user_type;
        if ($user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
            $emp_id = '';
        } elseif ($user_type == "employee") {
            $portal_id = Auth::user()->getEmp->getUserPortal->id;
            $emp_id = Auth::user()->getPortal->id;

        }


        $material_unit = $request->input('material_unit');
        $material_id = $request->input('material_id');
        $material_remarks=$request->input('material_remarks');
        $material_qty=$request->input('material_qty');
        $project_id = $request->input('project_id');
        $store_id = $request->input('store_id');
        $tower_id = $request->input('tower_id');

        $mr_incre = DB::table('vishwa_material_request_flow')->orderByDesc('id')->pluck('id')->first();


        if (!$mr_incre) {
            $mrIncrement = 0;
        } else {
            $mrIncrement = intval($mr_incre);
        }

        $mr_no= "MR_NO" . str_pad($mrIncrement + 1, 7, '0', STR_PAD_LEFT);




        DB::beginTransaction();

        try {

            $addStatus = new MaterialRequestStatus();
            $addStatus->mreq_no = $mr_no;
            $addStatus->status = 1;
            $addStatus->remark = "Material Request Create";
            $addStatus->changed_by = Auth::user()->id;
            $addStatus->changed_date = date('Y-m-d');
            $addStatus->is_current_status = 1;
            $addStatus->save();

            $mat_req_flow = new MaterialRequestFlow();
            $mat_req_flow->portal_id = $portal_id;
            $mat_req_flow->project_id = $project_id;
            $mat_req_flow->store_id =$store_id;
            $mat_req_flow->tower_id = $tower_id;
            $mat_req_flow->emp_id = $emp_id;
            $mat_req_flow->mreq_no = $mr_no;
            $mat_req_flow->status = 1;
            $mat_req_flow->created_date = date('Y-m-d H:i:s');
            $mat_req_flow->save();


            $workflow = Controller::getMReqWorkFlow($mat_req_flow, 'MRequest Flow');
            $transitions = $workflow->getEnabledTransitions($mat_req_flow);
            $workflow->apply($mat_req_flow, 'to_create');

            if ($mat_req_flow->save()) {
                foreach ($material_id as $key => $mat_id) {
                    $mat_req_item = new MaterialRequestItem();
                    $mat_req_item->mreq_no = $mr_no;
                    $mat_req_item->item_unit = $material_unit[$key];
                    $mat_req_item->item_id = $material_id[$key];
                    $mat_req_item->item_qty = $material_qty[$key];
                    $mat_req_item->remarks = $material_remarks[$key];
                    $mat_req_item->save();
                }
            }

            DB::commit();

            return redirect()->route('materialRequest.index');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('materialRequest.index');
        }



    }

    public function show($id)
    {
        $mr_no=base64_decode($id);

        $mr_items=MaterialRequestItem::where('mreq_no',$mr_no)
            ->join('vishwa_materials_item','vishwa_material_request_item.item_id','vishwa_materials_item.id')
            ->get();




        return view('MaterialRequest.material_request_show',compact('mr_items','mr_no'));
    }


    public function changeRequestStatus(Project $project,Request $request)
    {
        $indent = $request->input('request_no');
        $requestData = MaterialRequestFlow::where('id',$indent)->first();
        $workflow = Controller::getMReqWorkFlow($requestData,'MRequest Flow');



        $workFlowName=WorkFlowMaster::where('name','MRequest Flow')->first();
        $workflowId=WorkflowPlace::where('workflow_id',$workFlowName->id)->orderBy('id', 'DESC')->first();
        $workflowRejectId=WorkflowPlace::where('workflow_id',$workFlowName->id)->first();



        $status = ($request->input('button')=="Rejection") ? 0 : 1 ;

        $requestData->insertStatus($requestData,$request->input('remark'),$status);
        if($request->input('button')!="Rejection"){
            if ($workflowId->place_name == $requestData->current_status) {
                $add = MaterialRequestFlow::where('id', $requestData->id)->where('mreq_no', $requestData->mreq_no)->update(['is_active' => 1, 'current_status' => Null]);

            } else {
                $requestData->toChangeStage($workflow, $requestData);
            }
        }else{
            $add = MaterialRequestFlow::where('id',$requestData->id)->where('mreq_no',$requestData->mreq_no)->update(['is_active'=> 0,'current_status'=>$workflowRejectId->place_name]);
        }


        return redirect()->route('materialRequest.index');
    }

    public function approvalShow(Project $project, Request $request,$id)
    {

//        $unique_no = $request->input('unique_no');
        $post = MaterialRequestFlow::where('mreq_no',$id)->first();


        $workflow = Controller::getWorkFlow($post,'MRequest Flow');
        $workFlowName=WorkFlowMaster::where('name','MRequest Flow')->first();
        $workflowId=WorkflowPlace::where('workflow_id',$workFlowName->id)->orderBy('id', 'DESC')->first();

        if($workflow==false){
            $error = "Work Flow Not Completed" ;
            return view('home',compact("error"));
        }
        if(Auth::user()->user_type == 'employee'){

            $indent = MaterialRequestFlow::Join('vishwa_material_request_item', 'vishwa_material_request_flow.mreq_no', '=', 'vishwa_material_request_item.mreq_no')
                ->Join('vishwa_employee_profile', 'vishwa_material_request_flow.emp_id', '=', 'vishwa_employee_profile.id')
                ->Join('vishwa_materials_item', 'vishwa_material_request_item.item_id', '=', 'vishwa_materials_item.id')
                ->Join('vishwa_projects', 'vishwa_material_request_flow.project_id', '=', 'vishwa_projects.id')
                ->select('vishwa_material_request_flow.*','vishwa_material_request_item.*','vishwa_employee_profile.first_name as user_name','vishwa_projects.name as project_name','vishwa_materials_item.material_name')
                ->where('vishwa_material_request_flow.mreq_no', $id)
                ->get();
        }else{

            $indent = MaterialRequestFlow::Join('vishwa_material_request_item', 'vishwa_material_request_flow.mreq_no', '=', 'vishwa_material_request_item.mreq_no')
                ->Join('vishwa_employee_profile', 'vishwa_material_request_flow.emp_id', '=', 'vishwa_employee_profile.id')
                ->Join('vishwa_materials_item', 'vishwa_material_request_item.item_id', '=', 'vishwa_materials_item.id')
                ->Join('vishwa_projects', 'vishwa_material_request_flow.project_id', '=', 'vishwa_projects.id')
                ->select('vishwa_material_request_flow.*','vishwa_material_request_item.*','vishwa_employee_profile.first_name as user_name','vishwa_projects.name as project_name','vishwa_materials_item.material_name')
                ->where('vishwa_material_request_flow.mreq_no', $id)
                ->get();
        }

//        $vendor_indent_mapping = DB::table('vishwa_vendor_indent_mapping')
//            ->Join('vishwa_vendor_master', 'vishwa_vendor_indent_mapping.vendor_id','=','vishwa_vendor_master.id')
//            ->select('vishwa_vendor_master.*','vishwa_vendor_indent_mapping.*')
//            ->where('vishwa_vendor_indent_mapping.indent_id',$unique_no)
//            ->get();

        $company_name = null;
        $vendor_mapping_detail = MaterialRequestFlow::where('mreq_no',$id)->first();
        $indentStatus = MaterialRequestStatus::where('mreq_no',$id)->get();




        //dd($indent ,$vendor_indent_mapping ,$indentStatus ,$vendor_mapping_detail);

        //        dd($post);
        //
        //        if ($post->current_status==Null) {
        //
        //            $purchaseOrderMaster=new VishwaPurchaseOrder();
        //            $purchaseOrderMaster->portal_id=Auth::user()->getPortal->id;
        //            $purchaseOrderMaster->indent_id=$post->indent_id;
        //            $purchaseOrderMaster->save();
        //
        //            $purchaseData=VishwaPurchaseOrder::where('indent_id',$post->indent_id)->first();
        //
        //            $workflow = Controller::getPoWorkFlow($purchaseData, 'PO Flow');
        //            if($workflow==false){
        //                $error = "Work Flow Not Completed" ;
        //                return view('home',compact("error"));
        //            }
        //            $transitions = $workflow->getEnabledTransitions($purchaseData);
        //            $workflow->apply($purchaseData, 'To_Get_PO');
        //
        //
        //        }

//        if ($vendor_indent_mapping!=null)
//        {
//            foreach ($vendor_indent_mapping as $key => $value)
//            {
//
//                $company_name[] = $value->company_name;
//            }
//        }

        // dd($unique_no ,$indent , $vendor_indent_mapping);
//        dd($project->id);

        return view('MaterialRequest.materialRequestApproval', compact('project','indentStatus', 'indent','vendor_mapping_detail','company_name','unique_no'));
    }


}
