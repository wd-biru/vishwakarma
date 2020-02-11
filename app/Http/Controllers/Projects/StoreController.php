<?php

namespace App\Http\Controllers\Projects;

use App\Models\GateEntry;
use App\Models\IndentMaster;
use App\Models\MaterialRequestFlow;
use App\Models\MaterialRequestItem;
use App\Models\MaterialRequestTrack;
use App\Models\QualityCheck;
use App\Models\VishwaQualityCheckItem;
use App\Models\VishwaVendorIndentMapping;
use App\Models\WorkFlowMaster;
use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Models\VishwaProjectStore;
use App\Models\DepartmentMaster;
use App\Models\DesignationMaster;
use App\Models\VishwaStoreInventoryQuantity;
use App\Models\VishwaVendorsRegistration;
use App\Models\VishwaProjectTower;
use Session;
use Response;
use Validator;
use App\Models\MasterMaterialsGroup;
use App\Models\VishwaStoreMapping;
use App\Models\MaterialItem;
use App\Models\EmployeeProfile;
use App\Models\ProjectMapping;
use App\Models\Portal;
use Carbon\Carbon;
use DB;
use File;
use App\Entities\Projects\Project;
use App\Models\VishwaGroupType;


class StoreController extends Controller
{


    public function index(Project $project)
    {
        if (Auth::user()->user_type == "employee") {
            $store_detail = VishwaStoreMapping::where('project_id', $project->id)->where('store_keeper_id', Auth::user()->getEmp->id)->get();
        } else {
            $store_detail = VishwaProjectStore::where('project_id', $project->id)->get();
        }
        $store_emp_list = DB::table('vishwa_employee_project_mapping')
            ->join('vishwa_employee_profile', 'vishwa_employee_profile.id', '=', 'vishwa_employee_project_mapping.employee_id')
            ->where('vishwa_employee_project_mapping.portal_id', Auth::user()->getPortal->id)
            ->where('vishwa_employee_project_mapping.project_id', $project->id)
            ->select('vishwa_employee_profile.*')
            ->get();


        return view('projects.store.index', compact('project', 'store_detail', 'store_emp_list'));

    }

    public function create(Project $project)
    {

        $id = Auth::user()->id;
        $emp_id = null;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_id = Portal::where('id', $result)->first();
            $emp_id = EmployeeProfile::where('user_id', $id)->pluck('id')->first();
        } else {
            $portal_id = Portal::where('user_id', $id)->first();
        }


        $emp_list = DB::table('vishwa_employee_project_mapping')
            ->join('vishwa_employee_profile', 'vishwa_employee_profile.id', '=', 'vishwa_employee_project_mapping.employee_id')
            ->where('vishwa_employee_project_mapping.portal_id', $portal_id->id)
            ->where('vishwa_employee_project_mapping.project_id', $project->id)
            ->select('vishwa_employee_profile.*')
            ->get();


        $store_detail = VishwaStoreMapping::where('project_id', $project->id)
            ->get();


