<?php

namespace App\Http\Controllers\Projects;
use App\Models\IndentItem;
use App\Models\IndentMaster;
use App\Models\WorkFlowMaster;
use App\Models\WorkflowPlace;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MaterialItem;
use App\Models\VishwaIndentVendorsPrice;
use App\Entities\Projects\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\VishwaVendorsRegistration;
use App\Models\VishwaStoreMapping;
use App\Models\VishwaVendorIndentMapping;
use App\Models\VishwaPurchaseOrder;  
use App\Models\VishwaProjectStore;
use App\Models\vishwaWorkflowUserMapping;
use App\Models\EmployeeProfile;
use App\Models\IndentStatus;
use App\Models\Portal;
use Validator;
use Carbon\Carbon;
use Log;
use App\Models\MasterMaterialsGroup;
use PDF;
use Session;


class IndentResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     */


    public function index(Project $project)
    {

        $pro_id=$project->id;
        $record = IndentMaster::Join('users', 'vishwa_indent_masters.created_by', '=', 'users.id')
            ->Join('vishwa_projects', 'vishwa_indent_masters.project_id', '=', 'vishwa_projects.id')
            ->where('vishwa_indent_masters.project_id', $pro_id)
            ->select('vishwa_indent_masters.*','users.name as user_name')
            ->orderByDesc('id')
            ->get();
        $VishwaVendorIndent = VishwaVendorIndentMapping::where('project_id',$project->id)
                                ->where('portal_id',Auth::user()->getPortal->id) 
                                ->get();  
       $vendor_reg =VishwaVendorsRegistration::join('vishwa_portal_vendor_mapping', 'vishwa_vendor_master.id','=','vishwa_portal_vendor_mapping.vendor_id')
                        ->where('vishwa_portal_vendor_mapping.portal_id','=',Auth::user()->getPortal->id)
                        ->select('vishwa_vendor_master.*','vishwa_portal_vendor_mapping.portal_id as PortalId')
                        ->get();

        return view('projects.estimate.index', compact('project', 'record','vendor_reg','VishwaVendorIndent'));
    }



    public function Addindent(Project $project, Request $request)
    {

        $material_group = MasterMaterialsGroup::all();

        if(Auth::user()->user_type=="employee"){

            $store_detail = VishwaProjectStore::join('vishwa_store_employee_mapping', 'vishwa_project_store.id','vishwa_store_employee_mapping.store_id')
                ->where('vishwa_project_store.project_id', $project->id)
                ->where('vishwa_store_employee_mapping.store_keeper_id', Auth::user()->getEmp->id)
                ->get();
        }else{

            $store_detail = VishwaProjectStore::where('project_id',$project->id)->get();
        }



        return view('projects.estimate.addindent', compact('project', 'material_group','store_detail'));
    }


    public function delete(Project $project,$item)
    {

        IndentItem::where('item_id',$item)->delete();        
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project,Request $request)
    {

        DB::beginTransaction();
        try {

            $created_by = Auth::user()->id;
            $project_id = $project->id;
            $store_id = $request->input('store_id');
            $group_id = $request->input('group_id');
            $group_id_arr = $request->input('group_id');
            $grp_arr = count($group_id_arr);
            $qty = $request->input('qty');
            $item_name = $request->input('material_name');
            $item_id = $request->input('item_id');
            $item_unit = $request->input('material_unit');
            $remarks = $request->input('remarks');


            $idm = DB::table('vishwa_indent_masters')->orderByDesc('id')->pluck('id')->first();


            if (!$idm) {
                $indentIncrement = 0;
            } else {
                $indentIncrement = intval($idm);
            }
            $unique_no_pad = "IND" . str_pad($indentIncrement + 1, 7, '0', STR_PAD_LEFT);

            $addStatus = new IndentStatus();
            $addStatus->indent_id = $unique_no_pad;
            $addStatus->status = 1;
            $addStatus->remark = "Indent Create";
            $addStatus->changed_by = Auth::user()->id;
            $addStatus->changed_date = date('Y-m-d');
            $addStatus->is_current_status = 1;
            $addStatus->save();

            $indentMaster = new IndentMaster();
            $indentMaster->indent_id = $unique_no_pad;
            $indentMaster->created_by = $created_by;
            $indentMaster->store_id = $store_id;
            $indentMaster->project_id = $project_id;
            $indentMaster->save();

            $workflow = Controller::getWorkFlow($indentMaster, 'Indent Flow');
            $transitions = $workflow->getEnabledTransitions($indentMaster);
            $workflow->apply($indentMaster, 'To_create');

            if ($indentMaster->save()) {
                for ($i = 0; $i < $grp_arr; $i++) {
                    $indentItem = new IndentItem();
                    $indentItem->indent_id = $unique_no_pad;
                    $indentItem->item_id = $item_id[$i];
                    $indentItem->group_id = $group_id[$i];
                    $indentItem->store_id = $store_id;
                    $indentItem->unit = $item_unit[$i];
                    $indentItem->remarks = $remarks[$i];
                    $indentItem->qty = $qty[$i];
                    $indentItem->save();
                }


            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

        }


        return redirect()->route('indentResorurce.index', $project);

    }



        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateIndent(Project $project,Request $request)
    {

     

        // DB::beginTransaction();
        // try 
        // {

        $created_by=Auth::user()->id;
        $project_id=$project->id;
        $updated_id=$request->input('updated_id');
        $indent_id=$request->input('indent_id');
        $store_id=$request->input('store_id');
        $group_id=$request->input('group_id');
        $group_id_arr=$request->input('group_id');
        $grp_arr=count($group_id_arr);
        $qty=$request->input('qty');
        $item_name=$request->input('material_name');
        $item_id=$request->input('item_id');
        $item_unit=$request->input('material_unit');
        $remarks=$request->input('remarks');

        $indentMaster = IndentMaster::find($updated_id);
        $indentMaster->created_by = $created_by;
        $indentMaster->store_id =$store_id;
        $indentMaster->is_active =1;
        $indentMaster->save();

        $workflow = Controller::getWorkFlow($indentMaster,'indent'); 
        $transitions = $workflow->getEnabledTransitions($indentMaster); 
        $workflow->apply($indentMaster, 'To_Create');

        $indentMaster->insertStatus($indentMaster,$remark = "Indent Modified After Rejection",$status = 1);
        if($indentMaster->save()){
            foreach ($item_id as $key => $value) {
                if($qty[$key] != null ){
                    $update = IndentItem::where('item_id',$value)->where('indent_id',$indent_id)->delete();
                    $indentItem = new IndentItem();
                    $indentItem->item_id=$value;
                    $indentItem->indent_id=$indent_id;
                    $indentItem->group_id=$group_id[$key];
                    $indentItem->store_id=$store_id;
                    $indentItem->unit=$item_unit[$key];
                    $indentItem->remarks=$remarks[$key];
                    $indentItem->qty=$qty[$key]; 
                    $indentItem->save();
              }

              
            }
        }  

        // DB::commit();
        //     } catch (\Exception $e) {
        //         DB::rollback();
        //     } 
        
        return redirect()->route('indentResorurce.index',$project);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getQuoteStore(Project $project,Request $request)
    {
       
          $portal_id = Auth::user()->getPortal->id;
          $project_id = $request->input('project_id');
          $indent_id = $request->input('indent_id'); 
          $created_by = $request->input('created_by');
          $created_date = $request->input('created_date');
          $vendor_id = $request->input('vendor_id');

          $VishwaVendorIndent = VishwaVendorIndentMapping::where('project_id',$project_id)
                                ->where('portal_id',$portal_id)
                                ->where('indent_id',$indent_id)
                                ->get(); 

        if($VishwaVendorIndent!=null)
        {
            foreach ($VishwaVendorIndent as $key => $value) 
              {
                $VishwaVendorIndent = VishwaVendorIndentMapping::where('id',$value->id)->delete(); 
              }

        }    

        foreach ($vendor_id as  $value) 
           {
              $VishwaProjectStore = new VishwaVendorIndentMapping();
              $VishwaProjectStore->portal_id  =  $portal_id;
              $VishwaProjectStore->project_id =  $project_id;
              $VishwaProjectStore->indent_id  =  $indent_id;
              $VishwaProjectStore->created_by =  $created_by;
              $VishwaProjectStore->created_date = $created_date;
              $VishwaProjectStore->vendor_id  =  $value;
              $VishwaProjectStore->save();
                
           }
            $request->session()->flash('success_message','Indent shared with selected Vendor.');

             return redirect()->route('indentResorurce.index',$project_id);
          
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project,$indent)
    { 

      $material_group = MasterMaterialsGroup::all();
      if(Auth::user()->user_type=="employee"){ 
          $store_detail = VishwaStoreMapping::where('project_id',$project->id)->where('store_keeper_id',Auth::user()->getEmp->id)->get();
      }else{ 
          $store_detail = VishwaProjectStore::where('project_id',$project->id)->get();
      } 

      $editIndent = IndentMaster::where('indent_id',$indent)->first();

      return view('projects.estimate.editindent', compact('project', 'material_group','store_detail','editIndent'));         
    }


    public function Getindentdata(Project $project, Request $request)
    {

        $unique_no = $request->input('unique_no');
        $post = IndentMaster::where('indent_id',$unique_no)->first();


        $workflow = Controller::getWorkFlow($post,'Indent Flow');
        $workFlowName=WorkFlowMaster::where('name','Indent Flow')->first();
        $workflowId=WorkflowPlace::where('workflow_id',$workFlowName->id)->orderBy('id', 'DESC')->first();

        if($workflow==false){ 
           $error = "Work Flow Not Completed" ;
           return view('home',compact("error"));
        }
        if(Auth::user()->user_type == 'employee'){

        $indent = IndentMaster::Join('vishwa_indent_items', 'vishwa_indent_masters.indent_id', '=', 'vishwa_indent_items.indent_id')
                              ->Join('users', 'vishwa_indent_masters.created_by', '=', 'users.id')
                              ->Join('vishwa_materials_item', 'vishwa_indent_items.item_id', '=', 'vishwa_materials_item.id')
                              ->Join('vishwa_projects', 'vishwa_indent_masters.project_id', '=', 'vishwa_projects.id')
                              ->select('vishwa_indent_masters.*','vishwa_indent_items.*','users.name as user_name','vishwa_projects.name as project_name','vishwa_materials_item.material_name')
                              ->where('vishwa_indent_masters.indent_id', $unique_no)
                              ->get();
      }else{

        $indent = IndentMaster::Join('vishwa_indent_items', 'vishwa_indent_masters.indent_id', '=', 'vishwa_indent_items.indent_id')
                    ->Join('users', 'vishwa_indent_masters.created_by', '=', 'users.id')
                    ->Join('vishwa_materials_item', 'vishwa_indent_items.item_id', '=', 'vishwa_materials_item.id')
                    ->Join('vishwa_projects', 'vishwa_indent_masters.project_id', '=', 'vishwa_projects.id')
                    ->select('vishwa_indent_masters.*','vishwa_indent_items.*','users.name as user_name','vishwa_projects.name as project_name','vishwa_materials_item.material_name')
                    ->where('vishwa_indent_masters.indent_id', $unique_no)
                    ->get();
          }

        $vendor_indent_mapping = DB::table('vishwa_vendor_indent_mapping')
            ->Join('vishwa_vendor_master', 'vishwa_vendor_indent_mapping.vendor_id','=','vishwa_vendor_master.id')
            ->select('vishwa_vendor_master.*','vishwa_vendor_indent_mapping.*')
            ->where('vishwa_vendor_indent_mapping.indent_id',$unique_no)
            ->get();

        $company_name = null;
        $vendor_mapping_detail = IndentMaster::where('indent_id',$unique_no)->first();
        $indentStatus = IndentStatus::where('indent_id',$unique_no)->get();

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

        if ($vendor_indent_mapping!=null)
         {
                 foreach ($vendor_indent_mapping as $key => $value)
                 {
                 
                     $company_name[] = $value->company_name;
                }
         }

            // dd($unique_no ,$indent , $vendor_indent_mapping);

        return view('projects.estimate.indentshow', compact('project','indentStatus', 'indent','vendor_mapping_detail','company_name','unique_no'));
    }



    public function getindentPriceList(Project $project,Request $request)
    {  


        $indent_id = $request->input('unique_no');
        $indent = IndentMaster::Join('vishwa_indent_items', 'vishwa_indent_masters.indent_id', 'vishwa_indent_items.indent_id')
            ->Join('users', 'vishwa_indent_masters.created_by', '=', 'users.id')
            ->Join('vishwa_materials_item', 'vishwa_indent_items.item_id', 'vishwa_materials_item.id')
            ->Join('vishwa_projects', 'vishwa_indent_masters.project_id','vishwa_projects.id')
//            ->Join('vishwa_portals', 'users.id', 'vishwa_portals.user_id')
            ->select('vishwa_indent_masters.*','vishwa_indent_items.*','users.name as user_name','vishwa_projects.name as project_name',
                'vishwa_materials_item.material_name')
            ->where('vishwa_indent_masters.indent_id', $indent_id)
            ->get();

//            dd($indent);
        $vendor_indent_mapping = DB::table('vishwa_vendor_indent_mapping')
            ->Join('vishwa_vendor_master', 'vishwa_vendor_indent_mapping.vendor_id','=','vishwa_vendor_master.id')
            ->select('vishwa_vendor_master.*')
            ->where('vishwa_vendor_indent_mapping.indent_id',$indent_id)
            ->get(); 




       $chkPurchaseOrder = VishwaPurchaseOrder::where('indent_id', $indent_id)
            ->where('project_id', $project->id)->get();

      

            // dd($indent_id , $indent ,$vendor_indent_mapping,$chkPurchaseOrder); 

        return view('projects.estimate.indentPriceShow', compact('indent','indent_id','project','vendor_indent_mapping','company_name','chkPurchaseOrder'));
    }


    public function storePurchase(Project $project, Request $request)
    {



        $indent_id = $request->input('indent_id');
        $emp_id = Auth::user()->getPortal->id;
        $item_id = $request->input('item_id');
        $unit = $request->input('unit');
        $qty = $request->input('qty');
        $store_id = $request->input('store_id');
        $voucher_no = $request->input('voucher_no');
        $purchase_order_no = $request->input('purchase_order_no');
        $vendor_id = $request->input('vendor_id');
        $date = $request->input('date');


        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
            $emp_id=Auth::user()->id;
        }
        else
        {
            $emp_id = Auth::user()->getPortal->id;
            $portal_id= Auth::user()->getEmp->getUserPortal->id;
        }


        $total_amount = 0;
        $amount = 0;
        $tax = 0;
        $final_amount = 0;
        $load_unload = 0;
        $kata_parchi = 0;
        $fright_charge = 0;
        $tax = 0;
        foreach ($item_id as $key => $val) {

            $item_price = VishwaIndentVendorsPrice::where('vishwa_indent_vendor_price.indent_id', $indent_id)
                ->where('vishwa_indent_vendor_price.vendor_id', $vendor_id)
                ->where('vishwa_indent_vendor_price.item_id', $val)
                ->first();

            if ($item_price != null) {

                $amount = $qty[$key] * $item_price->price;
                $final_amount = $final_amount + $amount;
                $fright_charge = $item_price->freight + ($item_price->freight * 18) / 100;
                $load_unload = 0 + $item_price->loading;
                $kata_parchi = 0 + $item_price->kpcharges;
                $tax = $tax + (($amount * $item_price->tax_rate) / 100);

            }


        }

        $total_amount = $final_amount + $fright_charge + $load_unload + $kata_parchi + $tax;


        foreach ($item_id as $key => $value) {
            if ($vendor_id != null) {

                if($value==null) {
                    $update = VishwaPurchaseOrder::where('indent_id', $indent_id)->delete();
                }
                else
                {
                    $update = VishwaPurchaseOrder::where('item_id', $value)->where('vendor_id', $vendor_id)->where('indent_id', $indent_id)->delete();
                }


                $VishwaIndentData = new VishwaPurchaseOrder();
                $VishwaIndentData->vendor_id = $vendor_id;
                $VishwaIndentData->portal_id = $portal_id;
                $VishwaIndentData->emp_id = $emp_id;
                $VishwaIndentData->project_id = $project->id;
                $VishwaIndentData->indent_id = $indent_id;
                $VishwaIndentData->total_amount = $total_amount;
                $VishwaIndentData->item_id = $value;
                $VishwaIndentData->voucher_no = $voucher_no;
                $VishwaIndentData->store_id = $store_id;
                $VishwaIndentData->unit = $unit[$key];
                $VishwaIndentData->qty = $qty[$key];
                $_dates = new Carbon(str_replace('/', '-', $date));
                $date = date('Y-m-d', strtotime($_dates));
                $VishwaIndentData->date = $date;
                $VishwaIndentData->purchase_order_no = $purchase_order_no;
                $VishwaIndentData->save();

            }  # code...
        }


        $purchaseData=VishwaPurchaseOrder::where('indent_id',$indent_id)->first();
        $workflow = Controller::getPoWorkFlow($purchaseData, 'Po Flow');
        $purchaseData->toCheckStage($workflow, $purchaseData);
        $purchaseData->toChangeStage($workflow, $purchaseData);


//        $indent = $request->input('indent_no');
//        $indentdata = IndentMaster::where('id',$indent)->first();
//
//        $workflow = Controller::getPoWorkFlow($indentdata,'PO Flow');
//
//        $purchaseData=VishwaPurchaseOrder::where('indent_id',$indentdata->indent_id)->first();
//
//        $workFlowName=WorkFlowMaster::where('name','Indent Flow')->first();
//        $workflowId=WorkflowPlace::where('workflow_id',$workFlowName->id)->orderBy('id', 'DESC')->first();
//        $workflowRejectId=WorkflowPlace::where('workflow_id',$workFlowName->id)->first();
//
//        $status = ($request->input('button')=="Rejection") ? 0 : 1 ;
//        $purchaseData->insertStatus($indentdata,$request->input('remark'),$status);
//        if($request->input('button')!="Rejection"){
//            if ($workflowId->place_name == $indentdata->current_status) {
//                $add = IndentMaster::where('id', $indentdata->id)->where('indent_id', $indentdata->indent_id)->update(['is_active' => 1, 'current_status' => Null]);
//
//            } else {
//                $indentdata->toChangeStage($workflow, $indentdata);
//            }
//        }else{
//            $add = IndentMaster::where('id',$indentdata->id)->where('indent_id',$indentdata->indent_id)->update(['is_active'=> 0,'current_status'=>$workflowRejectId->place_name]);
//        }


//        if ($indentdata->current_status==Null) {
//
//            $purchaseOrderMaster=new VishwaPurchaseOrder();
//            $purchaseOrderMaster->portal_id=Auth::user()->getPortal->id;
//            $purchaseOrderMaster->indent_id=$indentdata->indent_id;
//            $purchaseOrderMaster->save();
//
//            $purchaseData=VishwaPurchaseOrder::where('indent_id',$indentdata->indent_id)->first();
//
//            $workflow = Controller::getPoWorkFlow($purchaseData, 'PO Flow');
//            $transitions = $workflow->getEnabledTransitions($purchaseData);
//            $workflow->apply($purchaseData, 'To_Get_PO');
//
//
//        }
//        return redirect()->route('indentResorurce.index',[$project->id]);
//

        Session::flash('success_message', 'PO Request Successfully Generated Go to The Purchase order Tabs!');
        return redirect()->route('indentResorurce.index', $project->id);

    }

    public function generatePDF(Project $project,Request $request)
    {
        $unique_no = $request->input('unique_no');
        $indent = DB::table('vishwa_indent_masters')
            ->Join('vishwa_indent_items', 'vishwa_indent_masters.indent_id', '=', 'vishwa_indent_items.indent_id')
            ->Join('users', 'vishwa_indent_masters.created_by', '=', 'users.id')
            ->Join('vishwa_portals', 'users.id', '=', 'vishwa_portals.user_id')
            ->Join('vishwa_materials_item', 'vishwa_indent_items.item_id', '=', 'vishwa_materials_item.id')
            ->Join('vishwa_projects', 'vishwa_indent_masters.project_id', '=', 'vishwa_projects.id')
            ->where('vishwa_indent_masters.indent_id', $unique_no)
            ->select('vishwa_indent_masters.*','vishwa_indent_items.*','users.name as user_name','vishwa_projects.name as project_name',
                'vishwa_materials_item.material_name','vishwa_portals.company_mail','vishwa_portals.company_mobile','vishwa_portals.company_name',
                'address')
            ->get();
        return view ('projects.estimate.pdf', compact('indent'));
    }


    public function getItemList(Project $project,Request $request)
    {
        $group_id=$request->group_id;

        $data=DB::table('vishwa_materials_item')
            ->join('vishwa_unit_masters','vishwa_materials_item.material_unit','vishwa_unit_masters.id')
            ->where('vishwa_materials_item.group_id',$group_id)
            ->select('vishwa_materials_item.*','vishwa_unit_masters.material_unit')
            ->get();

        return response()->json($data);
    }


    public function getOneItemList(Project $project,Request $request)
    {
        $item_id=$request->item_id;
        $data=DB::table('vishwa_materials_item')
            ->join('vishwa_unit_masters','vishwa_materials_item.material_unit','vishwa_unit_masters.id')
            ->where('vishwa_materials_item.id',$item_id)
            ->select('vishwa_materials_item.*','vishwa_unit_masters.material_unit')
            ->get();

        return response()->json($data);
    }


    public function getItemListIndent(Project $project,Request $request)
    { 
        
        $indent_id=$request->indent_id;
        $group_id=$request->group_id;
        $mat_itam_list=DB::table('vishwa_materials_item')
            ->join('vishwa_unit_masters','vishwa_materials_item.material_unit','vishwa_unit_masters.id')
            ->where('vishwa_materials_item.group_id',$group_id) 
            ->select('vishwa_materials_item.*','vishwa_unit_masters.material_unit')
            ->get();

        $chkIndentItem = IndentItem::where('indent_id',$indent_id)->get();

        return view('projects.estimate.partials.create-list',compact('mat_itam_list','chkIndentItem'));

    }


   public function changeStatus(Project $project,Request $request)
    {     
        $indent = $request->input('indent_no');
        $indentdata = IndentMaster::where('id',$indent)->first();  
        $workflow = Controller::getWorkFlow($indentdata,'Indent Flow');

        $workFlowName=WorkFlowMaster::where('name','Indent Flow')->first();
        $workflowId=WorkflowPlace::where('workflow_id',$workFlowName->id)->orderBy('id', 'DESC')->first();
        $workflowRejectId=WorkflowPlace::where('workflow_id',$workFlowName->id)->first();

        $status = ($request->input('button')=="Rejection") ? 0 : 1 ;

        $indentdata->insertStatus($indentdata,$request->input('remark'),$status);

        if($request->input('button')!="Rejection"){
            if ($workflowId->place_name == $indentdata->current_status) {
                $add = IndentMaster::where('id', $indentdata->id)->where('indent_id', $indentdata->indent_id)->update(['is_active' => 1, 'current_status' => Null]);

            } else {
                $indentdata->toChangeStage($workflow, $indentdata);
            }
        }else{
            $add = IndentMaster::where('id',$indentdata->id)->where('indent_id',$indentdata->indent_id)->update(['is_active'=> 0,'current_status'=>$workflowRejectId->place_name]);
        }



        $indentNewdata=IndentMaster::where('id', $indentdata->id)->first();
//        dd($indentNewdata->current_status);

       if ($indentNewdata->current_status==Null) {

           $purchaseOrderMaster=new VishwaPurchaseOrder();
           if (Auth::user()->user_type == "portal") {
               $portal_id = Auth::user()->getPortal->id;
               $emp_id=Auth::user()->id;
           }
           else
           {
               $emp_id = Auth::user()->getPortal->id;
               $portal_id= Auth::user()->getEmp->getUserPortal->id;
           }
           $purchaseOrderMaster->portal_id=$portal_id;
           $purchaseOrderMaster->emp_id=$emp_id;
           $purchaseOrderMaster->indent_id=$indentdata->indent_id;
           $purchaseOrderMaster->save();

           $purchaseData=VishwaPurchaseOrder::where('indent_id',$indentdata->indent_id)->first();

                   $workflow = Controller::getPoWorkFlow($purchaseData, 'PO Flow');
                   $transitions = $workflow->getEnabledTransitions($purchaseData);
                   $workflow->apply($purchaseData, 'To_Get_PO');


       }
        return redirect()->route('indentResorurce.index',[$project->id]);
    }



}
