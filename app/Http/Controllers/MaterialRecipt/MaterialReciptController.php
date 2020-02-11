<?php

namespace App\Http\Controllers\MaterialRecipt;

use App\Models\GateEntry;
use App\Models\IndentMaster;
use App\Models\QualityCheck;
use App\Models\VishwaVendorIndentMapping;
use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaVendorsRegistration;
use App\Models\MasterUnit;
use App\Models\MaterialItem;
use App\Models\VishwaStoreInventoryQuantity;
use App\Models\Cities;
use App\Models\VishwaPurchaseOrder;
use App\Models\Portal;
use App\Models\VishwaProjectStore;
use App\Models\VishwaMaterialReceipt;
use App\Http\Controllers\MaterialRecipt;
use App\Entities\Projects\Project;
use App\User;
use App\Models\VishwaChallan;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use Storage;
use Carbon\Carbon;
use Validator;
use Log;
use Auth;
use PDF;
use Uuid;
use Response;

class MaterialReciptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {

        $orderNo = base64_decode($id);


        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
            $projects = Project::where('portal_id', $portal_id)->get();
        }
        if (Auth::user()->user_type == "employee") {


            $portal_id = Auth::user()->getPortal->portal_id;
            $emp_id = Auth::user()->getPortal->id;
            $projects = DB::table('vishwa_projects')
                ->join('vishwa_employee_project_mapping', 'vishwa_projects.id', '=', 'vishwa_employee_project_mapping.project_id')
                ->where('vishwa_employee_project_mapping.portal_id', $portal_id)
                ->where('vishwa_employee_project_mapping.employee_id', $emp_id)
                ->select('vishwa_projects.*')
                ->get();

            //dd($portal_id , $emp_id ,$projects);

        }

        $challan_item = VishwaChallan::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_vendor_challan.item_id')
            ->where('vishwa_vendor_challan.portal_id', $portal_id)
            ->where('vishwa_vendor_challan.purchase_order_no', $orderNo)
            ->get();


        return view('MaterialRecipt.index', compact('projects', 'challan_item'));
    }


    public function pmVerify(Request $request)
    {


        $orderNo = $request->input('pur_ord_no');

        $userVerify = User::where('email', $request->input('loginName'))->first();

        $passwordVerify = Hash::check($request->input('loginPass'), $userVerify->password);

        if ($passwordVerify) {
            if (Auth::user()->user_type == "portal") {
                $portal_id = Auth::user()->getPortal->id;
                $projects = Project::where('portal_id', $portal_id)->get();
            }
            if (Auth::user()->user_type == "employee") {


                $portal_id = Auth::user()->getPortal->portal_id;
                $emp_id = Auth::user()->getPortal->id;
                $projects = DB::table('vishwa_projects')
                    ->join('vishwa_employee_project_mapping', 'vishwa_projects.id', '=', 'vishwa_employee_project_mapping.project_id')
                    ->where('vishwa_employee_project_mapping.portal_id', $portal_id)
                    ->where('vishwa_employee_project_mapping.employee_id', $emp_id)
                    ->select('vishwa_projects.*')
                    ->get();


            }

            $challan_item = VishwaChallan::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_vendor_challan.item_id')
                ->where('vishwa_vendor_challan.portal_id', $portal_id)
                ->join('vishwa_material_receipt', 'vishwa_vendor_challan.challan_no', 'vishwa_material_receipt.challan_no')
                ->where('vishwa_vendor_challan.purchase_order_no', $orderNo)
                ->get();

            $challan_item_first_data = VishwaChallan::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_vendor_challan.item_id')
                ->where('vishwa_vendor_challan.portal_id', $portal_id)
                ->join('vishwa_material_receipt', 'vishwa_vendor_challan.challan_no', 'vishwa_material_receipt.challan_no')
                ->where('vishwa_vendor_challan.purchase_order_no', $orderNo)
                ->first();


            return view('MaterialRecipt.pmVerify', compact('projects', 'challan_item', 'challan_item_first_data'));
        } else {
            return back()->with('error_message', 'Login Id And Password Not Match');
        }

    }


    public function getChallanList(Request $request)
    {


        $dataRequest = $request->input('challan_bill');

        $project_id = $request->input('project');

        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        } else {
            $portal_id = Auth::user()->getEmp->getUserPortal->id;
        }


        $projects = Project::where('portal_id', $portal_id)->get();

        $from_Date = $request->input('from_date');
        $to_Date = $request->input('to_date');


        $record = IndentMaster::Join('users', 'vishwa_indent_masters.created_by', '=', 'users.id')
            ->Join('vishwa_projects', 'vishwa_indent_masters.project_id', '=', 'vishwa_projects.id')
            ->where('vishwa_indent_masters.project_id', $project_id)
            ->select('vishwa_indent_masters.*', 'users.name as user_name')
            ->orderByDesc('id')
            ->get();
        $VishwaVendorIndent = VishwaVendorIndentMapping::where('project_id', $project_id)
            ->where('portal_id', Auth::user()->getPortal->id)
            ->get();
        $vendor_reg = VishwaVendorsRegistration::join('vishwa_portal_vendor_mapping', 'vishwa_vendor_master.id', '=', 'vishwa_portal_vendor_mapping.vendor_id')
            ->where('vishwa_portal_vendor_mapping.portal_id', '=', Auth::user()->getPortal->id)
            ->select('vishwa_vendor_master.*', 'vishwa_portal_vendor_mapping.portal_id as PortalId')
            ->get();

        $gateEntry = '';
        $qualityPass = '';


        if ($dataRequest == 1) {
            if (($to_Date == null) && ($from_Date != null)) {

                $start = date("Y-m-d", strtotime($from_Date));
                $end = $start;

                $gateEntry = GateEntry::GateEntryFilter($portal_id, $project_id)
                    ->whereBetween('vishwa_gate_entry_details.incoming_time', [$start, $end])
                    ->get();
            } else if (($from_Date == null) && ($to_Date == null)) {

                $gateEntry = GateEntry::GateEntryFilter($portal_id, $project_id)
                    ->get();
            } else {
                $start = date("Y-m-d", strtotime($from_Date));
                $end = date("Y-m-d", strtotime($to_Date));
                $gateEntry = GateEntry::GateEntryFilter($portal_id, $project_id)
                    ->get();

            }
        } elseif ($dataRequest == 2) {
            if (($to_Date == null) && ($from_Date != null)) {

                $start = date("Y-m-d", strtotime($from_Date));
                $end = $start;

                $qualityPass = QualityCheck::where('portal_id', $portal_id)
                    ->where('project_id', $project_id)
                    ->whereBetween('date', [$start, $end])
                    ->get();
            } else if (($from_Date == null) && ($to_Date == null)) {
                $qualityPass = QualityCheck::where('portal_id', $portal_id)
                    ->where('project_id', $project_id)
                    ->get();
            } else {
                $start = date("Y-m-d", strtotime($from_Date));
                $end = date("Y-m-d", strtotime($to_Date));
                $qualityPass = QualityCheck::where('portal_id', $portal_id)
                    ->where('project_id', $project_id)
                    ->whereBetween('date', [$start, $end])
                    ->get();


            }
        } else {
            if (($to_Date == null) && ($from_Date != null)) {

                $start = date("Y-m-d", strtotime($from_Date));
                $end = $start;

                $gateEntry = GateEntry::GateEntryFilter($portal_id, $project_id)
                    ->whereBetween('vishwa_gate_entry_details.incoming_time', [$start, $end])
                    ->get();
                $qualityPass = QualityCheck::where('portal_id', $portal_id)
                    ->where('project_id', $project_id)
                    ->whereBetween('date', [$start, $end])
                    ->get();
            } else if (($from_Date == null) && ($to_Date == null)) {
                $gateEntry = GateEntry::GateEntryFilter($portal_id, $project_id)
                    ->get();
                $qualityPass = QualityCheck::where('portal_id', $portal_id)
                    ->where('project_id', $project_id)
                    ->get();
            } else {
                $start = date("Y-m-d", strtotime($from_Date));
                $end = date("Y-m-d", strtotime($to_Date));
                $gateEntry = GateEntry::GateEntryFilter($portal_id, $project_id)
                    ->get();
                $qualityPass = QualityCheck::where('portal_id', $portal_id)
                    ->where('project_id', $project_id)
                    ->whereBetween('date', [$start, $end])
                    ->get();
            }
        }


        return view('MaterialRecipt.challan_list', compact('qualityPass', 'project_id', 'dataRequest', 'projects', 'from_Date', 'to_Date', 'project', 'record', 'vendor_reg', 'VishwaVendorIndent', 'gateEntry'));
    }


    public function getStore(Request $request)
    {


        if (Auth::user()->user_type == "portal") {
            $project_id = $request->input('project_id');
            $projects = VishwaProjectStore::where('project_id', $project_id)->groupBy('vishwa_project_store.store_name')->get();
            return $projects;
        }


        if (Auth::user()->user_type == "employee") {

            $emp_id = Auth::user()->getPortal->id;
            $project_id = $request->input('project_id');
            // $projects = VishwaProjectStore::where('project_id',$project_id)->where('store_keeper_id',$emp_id)->groupBy('vishwa_project_store.store_name')->get();

            $projects = VishwaProjectStore::where('project_id', $project_id)->groupBy('vishwa_project_store.store_name')->get();

            return $projects;
        }

    }

    public function getvendor(Request $request)
    {


        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        if (Auth::user()->user_type == "employee") {
            $portal_id = Auth::user()->getPortal->portal_id;
        }

        $input = $request->all();

        $project_id = $input['project_id'];
        $store_id = $input['store_id'];


        $vendor = VishwaChallan::join('vishwa_vendor_master', 'vishwa_vendor_master.id', 'vishwa_vendor_challan.vendor_id')
            ->where('vishwa_vendor_challan.portal_id', $portal_id)
            ->where('vishwa_vendor_challan.project_id', $project_id)
            ->where('vishwa_vendor_challan.store_id', $store_id)
            ->groupby('vishwa_vendor_master.company_name')
            ->distinct()
            ->get();


        return $vendor;


    }


    public function getChallan(Request $request)
    {

        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        if (Auth::user()->user_type == "employee") {
            $portal_id = Auth::user()->getPortal->portal_id;
        }

        $input = $request->all();


        $project_id = $input['project_id'];
        $store_id = $input['store_id'];
        $vendor_id = $input['vendor_id'];


        $Challan = VishwaChallan::join('vishwa_vendor_master', 'vishwa_vendor_master.id', 'vishwa_vendor_challan.vendor_id')
            ->leftjoin('vishwa_material_receipt', 'vishwa_material_receipt.challan_no', 'vishwa_vendor_challan.challan_no')
            ->where('vishwa_vendor_challan.portal_id', $portal_id)
            ->where('vishwa_vendor_challan.vendor_id', $vendor_id)
            ->where('vishwa_vendor_challan.project_id', $project_id)
            ->where('vishwa_vendor_challan.store_id', $store_id)
            ->groupby('challan_no')
            ->distinct()
            ->select('vishwa_material_receipt.challan_no as challan_inv', 'vishwa_vendor_master.*', 'vishwa_vendor_challan.*')
            ->get();


        return $Challan;


    }


    public function getChallanItem(Request $request)
    {

        // dd($request->all());

        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        if (Auth::user()->user_type == "employee") {
            $portal_id = Auth::user()->getPortal->portal_id;
        }

        $input = $request->all();
        $project_id = $input['project'];
        $store_id = $input['stores'];
        $vendor_id = $input['vendor'];
        $Challan = $input['Challan'];
        $projects = Project::where('portal_id', $portal_id)->get();


        $challan_item = VishwaChallan::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_vendor_challan.item_id')
            ->where('vishwa_vendor_challan.portal_id', $portal_id)
            ->where('vishwa_vendor_challan.project_id', $project_id)
            ->where('vishwa_vendor_challan.vendor_id', $vendor_id)
            ->where('vishwa_vendor_challan.store_id', $store_id)
            ->where('vishwa_vendor_challan.challan_no', $Challan)
            ->get();


        return view('MaterialRecipt.index', compact('challan_item', 'projects'));

    }


    public function verifyByProjectManager(Request $request)
    {

        $challan_no = $request->input('challan_for_pdf');
        $verifyDate = date('Y-m-d H:i:s');

        $mrExist = VishwaMaterialReceipt::where('challan_no', $challan_no)->update(['pm_verify' => 1, 'pm_verify_date' => $verifyDate]);

        $mrPoNO = VishwaMaterialReceipt::where('challan_no', $challan_no)->first();

        $po_no = base64_encode($mrPoNO->po_no);


        return redirect()->route('MaterialRecipt.challan_list');

    }


    public function StoreToInward(Request $request)
    {

        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        if (Auth::user()->user_type == "employee") {
            $portal_id = Auth::user()->getPortal->portal_id;
        }
        $input = $request->all();

//        $mr_reciept = $request->input('mr_reciept');
        $Remarks = $request->input('Remarks');
        $item = $request->input('item');
        $quantity = $request->input('quantity');
        $project_id = $request->input('project_id');
        $challan_no = $request->input('challan_no');
        $challan_for_pdf = $request->input('challan_for_pdf');
        $vendor_for_pdf = $request->input('vendor_for_pdf');
        $store = $request->input('store_id');
        $po = $request->input('po');

        $mr_date_get = $request->input('mr_date');
//        $date = new Carbon(str_replace('/', '-', $mr_date_get));
        $mr_date = date('Y-m-d', strtotime($mr_date_get));


        $mr_incre = VishwaMaterialReceipt::orderByDesc('id')->pluck('id')->first();


        if (!$mr_incre) {
            $mrIncrement = 0;
        } else {
            $mrIncrement = intval($mr_incre);
        }

        $mr_receipt_no = "MRec_No" . str_pad($mrIncrement + 1, 7, '0', STR_PAD_LEFT);


        $form_no = $request->input('form_no');
        $gate_entry = $request->input('gate_entry');


        $arrival_time_get = $request->input('arrival_time');
        $arrival_time = date("H:i", strtotime($arrival_time_get));


        $master_ledger_folio_no = $request->input('master_ledger_folio_no');


        $form_data = array_combine($item, $quantity);


        $pdf_file_name = Uuid::generate()->string;

        $entryAlreadyExist=VishwaMaterialReceipt::where('challan_no',$challan_for_pdf)->first();

        if($entryAlreadyExist!=null)
        {
            return redirect()->back();
        }

        if ($item != null) {

            DB::beginTransaction();

            try {


                foreach ($item as $key => $value) {
                    $VishwaMaterialReceipt = new VishwaMaterialReceipt();
                    $VishwaMaterialReceipt->mr_no = $mr_receipt_no;
                    $VishwaMaterialReceipt->portal_id = $portal_id;
                    $VishwaMaterialReceipt->item_id = $item[$key];
                    $VishwaMaterialReceipt->project_id = $project_id[$key];
                    $VishwaMaterialReceipt->store_id = $store[$key];
                    $VishwaMaterialReceipt->challan_no = $challan_no[$key];
                    $VishwaMaterialReceipt->po_no = $po;
                    $VishwaMaterialReceipt->form_no = $form_no;
                    $VishwaMaterialReceipt->material_reciept_date = $mr_date;
                    $VishwaMaterialReceipt->arrival_time = $arrival_time;
                    $VishwaMaterialReceipt->gate_number = $gate_entry;
                    $VishwaMaterialReceipt->master_ledger_folio_no = $master_ledger_folio_no;
                    $VishwaMaterialReceipt->recieve_qty = $quantity[$key];
                    $VishwaMaterialReceipt->remarks = $Remarks[$key];
                    $VishwaMaterialReceipt->pdf_file_name = $pdf_file_name;
                    $VishwaMaterialReceipt->save();
                }

                foreach ($item as $key => $value) {

                    $VishwaStoreInventoryQuantity = new VishwaStoreInventoryQuantity();
                    $VishwaStoreInventoryQuantity->mr_no = $mr_receipt_no;
                    $VishwaStoreInventoryQuantity->portal_id = $portal_id;
                    $VishwaStoreInventoryQuantity->item_id = $item[$key];
                    $group_id = MaterialItem::where('id', $item[$key])->pluck('group_id')->first();
                    $VishwaStoreInventoryQuantity->group_id = $group_id;
                    $VishwaStoreInventoryQuantity->project_id = $project_id[$key];
                    $VishwaStoreInventoryQuantity->store_id = $store[$key];
                    $VishwaStoreInventoryQuantity->challan_no = $challan_no[$key];
                    $VishwaStoreInventoryQuantity->qty = $quantity[$key];
                    $VishwaStoreInventoryQuantity->save();
                }


                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }

        }


        if ($challan_for_pdf != null) {

            $pdf_data = VishwaChallan::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_vendor_challan.item_id')
                ->join('vishwa_vendor_master', 'vishwa_vendor_master.id', 'vishwa_vendor_challan.vendor_id')
                ->join('vishwa_projects', 'vishwa_projects.id', 'vishwa_vendor_challan.project_id')
                ->where('vishwa_vendor_challan.challan_no', $challan_for_pdf)
                ->get();


            $vendor_data = VishwaChallan::join('vishwa_vendor_master', 'vishwa_vendor_master.id', 'vishwa_vendor_challan.vendor_id')
                ->join('vishwa_portals', 'vishwa_portals.id', 'vishwa_vendor_challan.portal_id')
                ->join('vishwa_states', 'vishwa_states.id', 'vishwa_portals.state')
                ->join('vishwa_project_store', 'vishwa_project_store.id', 'vishwa_vendor_challan.store_id')
                ->join('vishwa_projects', 'vishwa_projects.id', 'vishwa_vendor_challan.project_id')
                ->where('vishwa_vendor_challan.challan_no', $challan_for_pdf)
                ->select('vishwa_vendor_master.company_name as vendor_com_name', 'vishwa_vendor_master.*', 'vishwa_vendor_challan.*', 'vishwa_states.name as state_name', 'vishwa_portals.*', 'vishwa_projects.name as project_name', 'vishwa_project_store.store_name')
                ->first();


            $pdf = PDF::loadView('MaterialRecipt.MaterialReciptPDF', compact('item', 'vendor_data', 'form_data', 'mr_date', 'form_no', 'gate_entry', 'arrival_time', 'master_ledger_folio_no', 'mr_receipt_no'));

            Storage::put('public/pdf/storage/MaterialReciptPDF' . $pdf_file_name . '.pdf', $pdf->output());

            return $pdf->download('purchase.pdf');

        }
        return redirect()->route('MaterialRecipt.challan_list');

    }


    public function ReciptView(Request $request)
    {

        $dt = Carbon::now();
        $date = $dt->toDateString();

        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        if (Auth::user()->user_type == "employee") {
            $portal_id = Auth::user()->getPortal->portal_id;
        }

        $MaterialReciptData = null;


        $projects = Project::where('portal_id', $portal_id)->get();


        $MaterialReciptData = VishwaMaterialReceipt::
        whereDate('vishwa_material_receipt.material_reciept_date', '>=', $date)
            ->where('vishwa_material_receipt.portal_id', '=', $portal_id)
            ->groupBy('vishwa_material_receipt.challan_no')
            ->get();


        return view('MaterialRecipt.RecieptView', compact('MaterialReciptData', 'projects', 'MaterialReciptData'));

    }

    public function MaterialRecieptData(Request $request)
    {


        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        if (Auth::user()->user_type == "employee") {
            $portal_id = Auth::user()->getPortal->portal_id;
        }


        $input = $request->all();
//        $date2 = new Carbon(str_replace('/', '-', $input['from_date']));
        $from_date = date('Y-m-d', strtotime($request->input('from_date')));

//        $date1 = new Carbon(str_replace('/', '-', $input['to_date']));
        $to_date = date('Y-m-d', strtotime($request->input('to_date')));


        $MaterialReciptData = VishwaMaterialReceipt::
        whereDate('vishwa_material_receipt.material_reciept_date', '>=', $from_date)
            ->whereDate('vishwa_material_receipt.material_reciept_date', '<=', $to_date)
            ->where('vishwa_material_receipt.portal_id', '=', $portal_id)
            ->groupBy('vishwa_material_receipt.challan_no')
            ->get();


        //s dd($MaterialReciptData);


        return view('MaterialRecipt.RecieptView', compact('MaterialReciptData'));
    }


    public function DownloadMaterialReciept(Request $request)
    {

        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        if (Auth::user()->user_type == "employee") {
            $portal_id = Auth::user()->getPortal->portal_id;
        }


        $input = $request->all();
        $pdf = $input['pdf'];


        $myFile = public_path("/storage/pdf/storage/MaterialReciptPDF/" . $pdf . ".pdf");
        $headers = ['Content-Type: application/pdf'];
        $newName = 'MaterialRecipt.pdf';


        return response()->download($myFile, $newName, $headers);


    }


    public function getMaterialRecieptItem(Request $request)
    {

        $portal_id = Auth::user()->getPortal->id;
        $input = $request->all();
        $purchase_order_no = trim($input['po_no']);
        $project_id = $input['project_id'];
        $challan_no = $input['challan_no'];


        $MaterialReciptItem = VishwaMaterialReceipt::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_material_receipt.item_id')
            ->join('vishwa_unit_masters', 'vishwa_materials_item.material_unit', 'vishwa_unit_masters.id')
            ->where('challan_no', trim($challan_no))
            ->where('po_no', $purchase_order_no)
            ->where('project_id', $project_id)
            ->where('portal_id', $portal_id)
            ->get();

        $pdf_data = VishwaChallan::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_vendor_challan.item_id')
            ->join('vishwa_vendor_master', 'vishwa_vendor_master.id', 'vishwa_vendor_challan.vendor_id')
            ->join('vishwa_projects', 'vishwa_projects.id', 'vishwa_vendor_challan.project_id')
            ->where('vishwa_vendor_challan.challan_no', $challan_no)
            ->get();


        $vendor_data = VishwaChallan::join('vishwa_vendor_master', 'vishwa_vendor_master.id', 'vishwa_vendor_challan.vendor_id')
            ->join('vishwa_portals', 'vishwa_portals.id', 'vishwa_vendor_challan.portal_id')
            ->join('vishwa_states', 'vishwa_states.id', 'vishwa_portals.state')
            ->join('vishwa_project_store', 'vishwa_project_store.id', 'vishwa_vendor_challan.store_id')
            ->join('vishwa_projects', 'vishwa_projects.id', 'vishwa_vendor_challan.project_id')
            ->where('vishwa_vendor_challan.challan_no', $challan_no)
            ->select('vishwa_vendor_master.company_name as vendor_com_name', 'vishwa_vendor_master.*', 'vishwa_vendor_challan.*', 'vishwa_states.name as state_name', 'vishwa_portals.*', 'vishwa_projects.name as project_name', 'vishwa_project_store.store_name')
            ->first();


        $EachMaterialReciptItem = VishwaMaterialReceipt::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_material_receipt.item_id')
            ->where('challan_no', trim($challan_no))
            ->where('po_no', $purchase_order_no)
            ->where('project_id', $project_id)
            ->where('portal_id', $portal_id)
            ->first();


        return view('MaterialRecipt.RecieptViewItem', compact('purchase_order_no', 'MaterialReciptItem', 'vendor_data', 'pdf_data', 'EachMaterialReciptItem'));

    }

//    public function masterStore()
//    {
//        $portal_id = Auth::user()->getPortal->id;
//        $stores = VishwaProjectStore::join('vishwa_projects','vishwa_projects.id','vishwa_project_store.project_id')
//        ->where('vishwa_project_store.portal_id',$portal_id)->get();
//        return view('MaterialRecipt.masterStore_list' ,compact('stores'));
//    }


}