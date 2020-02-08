<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Project;
use App\Models\GateEntry;
use App\Models\IndentMaster;
use App\Models\QualtiyCheck;
use App\Models\VishwaPurchaseOrder;
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
    public function index(Project $project,Request $request)
    {
        $pro_id=$project->id;


        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        else
        {
            $portal_id= Auth::user()->getEmp->getUserPortal->id;
        }


        $from_Date=$request->input('from_date');
        $to_Date=$request->input('to_date');


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




        if($to_Date == null) {

            $start= date("Y-m-d",strtotime($from_Date));
            $end=$start;


            $gateEntry = GateEntry::leftjoin('vishwa_vendor_challan', 'vishwa_gate_entry_details.challan_no', 'vishwa_vendor_challan.challan_no')
                ->leftjoin('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
                ->select('vishwa_vendor_challan.*', 'vishwa_gate_entry_details.*', 'vishwa_vendor_master.company_name')
                ->where('vishwa_gate_entry_details.portal_id', $portal_id)
                ->where('vishwa_gate_entry_details.project_id', $project->id)
//            ->where('outgoing_time', Null)
                ->whereDate('vishwa_gate_entry_details.incoming_time', [$start, $end])
                ->orderBy('vishwa_gate_entry_details.incoming_time', 'DESC')
                ->get();
        } else {
            $start= date("Y-m-d",strtotime($from_Date));
            $end=date("Y-m-d",strtotime($to_Date));
            $gateEntry = GateEntry::leftjoin('vishwa_vendor_challan', 'vishwa_gate_entry_details.challan_no', 'vishwa_vendor_challan.challan_no')
                ->leftjoin('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
                ->select('vishwa_vendor_challan.*', 'vishwa_gate_entry_details.*', 'vishwa_vendor_master.company_name')
                ->where('vishwa_gate_entry_details.portal_id', $portal_id)
                ->where('vishwa_gate_entry_details.project_id', $project->id)
//            ->where('outgoing_time', Null)
                ->whereBetween('vishwa_gate_entry_details.incoming_time', [$start, $end])
                ->orderBy('vishwa_gate_entry_details.incoming_time', 'DESC')
                ->get();
        }


//        dd($gateEntry,$start,$end);




        return view('projects.quality.index', compact('from_Date','to_Date','project', 'record','vendor_reg','VishwaVendorIndent','gateEntry'));
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
    public function store(Project $project,Request $request)
    {
        $requestData = ($request->all());

        $qcCheck = new QualtiyCheck();

        $qcCheck->emp_id = $requestData['emp_id'];
        $qcCheck->portal_id = $requestData['portal_id'];
        $qcCheck->project_id = $requestData['project_id'];
        $qcCheck->store_id = $requestData['store_id'];
        $qcCheck->indent_id = $requestData['indent_id'];
        $qcCheck->vendor_id = $requestData['vendor_id'];
        $qcCheck->item_id = $requestData['item_id'];
        $qcCheck->unit = $requestData['unit'];
        $qcCheck->qty = $requestData['qty'];
        $qcCheck->date = $requestData['qc_date'];
        $qcCheck->challan_no = $requestData['challan_no'];
        $qcCheck->purchase_order_no = $requestData['purchase_order_no'];
        $qcCheck->driver_name = $requestData['driver_name'];
        $qcCheck->dmobile_no = $requestData['driver_mobile'];
        $qcCheck->as_per_vendor = $requestData['as_per_vendor'];
        $qcCheck->as_per_system = $requestData['as_per_system'];
        $qcCheck->remarks = $requestData['qc_remarks'];
        $qcCheck->challan_bill = $requestData['challan_bill'];

        $qcCheck->save();

        return redirect()->route('qualityCheck.index', $requestData['project_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project,$id)
    {

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function itemShow (Project $project,$challan_no)
    {

        $flag=0;

        $gateEntryChallan = GateEntry::where('challan_no', $challan_no)->first();
        $vendorItem = DB::table('vishwa_vendor_challan')
            ->where('challan_no', $challan_no)
            ->join('vishwa_materials_item','vishwa_vendor_challan.item_id','vishwa_materials_item.id')
            ->where('purchase_order_no', $gateEntryChallan->purchase_order_no)
            ->get();

        if ($vendorItem->isEmpty()) {
            $flag=1;
            $vendorItem = DB::table('vishwa_purchase_order')
                ->join('vishwa_materials_item','vishwa_purchase_order.item_id','vishwa_materials_item.id')
                ->where('purchase_order_no', $gateEntryChallan->purchase_order_no)
                ->get();
        }

//        $gate_Details=GateEntry::where('purchase_order_no')

        return view('projects.quality.qualityCheckItems',compact('flag','vendorItem','project','gateEntryChallan'));
    }
}
