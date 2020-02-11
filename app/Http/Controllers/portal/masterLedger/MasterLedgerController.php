<?php

namespace App\Http\Controllers\portal\masterLedger;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaMasterLedger;
use App\Models\VishwaMasterLedgerRelationshipType;
use App\Models\VishwaMasterLedgerRelationMapping;
use DB;
use Auth;
use Session;
use Validator;

class MasterLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $masterLedgers =  VishwaMasterLedger::join('vishwa_master_ledger_relationship_type','vishwa_master_ledger_relationship_type.id','vishwa_master_ledger.relationship_id')
            ->select('vishwa_master_ledger_relationship_type.name','vishwa_master_ledger.*')
            ->orderBy('id','desc')
            ->get();
        return view('portal.masterLedger.index' ,compact('masterLedgers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientTypes = VishwaMasterLedgerRelationshipType::all();
        return view('portal.masterLedger.create' , compact('clientTypes'));
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
        'opening_balance' => 'required',
        'closing_balance' => 'required',
        'as_on_date'=>'required',

        ]);
        if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
        }

        $portal_id = Auth::user()->getPortal->id;
        $as_on_date = $request->input('as_on_date');
        $dateNow = date('Y-m-d', strtotime($as_on_date));
        $masterLedger = new VishwaMasterLedger();
        $masterLedger->portal_id = $portal_id;
        $masterLedger->client_id = $request->client_list_id;
        $masterLedger->relationship_id = $request->client_id;
        $masterLedger->opening_balance = $request->opening_balance;
        $masterLedger->closing_balance = $request->closing_balance;
        $masterLedger->opening_balance_date = $dateNow;
        $masterLedger->closing_balance_date = $dateNow;
        $masterLedger->save();

        Session::flash('success_message', 'Master Ledger Added Successfully!');
        return redirect()->route('masterLedger.index')->withInput();
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
        $clientTypes = VishwaMasterLedgerRelationshipType::all();
        $clientLists = VishwaMasterLedgerRelationMapping::all();
        $masterLedger =  VishwaMasterLedger::find($id);
        
        return view('portal.masterLedger.edit' ,compact('masterLedger','clientTypes','clientLists'));
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
        $masterLedger =  VishwaMasterLedger::find($id)->delete();
        Session::flash('success_message', 'Master Ledger Deleted Successfully!');
        return redirect()->back();
    }

    public function getClientListData(Request $request)
    {
        $getClientLists = DB::table("vishwa_master_ledger_relationship_mapping")
            ->where("relationship_type_id", $request->input('client_id'))
            ->get();
        return response()->json(array('clientList' => $getClientLists));
    }

    


}
