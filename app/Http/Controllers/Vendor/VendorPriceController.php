<?php

namespace App\Http\Controllers\Vendor;

use App\Models\VishwaNonRentablePrice;
use App\Models\VishwaRentablePrice;
use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaVendorsRegistration;
use App\Models\MasterUnit;
use App\Models\MaterialItem;
use App\Models\VishwaVendorsPrice;
use App\Models\MasterMaterialsGroup;
use App\Models\Portal;
use App\Models\VishwaVendorPortalMapping;
use App\Models\VishwaVendorIndentMapping;
use App\Models\VishwaIndentVendorsPrice;
use App\Models\IndentMaster;
use App\User;
use Session;
use DB;
use Validator;
use Carbon\Carbon;
use Log;
use Auth;
use App\Models\VishwaGroupType;

class VendorPriceController extends Controller
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


        $vendor_material_group = MasterMaterialsGroup::all();
        $group_type = VishwaGroupType::all();

        return view('vendor-user.VendorPrice.vendor_price', compact('vendor_material_group', 'group_type'));
    }

    public function getItemListPrice(Request $request)
    {

        $group_type_id = $request->group_type_id;

        $group_id = $request->group_id;

        $group_type_name = DB::table('vishwa_group_type')
            ->select('group_type_name')
            ->where('id', $group_type_id)
            ->first();
        $mat_itam_list = DB::table('vishwa_materials_item')
            ->join('vishwa_unit_masters', 'vishwa_materials_item.material_unit', 'vishwa_unit_masters.id')
            ->where('vishwa_materials_item.group_id', $group_id)
            ->select('vishwa_materials_item.*', 'vishwa_unit_masters.material_unit')
            ->get();
        $getVendorItemPrice = VishwaVendorsPrice::where('vendor_id', Auth::user()->getVendor->id)->where('group_id', $group_id)->get();


        return view('vendor-user.VendorPrice.partials.create-list', compact('mat_itam_list', 'getVendorItemPrice', 'group_type_name'));

    }

    public function vendorIndent(Request $request)
    {

        $indentVendor = VishwaVendorIndentMapping::join('vishwa_portals', 'vishwa_vendor_indent_mapping.portal_id', 'vishwa_portals.id')
            ->where('vendor_id', Auth::user()->getVendor->id)->orderBy('vishwa_vendor_indent_mapping.created_at', 'desc')
            ->select('vishwa_vendor_indent_mapping.*', 'vishwa_portals.company_name as portal_name')
            ->get();


        return view('vendor-user.VendorPrice.vendor_indent', compact('indentVendor'));


    }

    public function vendorIndentPrice(Request $request, $id)
    {

        $indentVendor = VishwaVendorIndentMapping::join('vishwa_portals', 'vishwa_vendor_indent_mapping.portal_id', 'vishwa_portals.id')
            ->where('vendor_id', Auth::user()->getVendor->id)->orderBy('vishwa_vendor_indent_mapping.created_at', 'desc')
            ->select('vishwa_vendor_indent_mapping.*', 'vishwa_portals.company_name as portal_name')
            ->get();
        $vendor_item_price = DB::select("SELECT vishwa_indent_items.*, vishwa_materials_item.material_name,       vishwa_indent_items.qty  FROM `vishwa_indent_items`
              INNER JOIN vishwa_materials_item ON vishwa_materials_item.id=vishwa_indent_items.item_id
                   WHERE vishwa_indent_items.group_id= vishwa_materials_item.group_id
                   AND vishwa_indent_items.indent_id='$id'");

        // $vendor_indent_id = IndentItem::where('vishwa_indent_items.indent_id',$id)->first();

        $group_type = DB::table('vishwa_indent_items')
            ->join('vishwa_master_material_group', 'vishwa_indent_items.group_id', 'vishwa_master_material_group.id')
            ->where('vishwa_indent_items.indent_id', $id)
            ->groupBy('vishwa_master_material_group.group_type_id')
            ->first();


        $vendor_indent_id = VishwaIndentVendorsPrice::where('vendor_id', Auth::user()->getVendor->id)
            ->where('indent_id', $id)
            ->first();

        $getIndentNonPrice = VishwaIndentVendorsPrice::where('vendor_id', Auth::user()->getVendor->id)
            ->join('vishwa_indent_vendor_rentable_price','vishwa_indent_vendor_price.id','vishwa_indent_vendor_rentable_price.indent_map_id')
            ->where('vishwa_indent_vendor_price.indent_id', $id)
            ->get();



        $getIndentPrice = VishwaIndentVendorsPrice::where('vendor_id', Auth::user()->getVendor->id)
            ->join('vishwa_indent_vendor_non_rentable_price','vishwa_indent_vendor_price.id','vishwa_indent_vendor_non_rentable_price.indent_map_id')
            ->where('vishwa_indent_vendor_price.indent_id', $id)
            ->get();



        return view('vendor-user.VendorPrice.vendor_indent', compact('getIndentNonPrice','group_type','indentVendor', 'vendor_item_price', 'getIndentPrice', 'vendor_indent_id', 'id'));

    }


    public function getEachVendorPrice(Request $request)
    {

        $item_id = $request->item_id;
        $vendor_id = $request->vendor_id;
        $indent_id = $request->indent_id;
        $price = $request->price;
        $obj = new IndentMaster();
        $valueLowest = $obj->getPriceAginstEachVendor($vendor_id, $indent_id, $item_id, $price);
        return response()->json($valueLowest);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeIndentyPrice(Request $request)
    {

        $vendor_id = Auth::user()->getVendor->id;
        $updated_id = $request->input('updated_id');
        $item_id = $request->input('item_id');
        $indent_id = $request->input('indent_id');
        $unit = $request->input('unit');
        $qty = $request->input('qty');
        $price = $request->input('price');
        $total = $request->input('total');
        $tax_rate = $request->input('tax_rate');
        $remarks = $request->input('remarks');
        $freight = $request->input('freight');
        $loading = $request->input('loading');
        $kpcharges = $request->input('kpcharges');


        $indentCheck=VishwaIndentVendorsPrice::where('indent_id',$indent_id)->first();

        DB::beginTransaction();

        try
        {

         if($indentCheck!=null)
         {
             VishwaIndentVendorsPrice::where('indent_id',$indent_id)->update([
                 "freight" => $freight,
                 "loading" => $loading,
                 "kpcharges" => $kpcharges,
                 "remarks" => $remarks
             ]);
         }
         else
         {
             $vishIndentPrice = new VishwaIndentVendorsPrice();
             $vishIndentPrice->vendor_id = $vendor_id;
             $vishIndentPrice->indent_id = $indent_id[0];
             $vishIndentPrice->freight = $freight;
             $vishIndentPrice->loading = $loading;
             $vishIndentPrice->kpcharges = $kpcharges;
             $vishIndentPrice->remarks = $remarks;
             $vishIndentPrice->save();

//             $vishLastInsertedId=IndentMaster::where('indent_id',$indent_id[0])->first();
         }

            if($indentCheck!=null)
            {
                foreach ($item_id as $key => $value) {

                    if ($price[$key] != null && $total[$key] != null && $tax_rate[$key] != null && $freight != null && $loading != null && $kpcharges != null) {

                        $vishUpdateItem=VishwaNonRentablePrice::where('indent_map_id',$indentCheck->id)->update([
                            "price"=> $price[$key],
                            "total" => $total[$key],
                            "tax_rate" => $tax_rate[$key],
                        ]);
                    }
                    else
                    {
                        Session::flash('error_message', 'Some Fields Are Missing ?');
                    }

                }
            }
            else
            {
                foreach ($item_id as $key => $value) {

                    if ($price[$key] != null && $total[$key] != null && $tax_rate[$key] != null && $freight != null && $loading != null && $kpcharges != null) {

                        $material_data = MaterialItem::find($value);
                        $vishRentableItemPrice = new VishwaNonRentablePrice();
                        $vishRentableItemPrice->indent_map_id = $vishIndentPrice->id;
                        $vishRentableItemPrice->item_id = $value;
                        $vishRentableItemPrice->unit = $unit[$key];
                        $vishRentableItemPrice->qty = $qty[$key];
                        $vishRentableItemPrice->price = $price[$key];
                        $vishRentableItemPrice->total = $total[$key];
                        $vishRentableItemPrice->tax_rate = $tax_rate[$key];
                        $vishRentableItemPrice->group_id = $material_data->group_id;
                        $vishRentableItemPrice->material_name = $material_data->material_name;
                        $vishRentableItemPrice->save();
                    }
                    else
                    {
                        Session::flash('error_message', 'Some Fields Are Missing ?');
                    }

                }
            }



            DB::commit();
            Session::flash('success_message', 'Vendor Indent Price Added Successfully!');
        }
        catch(Exception $e)
        {
            DB::rollback();
            Session::flash('error_message', 'Some Error Occur ! ');
        }


        return redirect()->back();
    }


    public function rentableQuotes(Request $request)
    {



        $vendor_id = Auth::user()->getVendor->id;
        $item_id = $request->input('item_id');
        $indent_id = $request->input('indent_id');
        $unit = $request->input('unit');
        $qty = $request->input('qty');
        $per_day_price = $request->input('per_day_price');
//        $total = $request->input('total');
        $recovery_price = $request->input('recovery_price');
        $remarks = $request->input('remarks');
        $freight = $request->input('freight');
        $loading = $request->input('loading');
        $kpcharges = $request->input('kpcharges');

        $indentCheck=VishwaIndentVendorsPrice::where('indent_id',$indent_id)->first();


        DB::beginTransaction();

        try
        {

            if($indentCheck!=null)
            {
                VishwaIndentVendorsPrice::where('indent_id',$indent_id)->update([
                    "freight" => $freight,
                    "loading" => $loading,
                    "kpcharges" => $kpcharges,
                    "remarks" => $remarks
                ]);
            } else {
                $vishIndentPrice = new VishwaIndentVendorsPrice();
                $vishIndentPrice->vendor_id = $vendor_id;
                $vishIndentPrice->indent_id = $indent_id[0];
                $vishIndentPrice->freight = $freight;
                $vishIndentPrice->loading = $loading;
                $vishIndentPrice->kpcharges = $kpcharges;
                $vishIndentPrice->remarks = $remarks;
                $vishIndentPrice->save();

                $vishLastInsertedId = IndentMaster::where('indent_id', $indent_id[0])->first();
            }

            if ($indentCheck != null) {
                foreach ($item_id as $key => $value) {

                    if ($per_day_price[$key] != null && $recovery_price[$key] != null && $freight != null && $loading != null && $kpcharges != null) {

                        $vishUpdateItem = VishwaNonRentablePrice::where('indent_map_id', $indentCheck->id)->update([
                            "per_day_price" => $per_day_price[$key],
                            "recovery_price" => $recovery_price[$key],
                        ]);
                    } else {
                        Session::flash('error_message', 'Some Fields Are Missing ?');
                    }

                }
            }else {
                foreach ($item_id as $key => $value) {

                    if ($per_day_price[$key] != null && $recovery_price[$key] != null && $freight != null && $loading != null && $kpcharges != null) {

                        $material_data = MaterialItem::find($value);
                        $vishRentableItemPrice = new VishwaRentablePrice();
                        $vishRentableItemPrice->indent_map_id = $vishIndentPrice->id;
                        $vishRentableItemPrice->item_id = $value;
                        $vishRentableItemPrice->unit = $unit[$key];
                        $vishRentableItemPrice->qty = $qty[$key];
                        $vishRentableItemPrice->per_day_price = $per_day_price[$key];
                        $vishRentableItemPrice->recovery_price = $recovery_price[$key];
                        $vishRentableItemPrice->group_id = $material_data->group_id;
                        $vishRentableItemPrice->material_name = $material_data->material_name;
                        $vishRentableItemPrice->save();
                    } else {
                        Session::flash('error_message', 'Some Fields Are Missing ?');
                    }

                }
            }


            DB::commit();
            Session::flash('success_message', 'Vendor Indent Price Added Successfully!');
        }
        catch(Exception $e)
        {
            DB::rollback();
            Session::flash('error_message', 'Some Error Occur ! ');
        }



        return redirect()->back();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storePrice(Request $request)
    {
        $item_id = $request->input('item_id');
        $price = $request->input('price');
        $effective_date = $request->input('effective_date');
        $VishwaVendorsPricearray = null;
        $VishwaStageDetailsarrayemp = null;
        $VishwaStageDetailsarrayseq = null;


//        foreach ($item_id as $key => $item_idvalue)
//        {
//            if($price[$key] != null && $effective_date[$key]!= null) {
//
//                $update = VishwaVendorsPrice::where('item_id',$item_idvalue)->where('vendor_id',Auth::user()->getVendor->id)->delete();
//
//                $VishwaVendorsPrice = new VishwaVendorsPrice();
//                $VishwaVendorsPrice->vendor_id = Auth::user()->getVendor->id;
//                $VishwaVendorsPrice->group_id = $request->input('group_id');
//                $VishwaVendorsPrice->portal_id = null;
//                $VishwaVendorsPrice->item_id = $item_idvalue;
//                $VishwaVendorsPrice->price = $price[$key];
//                $_dates = new Carbon(str_replace('/', '-',$effective_date[$key]));
//                $date = date('Y-m-d', strtotime($_dates));
//                $VishwaVendorsPrice->effective_date = $date;
//                $VishwaVendorsPrice->save();
//            }
//        }
        Session::flash('success_message', 'Vendor Price Added Successfully!');
        return back();


    }


}