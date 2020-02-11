<?php

namespace App\Http\Controllers\admin\master\Accountmaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaMasterBillingCycle;
use Session;

class AccountMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billingCycles = VishwaMasterBillingCycle::all();
        return view('admin.master.AccountMaster.index' , compact('billingCycles'));
    }



    public function store(Request $request)
    {

        $cycleExist = VishwaMasterBillingCycle::where('billing_cycle', $request->billing_cycle)->first();
        if ($cycleExist == null) {
            $billingCycle = new VishwaMasterBillingCycle();
            $billingCycle->billing_cycle = $request->billing_cycle;
            $billingCycle->save();
            $request->session()->flash('success_message','Master Billing Cycle Created Successfully!!');
            return redirect()->route('masterBillingCycle.index');
        }
        else
        {
            $request->session()->flash('error_message', 'Master Billing Cycle Already Existed!!');
            return redirect()->back();
        }
    }



    public function updateBillingCycle(Request $request)
    {
        $id=$request->input('updated_billing_cycle_id');
        $billing_cycle_name=$request->input('edit_billing_cycle');

        $result = VishwaMasterBillingCycle::where('id',$id)->where('billing_cycle',$billing_cycle_name)->first();

        if($result == null)
        {
            VishwaMasterBillingCycle::where('id',$id)->update(['billing_cycle'=>$billing_cycle_name]);
            Session::flash('success_message', 'Billing Cycle Updated Successfully!');             
        }
        elseif($result->billing_cycle==$billing_cycle_name)
        {
            Session::flash('success_message', 'Billing Cycle Updated Successfully!');
        }
        else
        {
            Session::flash('error_message', 'Billing Cycle Not Updated!!');
        }
        return redirect()->route('masterBillingCycle.index');
    }



    public function deleteBillingCycle($id)
    {
        $result = VishwaMasterBillingCycle::find($id)->delete();
        Session::flash('success_message', 'Billing Cycle Deleted Successfully !!');
        return redirect()->route('masterBillingCycle.index');
    }
}
