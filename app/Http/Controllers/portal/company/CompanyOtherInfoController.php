<?php

namespace App\Http\Controllers\portal\company;

use App\Models\ClientOtherInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;

class CompanyOtherInfoController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientOtherInfo  $clientOtherInfo
     * @return \Illuminate\Http\Response
     */
    public function show(ClientOtherInfo $clientOtherInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientOtherInfo  $clientOtherInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientOtherInfo $clientOtherInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientOtherInfo  $clientOtherInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientOtherInfo $clientOtherInfo)
    {
        Log::info('CompanyOtherInfoController@update INPUT Data==:'.print_r($request->all(),true));
        $validation = $request->validate([
            'client_id' => 'exists:acc_client_info,id',
            'VAT_No' => 'required',
            'TIC_NO' => 'required|numeric'
        ]);

        $client_id = $request->input('client_id');
        Log::info('CompanyOtherInfoController@update Client_id==:'.print_r($client_id,true));
        $client_other = ClientOtherInfo::where('client_id',$client_id)->get();
        Log::info('CompanyOtherInfoController@update Check for update or new==:'.print_r(count($client_other),true));
        if(count($client_other) > 0)
        {
            $response = ClientOtherInfo::where('client_id', $client_id)->update([
                'client_id' => $request->input('client_id'),
                'VAT_No' => $request->input('VAT_No'),
                'activities' => $request->input('activities'),
                'Category' => $request->input('Category'),
                'intrastat' => $request->input('intrastat'),
                'Has_employees' => $request->input('Has_employees'),
                'social_insurance_no' => $request->input('social_insurance_no'),
                'Self_employed_NO' => $request->input('Self_employed_NO'),
                'TIC_NO' => $request->input('TIC_NO'),
                'Social_insurance_username' => $request->input('Social_insurance_username'),
                'Description' => $request->input('Description'),
                'vies' => $request->input('vies'),
                'rent_received' => $request->input('rent_received'),
                'quarterly_reviewed' => $request->input('quarterly_reviewed'),
            ]);
            if($response == true){
                $this->jsonResponse['success'] = true;
                $this->jsonResponse['message'] = "Successfully saved info";
            }
             return response()->json($this->jsonResponse);
        }
        else
        {
            $client_other = new ClientOtherInfo();
            $client_other->client_id= $request->input('client_id');
            $client_other->VAT_No= $request->input('VAT_No');
            $client_other->activities= $request->input('activities');
            $client_other->Category= $request->input('Category');
            $client_other->intrastat= $request->input('intrastat');
            $client_other->Has_employees= $request->input('Has_employees');
            $client_other->social_insurance_no= $request->input('social_insurance_no');
            $client_other->Self_employed_NO= $request->input('Self_employed_NO');
            $client_other->TIC_NO= $request->input('TIC_NO');
            $client_other->Social_insurance_username= $request->input('Social_insurance_username');
            $client_other->Social_insurance_pwd= $request->input('Social_insurance_pwd');
            $client_other->Description= $request->input('Description');
            $client_other->vies= $request->input('vies');
            $client_other->rent_received= $request->input('rent_received');
            $client_other->quarterly_reviewed= $request->input('quarterly_reviewed');
            if($client_other->save()){
              $this->jsonResponse['success'] = true;
              $this->jsonResponse['message'] = "Successfully saved info";
            }
            Log::info('New entry Created ON ID CompanyOtherInfoController@update==:'.print_r($client_other->id,true));
        }
        return response()->json($this->jsonResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientOtherInfo  $clientOtherInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientOtherInfo $clientOtherInfo)
    {
        //
    }
}
