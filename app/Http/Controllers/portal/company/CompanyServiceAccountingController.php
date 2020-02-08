<?php

namespace App\Http\Controllers\portal\company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClientServiceAccounting;
use Log;

class CompanyServiceAccountingController extends Controller
{
    public $jsonResponse = ['success' => false, 'message' => 'Sorry!, unable to process your request' , 'data' => ''];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        Log::info('CompanyServiceAccountingController@store INPUT DATA==:'.print_r($request->all(),true));
        $client_id = $request->input('client_id');
        $date = $request->input('Bank_Reconcilation');
        $date1 = str_replace('/', '-', $date);
        $Bank_Reconcilation = date('Y-m-d', strtotime($date1));
        $date = $request->input('Creditor_Reconcilation');
        $date1 = str_replace('/', '-', $date);
        $Creditor_Reconcilation = date('Y-m-d', strtotime($date1));
        $date = $request->input('Debtor_Reconcilation');
        $date1 = str_replace('/', '-', $date);
        $Debtor_Reconcilation = date('Y-m-d', strtotime($date1));
        $client_id = $request->input('client_id');
        $client_audit_id = $request->input('client_audit_id');
        $service_form_id = $request->input('service_form_id');

        $ClientServiceAccounting = new ClientServiceAccounting();
        $ClientServiceAccounting->Bank_Reconcilation=$Bank_Reconcilation;
        $ClientServiceAccounting->client_id=$client_id;
        $ClientServiceAccounting->Creditor_Reconcilation=$Creditor_Reconcilation;
        $ClientServiceAccounting->Debtor_Reconcilation=$Debtor_Reconcilation;
        $ClientServiceAccounting->Comments=$request->input('Comments');
        if($ClientServiceAccounting->save()){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "Successfully saved info";
        }
        Log::info('CompanyServiceAccountingController@store New ID ClientServiceAccounting==:'.print_r($ClientServiceAccounting->id,true));

           return response()->json($this->jsonResponse);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientServiceAccounting  $clientServiceAccounting
     * @return \Illuminate\Http\Response
     */
    public function show(ClientServiceAccounting $clientServiceAccounting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientServiceAccounting  $clientServiceAccounting
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientServiceAccounting $clientServiceAccounting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientServiceAccounting  $clientServiceAccounting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientServiceAccounting $clientServiceAccounting)
    {
        //
    }
    

    public function getClientAccountingList(Request $request,$id)
    {  
        $accounting_status = ClientServiceAccounting::all();
        $accounting_list = ClientServiceAccounting::where('client_id',$id)->get();
        return view('portal.company.partial.accounting_list',compact('id','accounting_status','accounting_list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientServiceAccounting  $clientServiceAccounting
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientServiceAccounting $clientServiceAccounting)
    {
        //
    }
}
