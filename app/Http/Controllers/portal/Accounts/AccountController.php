<?php

namespace App\Http\Controllers\portal\Accounts;

use App\Models\VishwaMasterBillingCycle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use PHPUnit\Exception;

class AccountController extends Controller
{

    public function billingCycle()
    {
        $portal_id = Auth::user()->getPortal->id;
        $billingCycles = VishwaMasterBillingCycle::where('portal_id', $portal_id)->get();
        return view('portal.Accounts.billing_cycle_index', compact('billingCycles'));
    }

    public function billingCycleCreate()
    {
        $portal_id = Auth::user()->getPortal->id;
        $billingCycle = VishwaMasterBillingCycle::where('portal_id', null)->get();
        return view('portal.Accounts.billing_cycle_create', compact('billingCycle', 'portal_id'));
    }

    public function billingCycleStore(Request $request)
    {
        $portal_id = Auth::user()->getPortal->id;

        $cycleExist = VishwaMasterBillingCycle::where('billing_cycle', $request->billing_cycle)->first();

        if ($cycleExist == null) {
            $billingCycle = new VishwaMasterBillingCycle();
            $billingCycle->portal_id = $portal_id;
            $billingCycle->billing_cycle = $request->billing_cycle;
            $billingCycle->save();
            $request->session()->flash('success_message', 'Billing Cycle Created Successfully!!');
        } else {
            $request->session()->flash('error_message', 'Billing Cycle Already Existed!!');
            return redirect()->back();
        }
        return redirect()->route('portal.billingCycle');

    }

    public function getBillCycleWithPortalNull(Request $request)
    {
        $data = VishwaMasterBillingCycle::where('portal_id', null)
            ->orWhere('portal_id', '')->get();
        return response()->json($data);
    }

    public function billingCycleUpdate(Request $request)
    {
        $portal_id = Auth::user()->getPortal->id;
        $id = $request->bill_id;
        $billing_cycle = $request->billing_cycle;


        DB::beginTransaction();
        try {

            $del = VishwaMasterBillingCycle::where('portal_id', $portal_id)->delete();
            if ($id != null) {
                foreach ($id as $key => $value) {
                    $billCycle = new VishwaMasterBillingCycle();
                    $billCycle->billing_cycle = $billing_cycle[$key];
                    $billCycle->portal_id = $portal_id;
                    $billCycle->save();
                }
            }
           else
           {
               DB::rollback();
               $request->session()->flash('error_message', 'No Cycle is Selected');
               return redirect()->back();
           }

            DB::commit();
            $request->session()->flash('success_message', 'Billing Cycle Created Successfully!!');
            return redirect()->route('portal.billingCycle');
        } catch (Exception $e) {
            DB::rollback();
            $request->session()->flash('error_message', 'Unknown Error');
            return redirect()->back();
        }

    }

}
