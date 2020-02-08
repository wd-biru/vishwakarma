<?php

namespace App\Http\Controllers\portal\company;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\AccountingFees;
use App\Models\FeesType;
use App\Http\Controllers\Controller;
use log;

class CompanyFeesController extends Controller
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
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientFees  $clientFees
     * @return \Illuminate\Http\Response
     */
    public function show( )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientFees  $clientFees
     * @return \Illuminate\Http\Response
     */
    public function edit( )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientFees  $clientFees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountingFees $accountingfees)
    {
        Log::info('CompanyFeesController@update INPUT DATA==:'.print_r($request->all(),true));        
        $client_id = $request->input('client_id');        
        Log::info('CompanyFeesController@update Client ID==:'.print_r($client_id,true));        
        $feeids = $request->input('feeid');
        Log::info('CompanyFeesController@update feeids==:'.print_r($feeids,true));        
        if(!empty($feeids))
        {
            foreach ($feeids as $feeid) 
            {
                $accounting = AccountingFees::find($feeid);  
                $accounting->amount = $request->input('amount_'.$feeid);
                $accounting->save(); 
            }
        }
        $client = Client::find($client_id);
        $client->fee_comments = $request->input('Comments');
        if($client->save()){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "Successfully saved info";
        }
        return response()->json($this->jsonResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientFees  $clientFees
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientFees $clientFees)
    {
        //
    }
}
