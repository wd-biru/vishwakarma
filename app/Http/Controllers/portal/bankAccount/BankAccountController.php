<?php

namespace App\Http\Controllers\portal\bankAccount;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaBankAccount;
use DB;
use Auth;
use Validator;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $bankAccounts = VishwaBankAccount::join('vishwa_bank_master','vishwa_bank_master.id','vishwa_portal_bank_mapping.bank_id')->get();
        return view('portal.bankAccount.index' , compact('bankAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bankMaster = DB::table('vishwa_bank_master')->get();
        return view('portal.bankAccount.create' , compact('bankMaster'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
        'cheque_book_From' => 'required',
        'cheque_book_to' => 'required',

        ]);
        if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
        }

        
        $bankmaster = new VishwaBankAccount();
        if (Auth::user()->user_type == "portal") {
            $portal_id = Auth::user()->getPortal->id;
        }
        $bankmaster->portal_id  = $portal_id;
        $bankmaster->bank_id    = $request->bank_id;
        $bankmaster->from_chq   = $request->cheque_book_From;
        $bankmaster->to_chq     = $request->cheque_book_to;
        if($request->current_active == 1)
        {
            $bankmaster->currently_use  = $request->current_active;
        }
        else{
            $bankmaster->in_vault  = $request->current_active;
        }
        $bankmaster->save();
        $request->session()->flash('success_message','Bank Record Created Successfully!!'); 

        return redirect()->route('portal.bankAccount');
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
    public function edit($id)
    {
        
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    


}
