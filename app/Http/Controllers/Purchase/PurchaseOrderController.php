<?php

namespace App\Http\Controllers\Purchase;

use App\Models\IndentMaster;
use App\Models\ViewBillItems;
use App\Models\VishwaGroupType;
use App\Models\VishwaIndentVendorsPrice;
use App\Models\VishwaNonRentablePrice;
use App\Models\VishwaPurchaseOrderItem;
use App\Models\VishwaRentablePrice;
use App\Models\VishwaVendorChallanItem;
use function GuzzleHttp\Psr7\str;
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
use App\Models\VishwaChallan;
use App\Models\ViewBill;
use App\Entities\Projects\Project;
use App\User;
use Session;
use DB;
use Carbon\Carbon;
use Validator;
use Log;
use Auth;
use PDF;
use Response;

class PurchaseOrderController extends Controller
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
    public function index()
    {
        $id = Auth::user()->id;
        $emp_id = null;
        $dt = Carbon::now();
        $date = $dt->toDateString();
        $challanData = '';
        $billData = '';
        if (Auth::user()->user_type == "vendor") {
            $vendorId = Auth::user()->getVendor->id;
            $reuslt = Auth::user()->getPortal->getPortalMap->pluck("portal_id")->toArray();
            $purchaseData = VishwaPurchaseOrder::join('vishwa_indent_vendor_price', 'vishwa_purchase_order.indent_id', 'vishwa_indent_vendor_price.indent_id')
                ->join('vishwa_vendor_master', 'vishwa_purchase_order.vendor_id', 'vishwa_vendor_master.id')
                ->whereDate('vishwa_purchase_order.date', '=', $date)
                ->where('vishwa_purchase_order.vendor_id', '=', $vendorId)
                ->groupBy('vishwa_purchase_order.purchase_order_no')
                ->orderBy('purchase_indent_id', 'desc')
                ->select('vishwa_vendor_master.company_name', 'vishwa_purchase_order.indent_id as purchase_indent_id', 'vishwa_purchase_order.*')
                ->get();

        } else {
            $result = Portal::where('user_id', $id)->get()->pluck("id")->toArray();
            $purchaseData = VishwaPurchaseOrder::join('vishwa_indent_vendor_price', 'vishwa_purchase_order.indent_id', 'vishwa_indent_vendor_price.indent_id')
                ->join('vishwa_vendor_master', 'vishwa_purchase_order.vendor_id', 'vishwa_vendor_master.id')
                ->whereDate('vishwa_purchase_order.date', '=', $date)
                ->where('vishwa_purchase_order.portal_id', '=', $result)
                ->groupBy('vishwa_purchase_order.purchase_order_no')
                ->orderBy('purchase_indent_id', 'desc')
                ->select('vishwa_vendor_master.company_name', 'vishwa_purchase_order.indent_id as purchase_indent_id', 'vishwa_purchase_order.*')
                ->get();
        }

        return view('Purchase.index', compact('purchaseData', 'date', 'challanData', 'billData', 'result'));
    }

    public function vendorChallan(Request $request)
    {

        $input = $request->all();
        $purchase_order_no = trim($input['purchase_order_no']);
        $portal_id = $input['portal_id'];
        $indent_no = $input['indent_no'];
        $vendor_id = Auth::user()->getVendor->id;

        $getChallan = VishwaPurchaseOrder::join('vishwa_purchase_order_item', 'vishwa_purchase_order.id', 'vishwa_purchase_order_item.order_map_id')
            ->where('vendor_id', $vendor_id)
            ->where('portal_id', $portal_id)
            ->where('purchase_order_no', trim($purchase_order_no))
            ->where('project_id','!=',null)
            ->get();


        $chkChallanNumber = VishwaChallan::join('vishwa_vendor_challan_item', 'vishwa_vendor_challan.id', 'vishwa_vendor_challan_item.challan_map_id')
        ->where('portal_id', $portal_id)
            ->where('vendor_id', $vendor_id)
            ->where('purchase_order_no', trim($purchase_order_no))
            ->get();

        if($getChallan->isEmpty())
        {
            return back()->withErrors('No Item in Challan');
        }

        return view('vendor-user.VendorPrice.vendor_challan', compact('getChallan', 'chkChallanNumber'));

    }

    public function ChallanOrderNumber(Request $request)
    {
        $indent_id = $request->input('indent_id');
        $vendor_id = Auth::user()->getVendor->id;
        $item_id = $request->input('item_id');
        $unit = $request->input('unit');
        $qty = $request->input('qty');
        $store_id = $request->input('store_id');
        $project_id = $request->input('project_id');
        $challan_no = trim($request->input('challan_no'));

        $challan = DB::table('vishwa_vendor_challan')->orderByDesc('id')->pluck('id')->first();
        if (!$challan) {
            $indentIncrement = 0;
        } else {
            $indentIncrement = intval($challan);
        }
        $unique_challan_no = $challan_no . "CHA" . str_pad($indentIncrement + 1, 2, '0', STR_PAD_LEFT);
        $truck_no = trim($request->input('tracker_no'));
        $driver_name = trim($request->input('driver_name'));
        $dmobile_no = trim($request->input('dmobile_no'));
        $purchase_order_no = trim($request->input('purchase_order_no'));
        $portal_id = $request->input('portal_id');
        $date = $request->input('date');


        DB::beginTransaction();

        try {

            $VishwaChallan = new VishwaChallan();
            $VishwaChallan->vendor_id = $vendor_id;
            $VishwaChallan->portal_id = $portal_id;
            $VishwaChallan->project_id = $project_id;
            $VishwaChallan->indent_id = $indent_id;
            $VishwaChallan->challan_no = $unique_challan_no;
            $VishwaChallan->store_id = $store_id;
            $VishwaChallan->truck_no = $truck_no;
            $VishwaChallan->driver_name = $driver_name;
            $VishwaChallan->dmobile_no = $dmobile_no;
            $VishwaChallan->date = date('Y-m-d', strtotime($date));
            $VishwaChallan->purchase_order_no = $purchase_order_no;
            $VishwaChallan->save();


            foreach ($item_id as $key => $value) {
                $VishwaChallanItem = new VishwaVendorChallanItem();
                $VishwaChallanItem->challan_map_id = $VishwaChallan->id;
                $VishwaChallanItem->item_id = $value;
                $VishwaChallanItem->unit = $unit[$key];
                $VishwaChallanItem->qty = $qty[$key];
                $VishwaChallanItem->save();
            }

            $purchaseData = VishwaPurchaseOrder::where('indent_id', $indent_id)->first();
            $workflow = Controller::getPoWorkFlow($purchaseData, 'Po Flow');
            $purchaseData->toCheckStage($workflow, $purchaseData);
            $purchaseData->toChangeStage($workflow, $purchaseData);

            DB::commit();
            Session::flash('success_message', 'Challan Number Successfully Generated Go to The  View Challan Number Tabs!');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error_message', 'Challan Number Cannot Generated Due to Some Wrong Data!');
        }

        return redirect()->route('getChallanindex');
    }


    public function getChallanindex()
    {
        $id = Auth::user()->id;
        $dt = Carbon::now();
        $date = $dt->toDateString();

        $emp_id = null;
        $purchaseData = null;
        if (Auth::user()->user_type == "vendor") {
            $reuslt = Auth::user()->getPortal->getPortalMap->pluck("portal_id")->toArray();

        } else {
            $reuslt = Portal::where('user_id', $id)->get()->pluck("id")->toArray();
        }


        $vendorId = Auth::user()->getVendor->id;
        $purchaseData = VishwaPurchaseOrder::ChallanData($date, $vendorId)->get();


        return view('vendor-user.VendorPrice.vendor_challan_pdf', compact('projects', 'purchaseData'));

    }


    public function getChallanData(Request $request)
    {

        $id = Auth::user()->id;
        $emp_id = null;
        if (Auth::user()->user_type == "vendor") {
            $reuslt = Auth::user()->getPortal->getPortalMap->pluck("portal_id")->toArray();
        }

        $input = $request->all();
        // $project_id = $input['project'];
        $date2 = new Carbon(str_replace('/', '-', $input['from_date']));
        $from_date = date('Y-m-d', strtotime($date2));

        $date1 = new Carbon(str_replace('/', '-', $input['to_date']));
        $to_date = date('Y-m-d', strtotime($date1));

        // $projects = Project::whereIn('portal_id',$reuslt)->get();


        if (Auth::user()->user_type == "vendor") {

            $vendorId = Auth::user()->getVendor->id;
            $purchaseData = VishwaChallan::join('vishwa_purchase_order', 'vishwa_vendor_challan.purchase_order_no', 'vishwa_purchase_order.purchase_order_no')
                ->join('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
                ->whereDate('vishwa_vendor_challan.created_at', '>=', $from_date)
                ->whereDate('vishwa_vendor_challan.created_at', '<=', $to_date)
                ->where('vishwa_vendor_challan.vendor_id', '=', $vendorId)
                ->orderBy('vishwa_vendor_challan.indent_id', 'desc')
                ->select('vishwa_vendor_challan.*', 'vishwa_vendor_master.company_name')
                ->get();


        }


        return view('vendor-user.VendorPrice.vendor_challan_pdf', compact('projects', 'purchaseData'));
        //return view('getChallanindex',compact('purchaseData','projects'));
    }


    public function getPurchaseData(Request $request)
    {
        $id = Auth::user()->id;
        $emp_id = null;
        $currentPurchaseData = null;
        $challanData = '';
        $billData = '';

        if (Auth::user()->user_type == "vendor") {
            $result = Auth::user()->getPortal->getPortalMap->pluck("portal_id")->toArray();
        } else {
            $result = Portal::where('user_id', $id)->get()->pluck("id")->toArray();
        }

        $input = $request->all();
        $dt = Carbon::now();
        $date = $dt->toDateString();
        $from_date = date('Y-m-d', strtotime($input['from_date']));
        $to_date = date('Y-m-d', strtotime($input['to_date']));

        if (Auth::user()->user_type == "vendor") {
            $vendorId = Auth::user()->getVendor->id;

            $purchaseData = VishwaPurchaseOrder::FilterPurchaseData($to_date, $from_date)
                ->where('vishwa_purchase_order.vendor_id', '=', $vendorId)
                ->select('vishwa_indent_vendor_price.*', 'vishwa_vendor_master.company_name', 'vishwa_purchase_order.indent_id as purchase_indent_id',
                    'vishwa_purchase_order.*')
                ->get();

        } else {
            $purchaseData = VishwaPurchaseOrder::join('vishwa_indent_vendor_price', 'vishwa_purchase_order.indent_id', 'vishwa_indent_vendor_price.indent_id')
                ->join('vishwa_vendor_master', 'vishwa_purchase_order.vendor_id', 'vishwa_vendor_master.id')
                ->whereDate('vishwa_purchase_order.date', '>=', $from_date)
                ->whereDate('vishwa_purchase_order.date', '<=', $to_date)
                ->orderBy('vishwa_purchase_order.indent_id', 'desc')
//                ->join('vishwa_employee_profile', 'vishwa_purchase_order.emp_id', 'vishwa_employee_profile.id')
                ->where('vishwa_purchase_order.portal_id', '=', $result[0])
                ->where('vishwa_purchase_order.project_id', '!=', null)
                ->select('vishwa_indent_vendor_price.*', 'vishwa_vendor_master.company_name',
                    'vishwa_purchase_order.indent_id as purchase_indent_id', 'vishwa_purchase_order.*')
                ->get();

        }


        return view('Purchase.index', compact('purchaseData', 'projects', 'PurchaseData', 'date', 'challanData', 'billData'));
    }

    public function ViewAndDownloadPDF(Request $request)
    {


        $input = $request->all();
        $purchase_order_no = trim($input['purchase_order_no']);
        $portal_id = $input['portal_id'];
        $indent_no = $input['indent_no'];
        $voucher_no = $input['voucher_no'];
        $vendor_id = $input['vendor_id'];
        $invoice_to_data = Portal::join('vishwa_states', 'vishwa_portals.state', 'vishwa_states.id')
            ->where('vishwa_portals.id', $portal_id)->first();
        $supplier_data = VishwaPurchaseOrder::
        join('vishwa_vendor_master', 'vishwa_purchase_order.vendor_id', 'vishwa_vendor_master.id')
            ->join('vishwa_states', 'vishwa_vendor_master.state', 'vishwa_states.id')
            ->join('vishwa_cities', 'vishwa_vendor_master.city', 'vishwa_cities.id')
            ->where('vishwa_purchase_order.purchase_order_no', '=', $purchase_order_no)
            ->where('vishwa_purchase_order.portal_id', $portal_id)
            ->select('vishwa_states.name as statename', 'vishwa_states.gstcode', 'vishwa_vendor_master.*', 'vishwa_cities.name as cityname', 'vishwa_purchase_order.date')
            ->first();


        $getIndentType = VishwaIndentVendorsPrice::where('indent_id', $indent_no)->first();
        $getGroupTypeOne = VishwaRentablePrice::where('indent_map_id', $getIndentType->id)->first();
        $getGroupTypeTwo = VishwaNonRentablePrice::where('indent_map_id', $getIndentType->id)->first();


        if ($getGroupTypeOne != null) {

            $items = VishwaPurchaseOrder::join('vishwa_purchase_order_item', 'vishwa_purchase_order.id', 'vishwa_purchase_order_item.order_map_id')
                ->join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_purchase_order_item.item_id')
                ->join('vishwa_indent_vendor_price', 'vishwa_purchase_order.indent_id', 'vishwa_indent_vendor_price.indent_id')
                ->join('vishwa_indent_vendor_rentable_price', 'vishwa_purchase_order.item_id', 'vishwa_indent_vendor_rentable_price.item_id')
                ->where('vishwa_purchase_order.purchase_order_no', '=', $purchase_order_no)
                ->where('vishwa_indent_vendor_price.indent_id', '=', $indent_no)
                ->where('vishwa_indent_vendor_price.vendor_id', '=', $vendor_id)
                ->where('vishwa_purchase_order.portal_id', $portal_id)
//                ->select('vishwa_materials_item.*', 'vishwa_indent_vendor_rentable_price.price', 'vishwa_indent_vendor_price.tax_rate', 'vishwa_purchase_order.*', 'vishwa_indent_vendor_price.freight', 'vishwa_indent_vendor_price.loading', 'vishwa_indent_vendor_price.kpcharges')
                ->get();

        }

        if ($getGroupTypeTwo != null) {

            $items = VishwaPurchaseOrder::join('vishwa_purchase_order_item', 'vishwa_purchase_order.id', 'vishwa_purchase_order_item.order_map_id')
            ->join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_purchase_order_item.item_id')
                ->join('vishwa_indent_vendor_price', 'vishwa_purchase_order.indent_id', 'vishwa_indent_vendor_price.indent_id')
                ->join('vishwa_indent_vendor_non_rentable_price', 'vishwa_indent_vendor_price.id', 'vishwa_indent_vendor_non_rentable_price.indent_map_id')
//                ->join('vishwa_indent_vendor_non_rentable_price', 'vishwa_purchase_order.item_id', 'vishwa_indent_vendor_non_rentable_price.item_id')
                ->where('vishwa_purchase_order.purchase_order_no', '=', $purchase_order_no)
                ->where('vishwa_indent_vendor_price.indent_id', '=', $indent_no)
                ->where('vishwa_indent_vendor_price.vendor_id', '=', $vendor_id)
                ->where('vishwa_purchase_order.portal_id', $portal_id)
//                ->select('vishwa_materials_item.*', 'vishwa_indent_vendor_non_rentable_price.price', 'vishwa_indent_vendor_non_rentable_price.tax_rate', 'vishwa_purchase_order.*', 'vishwa_indent_vendor_price.freight', 'vishwa_indent_vendor_price.loading', 'vishwa_indent_vendor_price.kpcharges')
                ->get();
        }

        if ($items->isEmpty()) {
            return back()->withErrors('No Items are In Purchase Order');
        }

        $pdf = PDF::loadView('Purchase.pdf', compact('projects', 'voucher_no', 'purchaseData', 'purchase_order_no', 'invoice_to_data', 'supplier_data', 'items', 'portal_id', 'indent_no'));
        return $pdf->download('purchase.pdf');

    }


    public function ChallanViewAndDownloadPDF(Request $request)
    {
        $vendorId = Auth::user()->getVendor->id;
        $input = $request->all();
        $purchase_order_no = trim($input['purchase_order_no']);
        $portal_id = $input['portal_id'];
        $indent_no = $input['indent_no'];
        $challan_no = trim($input['challan_no']);

        $item = VishwaChallan::join('vishwa_vendor_challan_item', 'vishwa_vendor_challan.id', 'vishwa_vendor_challan_item.challan_map_id')
        ->join('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
            ->join('vishwa_portals', 'vishwa_vendor_challan.portal_id', 'vishwa_portals.id')
            ->where('vishwa_vendor_master.id', $vendorId)
            ->where('vishwa_portals.id', $portal_id)
            ->where('vishwa_vendor_challan.challan_no', $challan_no)
            ->select('vishwa_vendor_master.company_name', 'vishwa_vendor_master.mobile', 'vishwa_vendor_master.state', 'vishwa_portals.company_name as portal_name', 'vishwa_vendor_master.name', 'vishwa_vendor_master.address', 'vishwa_vendor_challan.*')
            ->first();

        $supplier_data = VishwaChallan::join('vishwa_vendor_challan_item', 'vishwa_vendor_challan.id', 'vishwa_vendor_challan_item.challan_map_id')
        ->where('challan_no', trim($challan_no))
            ->where('vendor_id', $vendorId)
            ->where('indent_id', $indent_no)
            ->where('portal_id', $portal_id)
            ->get();

        $pdf = PDF::loadView('vendor-user.VendorPrice.challan', compact('item', 'invoice_to_data', 'supplier_data'));

        return $pdf->download('challan.pdf');
    }

    public function getPurchaseItem(Request $request)
    {
        $portal_id = Auth::user()->getPortal->id;
        $input = $request->all();
        $purchase_order_no = trim($input['purchase_order_no']);
        $vendor_id = $input['vendor_id'];
        $indent_no = $input['indent_no'];


        $invoice_to_data = Portal::join('vishwa_states', 'vishwa_portals.state', 'vishwa_states.id')
            ->where('vishwa_portals.id', $portal_id)->first();

        $supplier_data = VishwaPurchaseOrder::join('vishwa_vendor_master', 'vishwa_purchase_order.vendor_id', 'vishwa_vendor_master.id')
            ->join('vishwa_states', 'vishwa_vendor_master.state', 'vishwa_states.id')
            ->join('vishwa_cities', 'vishwa_vendor_master.city', 'vishwa_cities.id')
            ->where('vishwa_purchase_order.purchase_order_no', '=', $purchase_order_no)
            ->where('vishwa_purchase_order.portal_id', $portal_id)
            ->select('vishwa_states.name as statename', 'vishwa_states.gstcode', 'vishwa_vendor_master.*', 'vishwa_cities.name as cityname', 'vishwa_purchase_order.date')
            ->first();

        $supplierGroupId = VishwaGroupType::join('vishwa_master_material_group', 'vishwa_group_type.id', 'vishwa_master_material_group.group_type_id')
            ->first();


        $purchaseMapId=VishwaPurchaseOrder::where('purchase_order_no',$purchase_order_no)->first();

        $items = VishwaPurchaseOrder::join('vishwa_purchase_order_item', 'vishwa_purchase_order.id', 'vishwa_purchase_order_item.order_map_id')
            ->join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_purchase_order_item.item_id')

            ->join('vishwa_indent_vendor_price', 'vishwa_purchase_order.indent_id', 'vishwa_indent_vendor_price.indent_id')
            ->where('vishwa_purchase_order.purchase_order_no', '=', $purchase_order_no)
            ->where('vishwa_indent_vendor_price.indent_id', '=', $indent_no)
            ->where('vishwa_indent_vendor_price.vendor_id', '=', $vendor_id)
            ->where('vishwa_purchase_order.portal_id', $portal_id)
            ->select('vishwa_materials_item.*', 'vishwa_purchase_order.*', 'vishwa_indent_vendor_price.freight', 'vishwa_indent_vendor_price.loading', 'vishwa_indent_vendor_price.kpcharges'
            ,'vishwa_purchase_order_item.*')
            ->get();

        $getChallanItem = VishwaChallan::where('vendor_id', $vendor_id)
            ->where('indent_id', $indent_no)
            ->where('portal_id', $portal_id)
            ->where('purchase_order_no', $purchase_order_no)
            ->get();



        if($items->isNotEmpty())
        {
            return view('Purchase.purchaseItem', compact('items', 'supplier_data', 'invoice_to_data', 'purchase_order_no', 'getChallanItem', 'purchase_order_no'));
        }
        else
        {
            return back()->withErrors('No Items are in Purchased Order');
        }



    }

    public function ChallanItemGet(Request $request)
    {
        $vendor_id = Auth::user()->getVendor->id;
        $input = $request->all();
        $purchase_order_no = trim($input['purchase_order_no']);
        $portal_id = $input['portal_id'];
        $indent_no = $input['indent_no'];
        $challan_no = $input['challan_no'];

        $getChallanItem = VishwaChallan::join('vishwa_vendor_challan_item', 'vishwa_vendor_challan.id', 'vishwa_vendor_challan_item.challan_map_id')
        ->join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_vendor_challan_item.item_id')
            ->where('challan_no', trim($challan_no))
            ->where('vendor_id', $vendor_id)
            ->where('indent_id', $indent_no)
            ->where('portal_id', $portal_id)
            ->get();

        $item = VishwaChallan::join('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
            ->join('vishwa_portals', 'vishwa_vendor_challan.portal_id', 'vishwa_portals.id')
            ->where('vishwa_vendor_master.id', $vendor_id)
            ->where('vishwa_portals.id', $portal_id)
            ->where('vishwa_vendor_challan.challan_no', $challan_no)
            ->select('vishwa_vendor_master.company_name', 'vishwa_vendor_master.mobile', 'vishwa_vendor_master.state', 'vishwa_portals.company_name as portal_name', 'vishwa_vendor_master.name', 'vishwa_vendor_master.address', 'vishwa_vendor_challan.*')
            ->first();


        return view('vendor-user.VendorPrice.VendorChallanItem', compact('getChallanItem', 'item', 'purchase_order_no', 'challan_no'));

    }

    public function getChallanQuantity(Request $request)
    {
        $portal_id = Auth::user()->getPortal->id;
        $input = $request->all();
        $purchase_order_no = trim($input['purchase_order_no']);
        $indent_no = $input['indent_id'];
        $vendor_id = $input['vendor_id'];

        $getChallan = VishwaPurchaseOrder::join('vishwa_materials_item', 'vishwa_materials_item.id', 'vishwa_purchase_order.item_id')
            ->where('vendor_id', $vendor_id)
            ->where('portal_id', $portal_id)
            ->where('purchase_order_no', trim($purchase_order_no))
            ->get();

        $chkChallanNumber = VishwaChallan::join('vishwa_vendor_challan_item', 'vishwa_vendor_challan.id', 'vishwa_vendor_challan_item.challan_map_id')
            ->where('portal_id', $portal_id)
            ->where('vendor_id', $vendor_id)
            ->where('purchase_order_no', trim($purchase_order_no))
            ->get();

        $challan_number = null;

        if ($chkChallanNumber != null) {
            foreach ($chkChallanNumber as $key => $value) {

                $challan_number[] = $value->challan_no;
            }
        }

        $invoice_to_data = Portal::join('vishwa_states', 'vishwa_portals.state', 'vishwa_states.id')
            ->where('vishwa_portals.id', $portal_id)->first();

        $supplier_data = VishwaPurchaseOrder::
        join('vishwa_vendor_master', 'vishwa_purchase_order.vendor_id', 'vishwa_vendor_master.id')
            ->join('vishwa_states', 'vishwa_vendor_master.state', 'vishwa_states.id')
            ->join('vishwa_cities', 'vishwa_vendor_master.city', 'vishwa_cities.id')
            ->where('vishwa_purchase_order.purchase_order_no', '=', $purchase_order_no)
            ->where('vishwa_purchase_order.portal_id', $portal_id)
            ->select('vishwa_states.name as statename', 'vishwa_states.gstcode', 'vishwa_vendor_master.*', 'vishwa_cities.name as cityname', 'vishwa_purchase_order.date')
            ->first();

        return view('Purchase.ViewChallanItem', compact('getChallan', 'chkChallanNumber', 'challan_number', 'purchase_order_no', 'invoice_to_data', 'supplier_data'));

    }


    public function ChallanDataFetch(Request $request)

    {


        $challanData = VishwaChallan::where('purchase_order_no', $request->input('order_no'))->get();
        return response()->json($challanData);

        $billData = VishwaChallan::where('purchase_order_no', $request->input('order_no'))->get();
        return response()->json($billdata);


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
        $portal_id = Auth::user()->getEmp->getUserPortal->id;
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


        DB::beginTransaction();

        try {

            $updatePurchaseOrder = VishwaPurchaseOrder::where('vendor_id', $vendor_id)->where('indent_id', $indent_id)->first();

            if ($updatePurchaseOrder != null) {

                $updatePurchaseOrder->portal_id = $portal_id;
                $updatePurchaseOrder->emp_id = $emp_id;
                $updatePurchaseOrder->project_id = $project->id;
                $updatePurchaseOrder->total_amount = $total_amount;
                $updatePurchaseOrder->store_id = $store_id;
                $updatePurchaseOrder->date = date('Y-m-d', strtotime($date));
                $updatePurchaseOrder->purchase_order_no = $purchase_order_no;
                $updatePurchaseOrder->save();

            }
            else
            {
                $VishwaIndentData = new VishwaPurchaseOrder();
                $VishwaIndentData->vendor_id = $vendor_id;
                $VishwaIndentData->portal_id = $portal_id;
                $VishwaIndentData->emp_id = $emp_id;
                $VishwaIndentData->project_id = $project->id;
                $VishwaIndentData->indent_id = $indent_id;
                $VishwaIndentData->total_amount = $total_amount;
                $VishwaIndentData->store_id = $store_id;
                $VishwaIndentData->date = date('Y-m-d', strtotime($date));
                $VishwaIndentData->purchase_order_no = $purchase_order_no;
                $VishwaIndentData->save();

            }
            foreach ($item_id as $key => $value) {
                if ($vendor_id != null) {
                    $VishwaPurchaseData = new VishwaPurchaseOrderItem();
                    $VishwaPurchaseData->order_map_id = $VishwaIndentData->id;
                    $VishwaPurchaseData->total_amount = $total_amount;
                    $VishwaPurchaseData->item_id = $value;
                    $VishwaPurchaseData->unit = $unit[$key];
                    $VishwaPurchaseData->qty = $qty[$key];
                    $VishwaPurchaseData->save();
                }
            }

            DB::commit();
            Session::flash('success_message', 'PO Request Successfully Generated Go to The Purchase order Tabs!');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error_message', 'PO Request Failed Due to Error in Data !');
        }



        return redirect()->route('indentResorurce.index', $project->id);

    }

    public function getOrderBasedChallan(Request $request)
    {


        $challanData = VishwaChallan::where('purchase_order_no', $request->input('order_no'))->first();

        return response()->json($challanData);

    }

    public function getOrderBasedBill(Request $request)
    {
        $challan_no = base64_decode($request->input('challan_no'));
        $order_no = base64_decode($request->input('order_no'));

        $billData = ViewBill::where('purchase_order_no', $order_no)
            ->where('challan_no', $challan_no)
            ->get();


        return response()->json($billData);
    }


    public function vendorBill($id, $orderNo)
    {

        $challan_no = base64_decode($id);
        $purchase_order_no = base64_decode($orderNo);


//        $purchase_order_no = trim($input['purchase_order_no']);
//        $portal_id = Auth::user()->getVendor;
//        $indent_no = $input['indent_no'];
        $vendor_id = Auth::user()->getVendor->id;

        $getOrderType = VishwaPurchaseOrder::where('purchase_order_no', $purchase_order_no)->where('item_id', '!=', null)->first();

        $getIndentType = VishwaIndentVendorsPrice::where('indent_id', $getOrderType->indent_id)->first();


        $getGroupTypeOne = VishwaRentablePrice::where('indent_map_id', $getIndentType->id)->first();
        $getGroupTypeTwo = VishwaNonRentablePrice::where('indent_map_id', $getIndentType->id)->first();

        if ($getGroupTypeOne != null) {

            $getChallan = VishwaChallan::join('vishwa_purchase_order', 'vishwa_vendor_challan.item_id', 'vishwa_purchase_order.item_id')
                ->join('vishwa_indent_vendor_price', 'vishwa_purchase_order.indent_id', 'vishwa_indent_vendor_price.indent_id')
                ->join('vishwa_indent_vendor_rentable_price', 'vishwa_vendor_challan.item_id', 'vishwa_indent_vendor_rentable_price.item_id')
                ->where('vishwa_vendor_challan.challan_no', $challan_no)
                ->where('vishwa_indent_vendor_price.vendor_id', $vendor_id)
                ->select('vishwa_vendor_challan.*', 'vishwa_indent_vendor_rentable_price.per_day_price',
                    'vishwa_indent_vendor_price.freight', 'vishwa_indent_vendor_price.loading', 'vishwa_indent_vendor_price.kpcharges')
                ->get();
        }

        if ($getGroupTypeTwo != null) {
            $getChallan = VishwaChallan::join('vishwa_purchase_order', 'vishwa_vendor_challan.item_id', 'vishwa_purchase_order.item_id')
                ->join('vishwa_indent_vendor_price', 'vishwa_purchase_order.indent_id', 'vishwa_indent_vendor_price.indent_id')
                ->join('vishwa_indent_vendor_non_rentable_price', 'vishwa_vendor_challan.item_id', 'vishwa_indent_vendor_non_rentable_price.item_id')
                ->where('vishwa_vendor_challan.challan_no', $challan_no)
                ->where('vishwa_indent_vendor_price.vendor_id', $vendor_id)
                ->select('vishwa_vendor_challan.*', 'vishwa_indent_vendor_non_rentable_price.price', 'vishwa_indent_vendor_non_rentable_price.tax_rate',
                    'vishwa_indent_vendor_price.freight', 'vishwa_indent_vendor_price.loading', 'vishwa_indent_vendor_price.kpcharges')
                ->get();
        }


        $company_data = VishwaChallan::join('vishwa_purchase_order', 'vishwa_vendor_challan.purchase_order_no', 'vishwa_purchase_order.purchase_order_no')
            ->join('vishwa_portals', 'vishwa_vendor_challan.portal_id', 'vishwa_portals.id')
            ->join('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
            ->select('vishwa_portals.company_name as portal_name', 'vishwa_portals.gstn_uin as portal_gstn',
                'vishwa_vendor_master.gstn_uin as vendor_gstn', 'vishwa_portals.id as portal_id')
            ->first();


        $checkBillNumber = ViewBill::where('challan_no', $id)
            ->first();

//dd($id,$vendor_id);
        return view('vendor-user.VendorPrice.vendor_bill', compact('getChallan', 'checkBillNumber',
            'company_data', 'purchase_order_no', 'challan_no'));

    }

    public function billOrderNumber(Request $request)
    {

        $challan_no = trim($request->input('challan_no'));
        $item_list = $request->input('item_id');
        $item_price = $request->input('price_list');
        $item_qty = $request->input('dispatch_qty');
        $item_unit = $request->input('unit');
        $item_tax = $request->input('item_tax');
        $item_amount = $request->input('item_amount');
        $item_total_amount = $request->input('total_amount');


        DB::beginTransaction();

        try {

            $updateBill_status = VishwaChallan::where('challan_no', $challan_no)
                ->update(['bill_status' => "GENERATED"]);

            $bill_new = new ViewBill();
            $bill_new->portal_id = $request->input('portal_id');
            $bill_new->purchase_order_no = $request->input('purchase_order_no');
            $bill_new->bill_amt = $request->input('gross_price');
            $bill_new->gst_amt = $request->input('gross_tax');
            $bill_new->total_amount = $request->input('net_amount');
            $bill_new->bill_date = date('Y-m-d', strtotime($request->input('bill_date')));
            $bill_new->created_by = $request->input('bill_no');
            $bill_new->created_date = date('Y-m-d');
            $bill_new->bill_no = $request->input('bill_no');
            $bill_new->challan_no = $challan_no;
            $bill_new->freight = $request->input('freight_charge');
            $bill_new->loading = $request->input('loading_charge');
            $bill_new->kpcharges = $request->input('kpcharges');

            $bill_new->save();

            if (!empty($item_list)) {
                foreach ($item_list as $key => $value) {

                    $bill_items = new ViewBillItems();

                    $bill_items->bill_id = $request->input('bill_no');
                    $bill_items->item_id = $value;
                    $bill_items->qty = $item_qty[$key];
                    $bill_items->price = $item_price[$key];
                    $bill_items->amt = $item_amount[$key];
                    $bill_items->tax = $item_tax[$key];
                    $bill_items->net_amt = $item_total_amount[$key];
                    $bill_items->unit = $item_unit[$key];

                    $bill_items->save();
                }
                DB::commit();
                Session::flash('success_message', 'Bill Successfully Generated ');
            } else {
                DB::rollback();
                Session::flash('error_message', 'Bill Error  ');
            }


        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error_message', 'Bill Error  ');
        }


        return redirect()->route('PurchaseOrder.index');

    }

    public function vendorBillPdfDownload()
    {
        $pdf = PDF::loadView('Purchase.vendor_bill_pdf_purchase');
        return $pdf->download('vendor_bill_pdf_purchase.pdf');
    }


}