        return view('projects.store.create', compact('project', 'emp_list', 'store_detail', 'emp_id'));

    }


    public function store(Request $request, $project_id)
    {


        $storeExist=VishwaProjectStore::where('project_id',$project_id)->first();

        if($storeExist !=null)
        {
            Session::flash('error_message', 'Project Already Have a Store!!');
            return redirect()->route('store.index', $project_id);
        }

        $validator = Validator::make($request->all(), [
            'store_name' => 'required|unique:vishwa_project_store'
        ]);
        if ($validator->fails()) {

            Session::flash('error_message', 'Store Name Already Exits !!');
            return redirect()->route('store.index', $project_id);
        }
        $store_name = $request->input('store_name');
        $project_id = $request->input('project_id');
        $store_keeper_id = $request->input('store_keeper_id');


        $VishwaProjectStore = new VishwaProjectStore();
        $VishwaProjectStore->store_name = $store_name;
        $VishwaProjectStore->project_id = $project_id;
        $VishwaProjectStore->save();


        foreach ($store_keeper_id as $key => $value) {
            $get_store_name_id = VishwaProjectStore::where('store_name', $store_name)->first();
            $VishwaStoreEmpMapping = new VishwaStoreMapping();
            $VishwaStoreEmpMapping->store_keeper_id = $value;
            $VishwaStoreEmpMapping->store_id = $get_store_name_id->id;
            $VishwaStoreEmpMapping->project_id = $project_id;
            $VishwaStoreEmpMapping->save();

        }


        Session::flash('success_message', 'Store save Successfully!!');
        return redirect()->route('store.index', $project_id);
    }


    public function storeUpdate(Request $request, $project_id)
    {


        $store_id = $request->input('store_id');
        $project_id = $request->input('project_id');
        $store_keeper_id = $request->input('store_keeper_id');

        if ($store_id != null) {
            $update = VishwaStoreMapping::where('store_id', $store_id)->where('project_id', $project_id)->delete();
        }


        foreach ($store_keeper_id as $key => $value) {

            $VishwaProjectStore = new VishwaStoreMapping();
            $VishwaProjectStore->store_keeper_id = $value;
            $VishwaProjectStore->store_id = $store_id;
            $VishwaProjectStore->project_id = $project_id;
            $VishwaProjectStore->save();
        }

        Session::flash('success_message', 'Store Update Successfully!!');
        return redirect()->route('store.index', $project_id);
    }


    public function storeInventory(Project $project, Request $request, $store)
    {

        $store = base64_decode($store);

        $segment = $request->segment(3);

        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_id = Portal::where('id', $result)->first();

        } else {
            $portal_id = Portal::where('user_id', $id)->first();
            $portal = Auth::user()->getPortal->id;

        }
        $store_inventory_material_group = MasterMaterialsGroup::all();


        return view('projects.store.storeinventory', compact('project', 'store_inventory_material_group', 'segment', 'store_id', 'store'));
    }


    public function getItemsQuantity(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);
        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_id = Portal::where('id', $result)->first();
        } else {
            $portal_id = Portal::where('user_id', $id)->first();
        }

        $group_id = $request->group_id;
        $mat_itam_list = DB::table('vishwa_materials_item')
            ->join('vishwa_unit_masters', 'vishwa_materials_item.material_unit', 'vishwa_unit_masters.id')
            ->where('vishwa_materials_item.group_id', $group_id)
            ->select('vishwa_materials_item.*', 'vishwa_unit_masters.material_unit')
            ->get();

        $getInventoryQuantity = VishwaStoreInventoryQuantity::where('portal_id', $portal_id->id)
            ->where('group_id', $group_id)->where('project_id', $project->id)->where('store_id', $store)->get();


        return view('projects.store.partials.create-list', compact('mat_itam_list', 'getInventoryQuantity'));
    }


    public function storeQuantity(Project $project, Request $request, $store)
    {
        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_id = Portal::where('id', $result)->first();
        } else {
            $portal_id = Portal::where('user_id', $id)->first();
        }
        $store_id = $request->input('store_id');
        $store_id = base64_decode($store_id);
        $item_id = $request->input('item_id');
        $qty = $request->input('qty');


        if ($item_id != null) {
            foreach ($item_id as $key => $item_idvalue) {

                if ($qty[$key] != null) {
                    $update = VishwaStoreInventoryQuantity::where('item_id', $item_idvalue)
                        ->where('store_id', $store_id)
                        ->where('portal_id', $portal_id->id)
                        ->where('project_id', $project->id)
                        ->delete();
                    $VishwaStoreQuantity = new VishwaStoreInventoryQuantity();
                    $VishwaStoreQuantity->portal_id = $portal_id->id;
                    $VishwaStoreQuantity->group_id = $request->input('group_id');
                    $VishwaStoreQuantity->qty = $qty[$key];
                    $VishwaStoreQuantity->project_id = $project->id;
                    $VishwaStoreQuantity->item_id = $item_idvalue;
                    $VishwaStoreQuantity->store_id = $store_id;
                    $VishwaStoreQuantity->save();
                }
            }
        }

        Session::flash('success_message', ' Stock Inventory Store Successfully!');
        return redirect()->route('storeInventory', [$project->id, $store]);
    }


    public function storeInword(Project $project, Request $request, $store)
    {

        $store = base64_decode($store);
        $request->segment(3);
        $inwards_inventory_material_group = MasterMaterialsGroup::all();
        $inwords_material_group = MaterialItem::all();
        $group_type = VishwaGroupType::all();
        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }

        if (Auth::user()->user_type == "employee") {
            $store_detail = VishwaProjectStore::where('project_id', $project->id)->where('id', $store)->first();

        } else {
            $store_detail = VishwaProjectStore::where('project_id', $project->id)->where('id', $store)->first();
        }

        return view('projects.store.storeinword', compact('group_type', 'project', 'inwords_material_group', 'getprimaryid', 'inwards_inventory_material_group', 'store', 'store_detail'));


    }

    public function invoiveCheck(Project $project, Request $request, $store)
    {

        $check = DB::table('vishwa_store_inventory_qty')->where('invoice_no', 'like', trim(strtolower($request->input("inv_no"))))->first();
        if ($check) {
            return 'true';
        } else {
            return 'false';
        }
    }


    public function storeInwordStock(Project $project, Request $request, $store)
    {

        $store = base64_decode($store);
        $input = $request->all();

        $checkedEntry = $request->input('checkedValue');
        $dataMapId = $request->input('data_map');


        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;

        }


        $project_id = $project->id;
        $user_id = Auth::user()->getPortal->user_id;


        if ($checkedEntry == "Generated") {
            $findMapData = VishwaQualityCheckItem::join('vishwa_quality_check', 'vishwa_quality_check_items.quality_map_id', 'vishwa_quality_check.id')
//                ->join('vishwa_vendor_master', 'vishwa_quality_check.vendor_id', 'vishwa_vendor_master.id')
                ->where('quality_map_id', $dataMapId)
                ->get();


            DB::beginTransaction();

            try {
                foreach ($findMapData as $mapData) {
                    $storeInwardEntry = new VishwaStoreInventoryQuantity();
                    $storeInwardEntry->portal_id=$portal_id;
                    $storeInwardEntry->item_id=$mapData->item_id;
                    $storeInwardEntry->project_id=$project_id;
                    $storeInwardEntry->challan_no=$mapData->challan_no;
                    $storeInwardEntry->inward_date=date('Y-m-d');
                    $storeInwardEntry->mr_no=1;
                    $storeInwardEntry->qty=($mapData->qty);
                    $storeInwardEntry->store_id=$store;
                    $storeInwardEntry->send_by=$mapData->vendor_id;
                    $storeInwardEntry->save();
                }

                DB::commit();
                return 'Save Data Successfully';
            } catch (Exception $e) {
                DB::rollback();
                return 'Something Went Wrong';
            }

        } else {
            $group_id = $input['group_id'];
            // $store_id=$input['store_id'];
            $primaryId = $input['primaryId'];
            $Inward_date = $input['Inward_date'];
            $invoiceno = $input['invoiceno'];
            $invoicedate = $input['invoicedate'];
            $Item_Id = $input['Item_Id'];
            $Item_Qty = $input['Item_Qty'];
            $date2 = new Carbon(str_replace('/', '-', $Inward_date));
            $final_Inward_date = date('Y-m-d H:i:s', strtotime($date2));
            $date1 = new Carbon(str_replace('/', '-', $invoicedate));
            $final_invoicedate = date('Y-m-d H:i:s', strtotime($date1));
            $initial_state = 0;
            $invoice_count = DB::table('vishwa_store_inventory_qty')->where('portal_id', $portal_id)->where('invoice_no', $invoiceno)->get();


            if (count($invoice_count) > 0) {
                return 'Invoice Number Already Exist';
            }


            foreach ($Item_Id as $key => $value) {
                $ins_itm = DB::table('vishwa_store_inventory_qty')->insert(
                    ['portal_id' => $portal_id,
                        'accept_by' => $user_id,
                        'project_id' => $project_id,
                        'group_id' => $group_id,
                        'item_id' => $value,
                        'store_id' => $store,
                        'qty' => $Item_Qty[$key],
                        'initial_state' => $initial_state,
                        'accept_store_id' =>
                            $primaryId, 'id' => $primaryId,
                        'invoice_no' => $invoiceno, 'invoice_date' => $final_invoicedate,
                        'inward_date' => $final_Inward_date]);

            }

            if ($ins_itm == 1) {
                return 'Save Data Successfully';
            } else {
                return 'Something Wrong';
            }
        }
    }


    public function getItems(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);
        $id = $request->input('group_id');
        $group_id = MaterialItem::where('group_id', $id)->get();
        return $group_id;

    }

    public function getItemsforoutward(Project $project, Request $request, $store)
    {

        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }


        $store = base64_decode($store);
        $group_id = $request->input('group_id');


        $items = VishwaStoreInventoryQuantity::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_store_inventory_qty.item_id')
            ->where('vishwa_store_inventory_qty.project_id', $project->id)
            ->where('vishwa_store_inventory_qty.store_id', $store)
            ->where('vishwa_store_inventory_qty.group_id', $group_id)
            ->groupBy('item_id')
            ->select('vishwa_materials_item.*', DB::raw("SUM(vishwa_store_inventory_qty.qty) as availableQty"))
            ->get();





        return $items;

    }

    public function updateinventry(Project $project, Request $request, $store)
    {


        $store = base64_decode($store);
        $input = $request->all();
        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }

        $invid = $input['id'];
        $invqty = $input['qty'];
        $upd = DB::table('vishwa_store_inventory_qty')
            ->where('id', $invid)// find your user by their email
            ->limit(1)// optional - to ensure only one record is updated.
            ->update(array('qty' => $invqty));

        if ($upd) {
            return Response::json(array(
                'success' => $invid,
                'data' => $invqty
            ));
        } else {

            return Response::json(array(
                'success' => false

            ));
        }

    }

    public function Itemlistdel(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);
        $input = $request->all();
        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }

        $delinvid = $input['invId'];
        $check = DB::table('vishwa_store_inventory_qty')->where('id', '=', $delinvid)->delete();

        return Response::json(array(
            'success' => $check,
            'data' => $delinvid
        ));

    }

    public function getstoreitemlistinvalter(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);
        $request->segment(3);
        $input = $request->all();
        $group_type = VishwaGroupType::all();

        if ($request->isMethod('post')) {
            $id = Auth::user()->id;
            if (Auth::user()->user_type == "employee") {
                $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
                $portal_result = Portal::where('id', $result)->first();
                $portal_id = $portal_result->id;
            } else {
                $data = Portal::where('user_id', $id)->first();
                $portal_id = $data->id;
            }


            $from_date_input = $input['from_date'];
            $to_date_input = $input['to_date'];
            $date2 = new Carbon(str_replace('/', '-', $input['from_date']));
            $from_Date = date('Y-m-d', strtotime($date2));

            $date1 = new Carbon(str_replace('/', '-', $input['to_date']));
            $to_Date = date('Y-m-d', strtotime($date1));

            //$getprimaryid=TblGodownMaster::where([['portal_id',$portal_id],['type','Primary']])->first();
            $getprimaryid = VishwaStoreInventoryQuantity::where('portal_id', $portal_id)->first();
            $gid = $getprimaryid->id;


            if ($to_Date == null) {

                $start = date("Y-m-d", strtotime($from_Date));
                $end = $start;


                $getTypeName = VishwaStoreInventoryQuantity::FilterAlterData($portal_id,$store)
                    ->whereDate('vishwa_store_inventory_qty.created_at', '>=', $start)
                    ->whereDate('vishwa_store_inventory_qty.created_at', '<=', $end)
                    ->get();
            } else {
                $start = date("Y-m-d", strtotime($from_Date));
                $end = date("Y-m-d", strtotime($to_Date));
                $getTypeName = VishwaStoreInventoryQuantity::FilterAlterData($portal_id,$store)
                    ->whereDate('vishwa_store_inventory_qty.created_at', '>=', $start)
                    ->whereDate('vishwa_store_inventory_qty.created_at', '<=', $end)
                    ->get();
            }




            foreach ($getTypeName as $key => $value) {
                $value->sumqty = null;
            }
            // dd($getTypeName);
            return Response::json(array(
                'success' => true,
                'data' => $getTypeName
            ));
        } else {
            $getTypeName = [];
            return view('projects.store.view-alter-inward-list', compact('group_type', 'getTypeName', 'project', 'store'));
        }


    }


    public function getstoreitemlistinv(Project $project, Request $request, $store)
    {

        $store = base64_decode($store);
        $input = $request->all();
        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }


        $gid = $input['godownId'];


        $getTypeName = DB::table('vishwa_store_inventory_qty')
            ->join('vishwa_materials_item', 'vishwa_materials_item.id', '=', 'vishwa_store_inventory_qty.item_id')
            ->select('vishwa_store_inventory_qty.*', 'vishwa_materials_item.material_name')
            ->where('vishwa_store_inventory_qty.portal_id', '=', $portal_id)
            ->whereNotNull('vishwa_store_inventory_qty.invoice_no')
            ->get();
        foreach ($getTypeName as $key => $value) {
            $value->sumqty = DB::table('vishwa_store_inventory_qty')
                ->where('portal_id', '=', $portal_id)->where('godown_id', '=', $gid)
                ->where('item_id', '=', $value->item_id)
                ->where('qty', '<', 0)
                ->value('qty');
        }

        return Response::json(array(
            'success' => true,
            'data' => $getTypeName
        ));

    }


    /****************************** Shubham vats Controllers *********************************/


    public function updateoutventry(Project $project, Request $request, $store)
    {




        $store = base64_decode($store);
        $input = $request->all();
        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }

        $invid = $input['id'];
        $invqty = $input['qty'];

        $item = DB::table('vishwa_store_inventory_qty')->where('id', $invid)->first();
        $item_id = $item->item_id;


        $getTypeName = DB::table('vishwa_store_inventory_qty')
            ->where('portal_id', '=', $portal_id)
            ->where('item_id', '=', $item_id)
            ->where('store_id', '=', $store)
            ->where('id', '<>', $invid)
            ->sum('qty');




        $final_value = $getTypeName - $invqty;





        if ($final_value < 0) {
            return Response::json(array('success' => false));
        }


        $upd = DB::table('vishwa_store_inventory_qty')->where('id', $invid)->update(array('qty' => "-" . $invqty));

        if ($upd) {
            return Response::json(array('success' => $invid, 'data' => $invqty));
        } else {
            return Response::json(array('success' => false));
        }

    }


    public function getstore(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);


        $stores = DB::table('vishwa_project_store')
            ->join('vishwa_projects', 'vishwa_project_store.project_id', '=', 'vishwa_projects.id')
            ->where('vishwa_project_store.project_id', $project->id)
            ->select('vishwa_project_store.*', 'vishwa_projects.name')
            ->groupBy('store_name')
            ->get();


        // $stores = VishwaProjectStore::where('project_id',$project->id)->groupBy('store_name')->get();


        return $stores;

    }


    public function viewandalteroutward(Project $project, Request $request, $store)
    {

        //  dd($request->all());
        $store = base64_decode($store);
        $request->segment(3);
        $input = $request->all();
        $group_type = VishwaGroupType::all();

        if ($request->isMethod('post')) {
            $id = Auth::user()->id;
            if (Auth::user()->user_type == "employee") {
                $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
                $portal_result = Portal::where('id', $result)->first();
                $portal_id = $portal_result->id;
            } else {
                $data = Portal::where('user_id', $id)->first();
                $portal_id = $data->id;
            }


            $from_date_input = $input['from_date'];
            $to_date_input = $input['to_date'];

            $date2 = new Carbon(str_replace('/', '-', $input['from_date']));
            $from_Date = date('Y-m-d', strtotime($date2));

            $date1 = new Carbon(str_replace('/', '-', $input['to_date']));
            $to_Date = date('Y-m-d', strtotime($date1));

            //$getprimaryid=TblGodownMaster::where([['portal_id',$portal_id],['type','Primary']])->first();
            $getprimaryid = VishwaStoreInventoryQuantity::where('portal_id', $portal_id)->first();
            if ($getprimaryid != null) {
                $gid = $getprimaryid->id;
            }


            if ($to_Date == null) {

                $start = date("Y-m-d", strtotime($from_Date));
                $end = $start;


                $getTypeName = VishwaStoreInventoryQuantity::FilterAlterData($portal_id,$store)
                    ->whereDate('vishwa_store_inventory_qty.created_at', '>=', $start)
                    ->whereDate('vishwa_store_inventory_qty.created_at', '<=', $end)
                    ->where('vishwa_store_inventory_qty.qty', '<', 0)
                    ->get();
            } else {
                $start = date("Y-m-d", strtotime($from_Date));
                $end = date("Y-m-d", strtotime($to_Date));
                $getTypeName = VishwaStoreInventoryQuantity::FilterAlterData($portal_id,$store)
                 ->whereDate('vishwa_store_inventory_qty.created_at', '>=', $start)
                ->whereDate('vishwa_store_inventory_qty.created_at', '<=', $end)
                    ->where('vishwa_store_inventory_qty.qty', '<', 0)
                    ->get();
            }


            foreach ($getTypeName as $key => $value) {
                $value->sumqty = null;
            }
            // dd($getTypeName);
            return Response::json(array(
                'success' => true,
                'data' => $getTypeName
            ));
        } else {
            $getTypeName = [];


            return view('projects.store.view-alter-outward-list', compact('group_type', 'getTypeName', 'project', 'store'));
        }

    }

    public function updatestoretostorealter(Project $project, Request $request, $store)
    {

        // dd($request->all());
        $store = base64_decode($store);
        $input = $request->all();
        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }

        $invid = $input['id'];
        $invqty = $input['qty'];
        $group_id = $input['group_id'];
        $accept_store_id = $input['accept_store_id'];
        $send_store_id = $input['send_store_id'];


        $item = DB::table('vishwa_store_inventory_qty')->where('id', $invid)->first();
        $item_id = $item->item_id;


        $getTypeName = DB::table('vishwa_store_inventory_qty')
            ->where('portal_id', '=', $portal_id)
            ->where('item_id', '=', $item_id)
            ->where('store_id', '=', $store)
            ->where('id', '<>', $invid)
            ->sum('qty');


        $final_value = $getTypeName - $invqty;

        if ($final_value < 0) {
            return Response::json(array('success' => false));
        }


        $item_trans_date = DB::table('vishwa_store_inventory_qty')->where('id', $invid)->first();

        $del = DB::table('vishwa_store_inventory_qty')->where('group_id', $group_id)->delete();

        //  dd($item_trans_date->transition_date);


        $ins_itm = DB::table('vishwa_store_inventory_qty')->insert(
            [
                'portal_id' => $portal_id,
                'project_id' => $project->id,
                'item_id' => $item_id,
                'store_id' => $store,
                'send_store_id' => $send_store_id,
                'accept_store_id' => $accept_store_id,
                'transition_date' => $item_trans_date->transition_date,
                'send_by' => $id,
                'initial_state' => 0,
                'group_id' => $group_id,
                'qty' => "-" . $invqty,
            ]);


        $ins_itm = DB::table('vishwa_store_inventory_qty')->insert(
            [
                'portal_id' => $portal_id,
                'project_id' => $project->id,
                'item_id' => $item_id,
                'store_id' => $accept_store_id,
                'send_store_id' => $send_store_id,
                'accept_store_id' => $accept_store_id,
                'send_by' => $id,
                'initial_state' => 0,
                'group_id' => $group_id,
                'transition_date' => $item_trans_date->transition_date,
                'qty' => $invqty,
            ]);


        if ($ins_itm) {
            return Response::json(array('success' => $invid, 'data' => $invqty));
        } else {
            return Response::json(array('success' => false));
        }

    }


    public function viewamdalterstoretransfer(Project $project, Request $request, $store)
    {
        //dd($request->all());
        $store = base64_decode($store);
        $request->segment(3);
        $input = $request->all();

        if ($request->isMethod('post')) {
            $id = Auth::user()->id;
            if (Auth::user()->user_type == "employee") {
                $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
                $portal_result = Portal::where('id', $result)->first();
                $portal_id = $portal_result->id;
            } else {
                $data = Portal::where('user_id', $id)->first();
                $portal_id = $data->id;
            }


            $from_date_input = $input['from_date'];
            $to_date_input = $input['to_date'];
            $date2 = new Carbon(str_replace('/', '-', $input['from_date']));
            $from_date = date('Y-m-d', strtotime($date2));

            $date1 = new Carbon(str_replace('/', '-', $input['to_date']));
            $to_date = date('Y-m-d', strtotime($date1));

            //$getprimaryid=TblGodownMaster::where([['portal_id',$portal_id],['type','Primary']])->first();
            $getprimaryid = VishwaStoreInventoryQuantity::where('portal_id', $portal_id)->first();
            if ($getprimaryid != null) {
                $gid = $getprimaryid->id;
            }

            $getTypeName = DB::table('vishwa_store_inventory_qty')
                ->join('vishwa_materials_item', 'vishwa_materials_item.id', '=', 'vishwa_store_inventory_qty.item_id')
                ->select('vishwa_store_inventory_qty.*', 'vishwa_materials_item.material_name')
                ->where('vishwa_store_inventory_qty.portal_id', '=', $portal_id)
                ->where('vishwa_store_inventory_qty.store_id', '=', $store)
                ->whereDate('vishwa_store_inventory_qty.transition_date', '>=', $from_date)
                ->whereDate('vishwa_store_inventory_qty.transition_date', '<=', $to_date)
                ->where('vishwa_store_inventory_qty.accept_store_id', '<>', null)
                ->where('vishwa_store_inventory_qty.send_store_id', '<>', null)
                ->where('qty', '<', 0)
                ->orderBy('vishwa_store_inventory_qty.transition_date', 'DESC')
                ->get();

            // /   dd($getTypeName);


            $all_stores = VishwaProjectStore::all();


            foreach ($getTypeName as $key => $value) {
                $value->sumqty = null;
            }
            // dd($getTypeName);
            return Response::json(array(
                'success' => true,
                'data' => $getTypeName,
                'store' => $all_stores,
            ));
        } else {
            $getTypeName = [];
            return view('projects.store.view-alter-store-transfer-list', compact('getTypeName', 'project', 'store'));
        }


    }


    public function storetostoreitemdel(Project $project, Request $request, $store)
    {


        $group_id = $request->input('group_id');
        $id = $request->input('id');
        $del = DB::table('vishwa_store_inventory_qty')->where('group_id', $group_id)->delete();
        return Response::json(array('success' => $del, 'data' => $id));
    }


    public function getitemfromPriGodow(Project $project, Request $request, $store)
    {

        // dd($request->all());
        $store = base64_decode($store);

        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }

        $store_id = $request->input('setgodownpri');


        $item_master_list = DB::table('vishwa_store_inventory_qty')
            ->join('vishwa_master_material_group', 'vishwa_store_inventory_qty.group_id', 'vishwa_master_material_group.id')
            ->join('vishwa_materials_item', 'vishwa_store_inventory_qty.item_id', 'vishwa_materials_item.id')
            ->where('vishwa_store_inventory_qty.project_id', $project->id)
            ->where('vishwa_store_inventory_qty.portal_id', $portal_id)
            ->where('vishwa_store_inventory_qty.store_id', '=', $store_id)
            ->select('vishwa_materials_item.*', 'vishwa_master_material_group.*')
            ->get();

        foreach ($item_master_list as $val) {
            $checkitmInGodown = DB::table('vishwa_store_inventory_qty')
                ->where('project_id', '=', $project->id)
                ->where('portal_id', '=', $portal_id)
                ->where('store_id', '=', $store_id)
                ->sum('qty');
            if ($checkitmInGodown > 0) {
                $val->itmStock = DB::table('vishwa_store_inventory_qty')
                    ->where('project_id', '=', $project->id)
                    ->where('portal_id', '=', $portal_id)
                    ->where('store_id', '=', $store_id)
                    ->sum('qty');
            } else {
                $val->itmStock = 0;
            }

        }

        return response()->json($item_master_list);


    }


    public function checkItemInPrimary(Project $project, Request $request, $store)
    {


        $store = base64_decode($store);


        $input = $request->all();
        $Item_Id = $input['Item_Id'];
        $Item_Qty = $input['Item_Qty'];
        $from = $input['from_store'];
        $to = $input['to_store'];
        $group_id = $input['group_id'];


        // dd($from,$to,$store);


        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }


        $transition_date = $input['transition_date'];
        $transition_date1 = new Carbon(str_replace('/', '-', $input['transition_date']));
        $transition_dateformatted = date('Y-m-d', strtotime($transition_date1));

        $unique = mt_rand(10000000, 99999999);


        foreach ($Item_Id as $key => $value) {

            $getTypeName = DB::table('vishwa_store_inventory_qty')
                ->where('portal_id', '=', $portal_id)
                ->where('item_id', '=', $Item_Id)
                ->where('store_id', '=', $store)
                ->sum('qty');


            $final_value = $getTypeName - $Item_Qty[$key];

            if ($final_value < 0) {
                $result = MaterialItem::find($Item_Id)->first();
                return 'Not enough item Avilable in ' . $result->material_name;
            }

        }


        foreach ($Item_Id as $key => $value) {
            $ins_itm = DB::table('vishwa_store_inventory_qty')->insert(
                [
                    'portal_id' => $portal_id,
                    'project_id' => $project->id,
                    'item_id' => $value,
                    'store_id' => $store,
                    'send_store_id' => $from,
                    'accept_store_id' => $to,
                    'transition_date' => $transition_dateformatted,
                    'send_by' => $id,
                    'initial_state' => 0,
                    'created_group_id' => $unique,
                    'group_id' => $group_id,
                    'qty' => "-" . $Item_Qty[$key],
                ]);

        }


        foreach ($Item_Id as $key => $value) {
            $ins_itm = DB::table('vishwa_store_inventory_qty')->insert(
                [
                    'portal_id' => $portal_id,
                    'project_id' => $project->id,
                    'item_id' => $value,
                    'store_id' => $to,
                    'send_store_id' => $from,
                    'accept_store_id' => $to,
                    'send_by' => $id,
                    'created_group_id' => $unique,
                    'initial_state' => 0,
                    'group_id' => $group_id,
                    'transition_date' => $transition_dateformatted,
                    'qty' => $Item_Qty[$key],
                ]);

        }


        if ($ins_itm == 1) {
            return 'Save Data Successfuly';
        } else {
            return 'SomeThing Wrong';
        }


    }

    public function getMaterialItemAndGroup(Project $project, Request $request, $store)
    {


        // dd($request->all());
        $store = base64_decode($store);

        $store_id = $request->input('store_id');


        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }


        $material_group_item = VishwaStoreInventoryQuantity::
        where('project_id', $project->id)
            ->where('portal_id', $portal_id)
            ->where('store_id', '=', $store_id)
            ->distinct('group_id')
            ->get()->pluck('group_id')->toArray();

        $matname_obj = new VishwaVendorsRegistration();
        $result = $matname_obj->getMaterial($material_group_item);


        return $result;

    }


    public function storeoutward(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);
        $request->segment(3);
        $group_type = VishwaGroupType::all();
        $material_item = MasterMaterialsGroup::all();
        $VishwaProjectTower = VishwaProjectTower::where('project_id', $project->id)->groupBy('vishwa_project_tower.tower_name')->get();


        return view('projects.store.storeoutword', compact('group_type', 'project', 'material_item', 'store', 'VishwaProjectTower'));

    }


    public function getgodownItem(Project $project, Request $request, $store)
    {


        //dd($request->all());
        $store = base64_decode($store);
        $input = $request->all();
        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }


        $store_id = $input['godownId'];
        $getTypeName = VishwaStoreInventoryQuantity::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_store_inventory_qty.item_id')
            ->select('vishwa_store_inventory_qty.*', 'vishwa_materials_item.material_name', DB::raw('Sum(vishwa_store_inventory_qty.qty) AS Quantity'))
            ->where('vishwa_store_inventory_qty.project_id', $project->id)
            ->where('vishwa_store_inventory_qty.portal_id', $portal_id)
            ->where('vishwa_store_inventory_qty.store_id', '=', $store_id)
            ->groupBy('vishwa_materials_item.material_name')
            ->get();


        return Response::json(array('success' => true, 'data' => $getTypeName));

    }

    public function storeoutwardstack(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);
        $request->segment(3);

        $checkedEntry = $request->input('checkedValue');
        $dataMapId = $request->input('data_map');
        $item_release = $request->input('item_release');
        $remarks = $request->input('remarks_ext');

        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;

        }


        $project_id = $project->id;
        $user_id = Auth::user()->getPortal->user_id;



        if ($checkedEntry == "Generated") {

            $findMapData = MaterialRequestItem::join('vishwa_material_request_flow', 'vishwa_material_request_item.mreq_no', 'vishwa_material_request_flow.mreq_no')
                ->where('vishwa_material_request_flow.mreq_no', $dataMapId)
                ->get();



            DB::beginTransaction();

            try {
                foreach ($findMapData as $key=>$mapData) {
                    $storeOutwardEntry = new VishwaStoreInventoryQuantity();
                    $storeOutwardEntry->portal_id=$portal_id;
                    $storeOutwardEntry->item_id=$mapData->item_id;
                    $storeOutwardEntry->project_id=$project_id;
//                    $storeOutwardEntry->challan_no=$mapData->challan_no;
//                    $storeOutwardEntry->inward_date=date('Y-m-d');
                    $storeOutwardEntry->mr_no=1;
                    $storeOutwardEntry->tower_id=$mapData->tower_id;
                    $storeOutwardEntry->qty=-($item_release[$key]);
                    $storeOutwardEntry->store_id=$mapData->store_id;
                    $storeOutwardEntry->send_by=$mapData->vendor_id;
                    $storeOutwardEntry->save();
                }


                $trackMreq=new MaterialRequestTrack();
                $trackMreq->mreq_no=$dataMapId;
                $trackMreq->released_date=date('Y-m-d H:i:s');

                $trackMreq->save();

                DB::commit();
                return 'Save Data Successfully';
            } catch (Exception $e) {
                DB::rollback();
                return 'Something Went Wrong';
            }
        }
        else {
            $input = $request->all();
            $Item_Id = $input['Item_Id'];
            $Item_Qty = $input['Item_Qty'];
            $group_id = $input['group_id'];
            $id = Auth::user()->id;
            if (Auth::user()->user_type == "employee") {
                $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
                $portal_result = Portal::where('id', $result)->first();
                $portal_id = $portal_result->id;
            } else {
                $data = Portal::where('user_id', $id)->first();
                $portal_id = $data->id;
            }


            $transition_date = $input['transition_date'];
            $transition_date1 = new Carbon(str_replace('/', '-', $input['transition_date']));
            $transition_dateformatted = date('Y-m-d', strtotime($transition_date1));


            foreach ($Item_Id as $key => $value) {

                $getTypeName = DB::table('vishwa_store_inventory_qty')
                    ->where('portal_id', '=', $portal_id)
                    ->where('item_id', '=', $Item_Id)
                    ->where('store_id', '=', $store)
                    ->sum('qty');


                $final_value = $getTypeName - $Item_Qty[$key];


                if ($final_value < 0) {
                    $result = MaterialItem::find($Item_Id)->first();
                    return 'Not enough item Avilable in ' . $result->material_name;
                }

            }


            foreach ($Item_Id as $key => $value) {
                $ins_itm = DB::table('vishwa_store_inventory_qty')->insert(
                    [
                        'portal_id' => $portal_id,
                        'project_id' => $project->id,
                        'item_id' => $value,
                        'store_id' => $store,
                        'group_id' => $group_id,
                        'send_by' => $id,
                        'initial_state' => 0,
                        'transition_date' => $transition_dateformatted,
                        'qty' => "-" . $Item_Qty[$key],
                    ]);

            }

            if ($ins_itm == 1) {
                return 'Save Data Successfuly';
            } else {
                return 'SomeThing Wrong';
            }

        }
    }

    public function storetostore(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);
        $request->segment(3);
        $getprimaryid = VishwaStoreMapping::where('project_id', $project->id)->groupBy('store_id')->first();


        //$item_master_list  = MaterialItem::all();
        $item_master_list = MasterMaterialsGroup::all();

        return view('projects.store.storetostoretransfer', compact('project', 'getprimaryid', 'item_master_list', 'store'));

    }


    public function getItemsforstoretostore(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);

        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_result = Portal::where('id', $result)->first();
            $portal_id = $portal_result->id;
        } else {
            $data = Portal::where('user_id', $id)->first();
            $portal_id = $data->id;
        }


        $id = $request->input('group_id');
        $store_id = $request->input('store_id');


        $items = VishwaStoreInventoryQuantity::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_store_inventory_qty.item_id')
            ->where('vishwa_store_inventory_qty.project_id', $project->id)
            ->where('vishwa_store_inventory_qty.store_id', $store_id)
            ->where('vishwa_store_inventory_qty.portal_id', '=', $portal_id)
            ->where('vishwa_store_inventory_qty.group_id', '=', $id)
            ->groupBy('item_id')
            ->select('vishwa_materials_item.*', DB::raw("SUM(vishwa_store_inventory_qty.qty) as availableQty"))
            ->get();


        return $items;

    }

    public function currentItemStock(Project $project, Request $request, $store)
    {

        $store = base64_decode($store);
        $segment = $request->segment(3);

        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal = Portal::where('id', $result)->first();

        } else {
            $portal_id = Portal::where('user_id', $id)->first();
            $portal = Auth::user()->getPortal->id;

        }
        $store_inventory_material_group = MasterMaterialsGroup::all();

        $mat_itam_list = VishwaStoreInventoryQuantity::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_store_inventory_qty.item_id')
            ->where('vishwa_store_inventory_qty.project_id', $project->id)
            ->where('vishwa_store_inventory_qty.store_id', $store)
            ->where('vishwa_store_inventory_qty.portal_id', '=', $portal)
            ->groupBy('item_id')
            ->select('vishwa_materials_item.*', DB::raw("SUM(vishwa_store_inventory_qty.qty) as availableQty"))
            ->get();


        $mat_item_details=VishwaStoreInventoryQuantity::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_store_inventory_qty.item_id')
            ->where('vishwa_store_inventory_qty.project_id', $project->id)
            ->where('vishwa_store_inventory_qty.store_id', $store)
            ->where('vishwa_store_inventory_qty.portal_id', '=', $portal)
            ->orderBy('vishwa_store_inventory_qty.created_at','DESC')
            ->get();
        // $store_detail = VishwaProjectStore::where('project_id',$project->id)->groupBy('store_name')->get();

        return view('projects.store.storecurrentstock', compact('mat_item_details','project', 'store_inventory_material_group', 'segment', 'store_id', 'store', 'mat_itam_list'));


        //  return view('projects.store.partials.create-list',compact('mat_itam_list','getInventoryQuantity'));
    }


    public function getCurrentItemsQuantity(Project $project, Request $request, $store)
    {
        $store = base64_decode($store);


        $id = Auth::user()->id;
        if (Auth::user()->user_type == "employee") {
            $result = EmployeeProfile::where('user_id', $id)->pluck('portal_id')->first();
            $portal_id = Portal::where('id', $result)->first();

        } else {
            $portal_id = Portal::where('user_id', $id)->first();
            $portal = Auth::user()->getPortal->id;

        }


        $group_id = $request->group_id;

        if ($group_id == 0) {

            $mat_itam_list = VishwaStoreInventoryQuantity::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_store_inventory_qty.item_id')
                ->where('vishwa_store_inventory_qty.project_id', $project->id)
                ->where('vishwa_store_inventory_qty.store_id', $store)
                ->where('vishwa_store_inventory_qty.portal_id', '=', $portal)
                ->groupBy('item_id')
                ->select('vishwa_materials_item.*', DB::raw("SUM(vishwa_store_inventory_qty.qty) as availableQty"))
                ->get();

        } else {
            $mat_itam_list = VishwaStoreInventoryQuantity::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_store_inventory_qty.item_id')
                ->where('vishwa_store_inventory_qty.project_id', $project->id)
                ->where('vishwa_store_inventory_qty.store_id', $store)
                ->where('vishwa_store_inventory_qty.portal_id', '=', $portal)
                ->where('vishwa_store_inventory_qty.group_id', '=', $group_id)
                ->groupBy('item_id')
                ->select('vishwa_materials_item.*', DB::raw("SUM(vishwa_store_inventory_qty.qty) as availableQty"))
                ->get();

        }
        return view('projects.store.partials.current-stock-list', compact('mat_itam_list', 'getInventoryQuantity', 'store'));
    }


    function import_excel(Project $project, Request $request, $store)
    {
        $store_id = base64_decode($store);


        if (Input::hasFile('select_file')) {
            $file = Input::file('select_file');
            $name = $file->getClientOriginalName();
            $Ext = \File::extension($name);
            if ($Ext != 'csv') {
                $request->Session()->flash('error_message', 'File shoud be CSV Format');
                return back();
            }
            try {

                $datas = array();
                $CountValues = array();
                $values = array();
                $DBcolumn = array();
                $ContentData = array();
                $AlreadyExistInitialStock = array();
                $ItemNotFound = array();
                $SucessSavedCount = 0;
                $UnsucessSavedCount = 0;
                $InsertRecordCount = 0;
                $AlredyExistRecordCount = 0;

                $file = Input::file('select_file');
                $name = time() . '-' . $file->getClientOriginalName();
                $path = storage_path('initialGodownStock');
                $file->move($path, $name);
                $filename = base_path('\storage\initialGodownStock\\' . $name);


                $file = fopen($filename, 'r');
                while (!feof($file)) {
                    $row = fgetcsv($file);
                    if ($row) {
                        $datas[] = $row;
                    }
                }
                foreach ($datas as $key => $value) {
                    if ($key == 0):
                        $value[0] = "item_id";
                        $DBcolumn[] = $value;
                    else:
                        $getItemDetails = MaterialItem::where('material_name', trim(ucfirst($value[0])))->first();
                        if ($getItemDetails != null):
                            $checkItems = VishwaStoreInventoryQuantity::where('item_id', $getItemDetails->id)
                                ->where('portal_id', Auth::user()->getPortal->id)
                                ->where('project_id', $project->id)
                                ->where('store_id', $store_id)
                                ->where('initial_state', 1)
                                ->first();

                            if ($checkItems == null):
                                $ContentData[] = array(
                                    $getItemDetails->id,
                                    $value[1],
                                    Auth::user()->getPortal->id,
                                    $getItemDetails->group_id,
                                    $project->id,
                                    $store_id,
                                    1
                                );
                                $InsertRecordCount = $InsertRecordCount + 1;
                            else:
                                $AlreadyExistInitialStock[] = trim(ucfirst($value[0]));
                                $AlredyExistRecordCount = $AlredyExistRecordCount + 1;
                            endif;
                        else:
                            $ItemNotFound[] = trim(ucfirst($value[0]));
                        endif;
                    endif;
                }
                $DBcolumn = array_merge($DBcolumn[0], array('portal_id', 'group_id', 'project_id', 'store_id', 'initial_state'));


                foreach ($ContentData as $data) {
                    foreach ($data as $key => $values) {
                        $save_value_array[$DBcolumn[$key]] = trim($values);
                    }
                    $Create = VishwaStoreInventoryQuantity::insert($save_value_array);
                    if ($Create) {
                        $SucessSavedCount = $SucessSavedCount + 1;
                    } else {
                        $UnsucessSavedCount = $UnsucessSavedCount + 1;
                    }
                }
                $CountValues['Sucess Saved Count'] = $SucessSavedCount;
                $CountValues['Un Sucess Saved Count'] = $UnsucessSavedCount;
                $CountValues['Insert Record Count'] = $InsertRecordCount;
                $CountValues['Alredy Exist Record Count'] = $AlredyExistRecordCount;
                $CountValues['ItemNotFound'] = $ItemNotFound;


                $store_inventory_material_group = MasterMaterialsGroup::all();

                $request->session()->flash('success_message', 'Store Intial Stock Records Import Successfully!!');
                return back()->with('CountValues', [$CountValues]);;

            } catch (\Illuminate\Database\QueryException $e) {

                $request->Session()->flash('error_message', 'Something is wrong');

            }
        } else {
            $request->Session()->flash('error_message', 'File is required');
        }
        return back();
        return redirect()->route('storeInventory', [$project->id, $store_id]);
    }


    public function getStoreChallanDetails(Project $project, Request $request)
    {
        $pro_id = $project->id;

        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        } else {
            $portal_id = Auth::user()->getEmp->getUserPortal->id;
        }


        $from_Date = $request->input('from_date');
        $to_Date = $request->input('to_date');


        $record = IndentMaster::Join('users', 'vishwa_indent_masters.created_by', '=', 'users.id')
            ->Join('vishwa_projects', 'vishwa_indent_masters.project_id', '=', 'vishwa_projects.id')
            ->where('vishwa_indent_masters.project_id', $pro_id)
            ->select('vishwa_indent_masters.*', 'users.name as user_name')
            ->orderByDesc('id')
            ->get();
        $VishwaVendorIndent = VishwaVendorIndentMapping::where('project_id', $project->id)
            ->where('portal_id', Auth::user()->getPortal->id)
            ->get();
        $vendor_reg = VishwaVendorsRegistration::join('vishwa_portal_vendor_mapping', 'vishwa_vendor_master.id', '=', 'vishwa_portal_vendor_mapping.vendor_id')
            ->where('vishwa_portal_vendor_mapping.portal_id', '=', Auth::user()->getPortal->id)
            ->select('vishwa_vendor_master.*', 'vishwa_portal_vendor_mapping.portal_id as PortalId')
            ->get();


        if ($to_Date == null) {

            $start = date("Y-m-d", strtotime($from_Date));
            $end = $start;


            $qcPassed = QualityCheck::QualityFilterData($portal_id, $project->id)
                ->whereBetween('vishwa_quality_check.date', [$start, $end])
                ->get();
        } else {
            $start = date("Y-m-d", strtotime($from_Date));
            $end = date("Y-m-d", strtotime($to_Date));
            $qcPassed = QualityCheck::QualityFilterData($portal_id, $project->id)
                ->whereBetween('vishwa_quality_check.date', [$start, $end])
                ->get();
        }


        return response()->json($qcPassed);
    }

    public function populateItemDetails(Project $project, Request $request)
    {
        $map_id = $request->input('map_id');
        $qcPassedItems = VishwaQualityCheckItem::where('quality_map_id', $map_id)
            ->join('vishwa_materials_item', 'vishwa_quality_check_items.item_id', 'vishwa_materials_item.id')
            ->get();

        return response()->json($qcPassedItems);
    }


    public function getMRequestDetails(Project $project,Request $request)
    {
        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        } else {
            $portal_id = Auth::user()->getEmp->getUserPortal->id;
        }

        $workFlowName = WorkFlowMaster::where('name', 'MRequest Flow')->first();
        $workflowId = \App\Models\WorkflowTransitions::where('workflow_id', $workFlowName->id)->orderBy('id', 'DESC')->first();
        $from_Date = $request->input('from_date');
        $to_Date = $request->input('to_date');

        $project_id = $project->id;
        $mRequestData = MaterialRequestFlow::MReqFilterData($portal_id, $project_id)
            ->WhereIn('current_status', [$workflowId->trans_name])
            ->orwhereNull('current_status')
            ->get();




        if ($to_Date == null) {

                $start = date("Y-m-d", strtotime($from_Date));
                $end = $start;


                $mRequestData = MaterialRequestFlow::MReqFilterData($portal_id, $project_id)
                    ->whereDate('vishwa_material_request_flow.created_date', '>=', $start)
                    ->whereDate('vishwa_material_request_flow.created_date', '<=', $end)
                    ->WhereIn('current_status', [$workflowId->trans_name])
                    ->orwhereNull('current_status')
                    ->get();

            } else {
                $start = date("Y-m-d", strtotime($from_Date));
                $end = date("Y-m-d", strtotime($to_Date));

                $mRequestData = MaterialRequestFlow::MReqFilterData($portal_id, $project_id)
                    ->whereDate('vishwa_material_request_flow.created_date', '>=', $start)
                    ->whereDate('vishwa_material_request_flow.created_date', '<=', $end)
                    ->WhereIn('current_status', [$workflowId->trans_name])
                    ->orwhereNull('current_status')
                    ->get();

            }

            return response()->json($mRequestData);
        }



    public function populateReqDetails(Project $project, Request $request)
    {
        $map_id = $request->input('map_id');
        $qcPassedItems = MaterialRequestItem::where('mreq_no', $map_id)
            ->join('vishwa_materials_item', 'vishwa_material_request_item.item_id', 'vishwa_materials_item.id')
            ->get();

        return response()->json($qcPassedItems);
    }




}
