<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Project;
use App\Models\GateEntry;
use App\Models\IndentMaster;
use App\Models\QualityCheck;
use App\Models\VishwaPurchaseOrder;
use App\Models\VishwaQualityCheckItem;
use App\Models\VishwaVendorIndentMapping;
use App\Models\VishwaVendorsRegistration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class QualityCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project, Request $request)
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


            $gateEntry = GateEntry::leftjoin('vishwa_vendor_challan', 'vishwa_gate_entry_details.challan_no', 'vishwa_vendor_challan.challan_no')
                ->leftjoin('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
                ->select('vishwa_vendor_challan.*', 'vishwa_gate_entry_details.*', 'vishwa_vendor_master.company_name')
                ->where('vishwa_gate_entry_details.portal_id', $portal_id)
                ->where('vishwa_gate_entry_details.project_id', $project->id)
                ->whereDate('vishwa_gate_entry_details.incoming_time', '>=', $start)
                ->whereDate('vishwa_gate_entry_details.incoming_time', '<=', $end)
                ->orderBy('vishwa_gate_entry_details.incoming_time', 'DESC')
                ->get();
        } else {
            $start = date("Y-m-d", strtotime($from_Date));
            $end = date("Y-m-d", strtotime($to_Date));
            $gateEntry = GateEntry::leftjoin('vishwa_vendor_challan', 'vishwa_gate_entry_details.challan_no', 'vishwa_vendor_challan.challan_no')
                ->leftjoin('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
                ->select('vishwa_vendor_challan.*', 'vishwa_gate_entry_details.*', 'vishwa_vendor_master.company_name')
                ->where('vishwa_gate_entry_details.portal_id', $portal_id)
                ->where('vishwa_gate_entry_details.project_id', $project->id)
                ->whereDate('vishwa_gate_entry_details.incoming_time', '>=', $start)
                ->whereDate('vishwa_gate_entry_details.incoming_time', '<=', $end)
                ->orderBy('vishwa_gate_entry_details.incoming_time', 'DESC')
                ->get();
        }




        return view('projects.quality.index', compact('from_Date', 'to_Date', 'project', 'record', 'vendor_reg', 'VishwaVendorIndent', 'gateEntry'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project, Request $request)
    {
        $requestData = ($request->all());

//        dd($requestData);
//        $qcCheck = new QualityCheck();
//
//        $qcCheck->emp_id = $requestData['emp_id'];
//        $qcCheck->portal_id = $requestData['portal_id'];
//        $qcCheck->project_id = $requestData['project_id'];
//        $qcCheck->store_id = $requestData['store_id'];
//        $qcCheck->indent_id = $requestData['indent_id'];
//        $qcCheck->vendor_id = $requestData['vendor_id'];
//        $qcCheck->item_id = $requestData['item_id'];
//        $qcCheck->unit = $requestData['unit'];
//        $qcCheck->qty = $requestData['qty'];
//        $qcCheck->date = $requestData['qc_date'];
//        $qcCheck->challan_no = $requestData['challan_no'];
//        $qcCheck->purchase_order_no = $requestData['purchase_order_no'];
//        $qcCheck->driver_name = $requestData['driver_name'];
//        $qcCheck->dmobile_no = $requestData['driver_mobile'];
//        $qcCheck->as_per_vendor = $requestData['as_per_vendor'];
//        $qcCheck->as_per_system = $requestData['as_per_system'];
//        $qcCheck->remarks = $requestData['qc_remarks'];
//        $qcCheck->challan_bill = $requestData['challan_bill'];
//
//        $qcCheck->save();


        $items = ($request->input('item_id'));

        $portal_id = $request->input('portal_id');
        $project_id = $request->input('project_id');
        $emp_id = $request->input('emp_id');
        $store_id = $request->input('store_id');
        $indent_id = $request->input('indent_id');
        $vendor_id = $request->input('vendor_id');
        $purchase_order_no = $request->input('purchase_order_no');
        $date = date('Y-m-d H:i:s');
        $challan_no = $request->input('challan_no');
        $driver_name = $request->input('driver_name');
        $dmobile_no = $request->input('dmobile_no');
//        $qc_status = $request->input('qc_status');
        $as_per_system = $request->input('as_per_vendor');
        $unit = $request->input('unit');
        $qty = $request->input('qty');
        $as_per_vendor = $request->input('as_per_system');
        $challan_bill = $request->input('challan_bill');
        $remarks = $request->input('qc_remarks');
        DB::beginTransaction();

        try {

            $qualityCheck = new QualityCheck();
            $qualityCheck->portal_id = $portal_id;
            $qualityCheck->project_id = $project_id;
            $qualityCheck->emp_id = $emp_id;
            $qualityCheck->store_id = $store_id;
            $qualityCheck->indent_id = $indent_id;
            $qualityCheck->vendor_id = $vendor_id;
            $qualityCheck->purchase_order_no = $purchase_order_no;
            $qualityCheck->challan_no = $challan_no;
            $qualityCheck->driver_name = $driver_name;
            $qualityCheck->dmobile_no = $dmobile_no;
            $qualityCheck->qc_status = 'checked';
            $qualityCheck->date = $date;
            $qualityCheck->challan_bill = $challan_bill;
            $qualityCheck->remarks = $remarks;
            $qualityCheck->save();


            $qualityCheckLastId = QualityCheck::orderBy('id', 'DESC')->first();

            foreach ($items as $key => $item) {
                $qualityCheckItems = new VishwaQualityCheckItem();
                $qualityCheckItems->quality_map_id = $qualityCheckLastId->id;
                $qualityCheckItems->unit = $unit[$key];
                $qualityCheckItems->item_id = $item;
                $qualityCheckItems->qty = $qty[$key];
                $qualityCheckItems->as_per_system = $as_per_system[$key];
                $qualityCheckItems->as_per_vendor = $as_per_vendor[$key];
                $qualityCheckItems->save();
            }


            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }


        return redirect()->route('qualityCheck.index', $requestData['project_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, $id)
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function itemShow(Project $project, $challan_no)
    {

        $flag = 0;


        $gateEntryChallan = GateEntry::where('challan_no', $challan_no)->first();
        $vendorItem = DB::table('vishwa_vendor_challan')
            ->where('challan_no', $challan_no)
            ->join('vishwa_materials_item', 'vishwa_vendor_challan.item_id', 'vishwa_materials_item.id')
            ->where('purchase_order_no', $gateEntryChallan->purchase_order_no)
            ->get();

        if ($vendorItem->isEmpty()) {
            $flag = 1;
            $vendorItem = DB::table('vishwa_purchase_order')
                ->join('vishwa_materials_item', 'vishwa_purchase_order.item_id', 'vishwa_materials_item.id')
                ->where('purchase_order_no', $gateEntryChallan->purchase_order_no)
                ->get();

        }

        if (Auth::user()->user_type == 'portal') {
            $emp_id = Auth::user()->getPortal->id;
        } else {
            $emp_id = $portal_id = Auth::user()->getEmp->id;
        }


        $qcCheckedEntry=QualityCheck::where('challan_no',$challan_no)
            ->join('vishwa_quality_check_items','vishwa_quality_check.id','vishwa_quality_check_items.quality_map_id')
            ->get();

//        $gate_Details=GateEntry::where('purchase_order_no')
//        dd($qcCheckedEntry->isNotEmpty());

        return view('projects.quality.qualityCheckItems', compact('qcCheckedEntry','challan_no','emp_id', 'flag', 'vendorItem', 'project', 'gateEntryChallan'));
    }
}
