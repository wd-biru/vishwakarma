<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaVendorProjectContract;
use App\Models\VishwaVendorProjectContractPrice;
use Auth;
use App\Entities\Projects\Project;
use Session;
use Carbon\Carbon;

class VendorContractPriceController extends Controller
{

    public function storeRentableContract(Request $request)
    {

        $vendor_id = Auth::user()->getVendor->id;
        $created_by = Auth::user()->name;
        $item_id = $request->input('item_id');
        $indent_id = $request->input('indent_id');
        $per_day_price = $request->input('per_day_price');
        $recovery_price = $request->input('recovery_price');
        $freight = $request->input('freight');
        $loading = $request->input('loading');
        $kpcharges = $request->input('kpcharges');
        $effective_date = $request->input('effective_date');
        $dateNow = date('Y-m-d', strtotime($effective_date));

        foreach ($item_id as $key => $value) {

            if ( $vendor_id != null && $indent_id != null && $freight != null && $loading != null && $kpcharges != null) {

                $vishRentableContract = new VishwaVendorProjectContract();
                $vishRentableContract->vendor_id = $vendor_id;
                $vishRentableContract->portal_id =  Auth::user()->getPortal->id;
                $vishRentableContract->project_id = 15;
                $vishRentableContract->indent_id = $indent_id[$key];
                $vishRentableContract->freight = $freight;
                $vishRentableContract->loading_unloading = $loading;
                $vishRentableContract->kp_charges = $kpcharges;
                $vishRentableContract->created_by = $created_by;
                $vishRentableContract->effective_date = $dateNow;
                $vishRentableContract->created_date = $dateNow;
                $vishRentableContract->save();
            } else {
                Session::flash('error_message', 'Some Fields Are Missing ?');
            }

        }

        foreach ($item_id as $key => $value) {

            if ( $per_day_price != null && $recovery_price != null && $vendor_id != null && $indent_id != null ) {

                $vishRentableContract = new VishwaVendorProjectContractPrice();
                $vishRentableContract->vendor_id = $vendor_id;
                $vishRentableContract->portal_id =  Auth::user()->getPortal->id;
                $vishRentableContract->project_id = 15;
                $vishRentableContract->item_id = $value;
                $vishRentableContract->perday_price = $per_day_price[$key];
                $vishRentableContract->recovery_price = $recovery_price[$key];
                $vishRentableContract->save();
            } else {
                Session::flash('error_message', 'Some Fields Are Missing ?');
            }

        }
      
        Session::flash('success_message', 'Vendor Contract Price Added Successfully!');
        return redirect()->back();

    }


}