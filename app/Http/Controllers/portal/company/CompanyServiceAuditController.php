<?php

namespace App\Http\Controllers\portal\company;

use App\Models\ClientServiceAudit;
use App\Models\AuditStatus;
use Illuminate\Http\Request;
use Log;
use App\Http\Controllers\Controller;

class CompanyServiceAuditController extends Controller
{

    public $jsonResponse = ['success' => false, 'message' => 'Sorry!, unable to process your request' , 'data' => ''];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $auditing_info_id=$request->input('Update_id');
        Log::info('Audit iD more data CompanyServiceAuditController@index==:'.print_r($auditing_info_id,true));
        $audit_list = ClientServiceAudit::where('id',$auditing_info_id)->first();
        if(!empty($audit_list)){
                $this->jsonResponse['success'] = true;
                
                $this->jsonResponse['data'] = $audit_list;
            }
           return response()->json($this->jsonResponse); 

        //return view('portal.company.partial.auditing_info',compact('auditing_info_id','audit_list'));
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
    public function store(Request $request,$id)
    {
        Log::info('INPUT data CompanyServiceAuditController@store==:'.print_r($request->all(),true));
        $validation = $request->validate([
            'review_by' => 'required|alpha_dash',
            'prepared_by' => 'required|alpha_dash',
            'final_approve_by' => 'required|alpha_dash'
        ]);
        
        if(!empty($request->input('update_id')))
        {
            $date = $request->input('start_date');
            $date1 = str_replace('/', '-', $date);
            $start_date = date('Y-m-d', strtotime($date1));
            $date = $request->input('end_date');
            $date1 = str_replace('/', '-', $date);
            $end_date = date('Y-m-d', strtotime($date1));
            $client_id = $id;
            $id = $request->input('update_id');
            $client_audit = ClientServiceAudit::find($id);
            $client_audit->client_id =$client_id;;
            $client_audit->year =$request->input('year');
            $client_audit->Status =$request->input('Status');
            $client_audit->start_date =$start_date;
            $client_audit->end_date =$end_date;
            $client_audit->review_by =$request->input('review_by');
            $client_audit->prepared_by =$request->input('prepared_by');
            $client_audit->final_approve_by =$request->input('final_approve_by');
            $client_audit_insert_id = $id;
            if($client_audit->save()){
                $this->jsonResponse['success'] = true;
                $this->jsonResponse['message'] = "Successfully saved info";
            }
            Log::info('INPUT data && UPDATE CompanyServiceAuditController@store==:'.print_r($id,true));
           return response()->json($this->jsonResponse); 
        }
        else
        {
            $date = $request->input('start_date');
            $date1 = str_replace('/', '-', $date);
            $start_date = date('Y-m-d', strtotime($date1));
            $date = $request->input('end_date');
            $date1 = str_replace('/', '-', $date);
            $end_date = date('Y-m-d', strtotime($date1));
            $client_id = $request->input('client_id');
            $client_audit = new ClientServiceAudit();
            $client_audit->client_id =$id;
            $client_audit->year =$request->input('year');
            $client_audit->Status =$request->input('Status');
            $client_audit->start_date =$start_date;
            $client_audit->end_date =$end_date;
            $client_audit->review_by =$request->input('review_by');
            $client_audit->prepared_by =$request->input('prepared_by');
            $client_audit->final_approve_by =$request->input('final_approve_by');
            $client_audit_insert_id = $client_audit->id;
            if($client_audit->save()){
                $this->jsonResponse['success'] = true;
                $this->jsonResponse['message'] = "Successfully saved info";
            }
            Log::info('NEW ENTRY ID ClientServiceAudit CompanyServiceAuditController@store==:'.print_r($client_audit->id,true));
            return response()->json($this->jsonResponse);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientServiceAudit  $clientServiceAudit
     * @return \Illuminate\Http\Response
     */
    public function show(ClientServiceAudit $clientServiceAudit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientServiceAudit  $clientServiceAudit
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientServiceAudit $clientServiceAudit,Request $request)
    {
        
        $client_audit_insert_id =$request->input('client_audit_id');
        $client_id = $request->input('client_id');        
        return redirect()->route('clientEdit',['insert_id'=>$id,'select_info_tab'=>1,'client_audit_insert_id'=>$client_audit_insert_id,'select_audit_tab'=>1]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientServiceAudit  $clientServiceAudit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientServiceAudit $clientServiceAudit)
    {   
        Log::info('INPUT DATA CompanyServiceAuditController@update==:'.print_r($request->all(),true));
        $validation = $request->validate([
            'profit_a' => 'numeric',
            'profit_b' => 'numeric',
            'corporationTax_a' => 'numeric',
            'corporationTax_b' =>  'numeric',
            'defence_a' => 'numeric',
            'defence_b' => 'numeric',
            
        ]);
        $edit_id=$request->input('auditing_info_id');
        Log::info('OPRETAION ON ID auditing_info_id CompanyServiceAuditController@update==:'.print_r($edit_id,true));

        $client_audit = ClientServiceAudit::where('id',$edit_id)->update([
            'profit_a'=>$request->input('profit_a'),
            'profit_b'=>$request->input('profit_b'),
            'corporationTax_a'=>$request->input('corporationTax_a'),
            'corporationTax_b'=>$request->input('corporationTax_b'),
            'defence_a'=>$request->input('defence_a'),
            'defence_b'=>$request->input('defence_b'),
            'audit_comment'=>$request->input('audit_comment'),
            'audit_progress'=>$request->input('audit_progress'),
        ]);
        if($client_audit==true){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "Successfully saved info";
        }
            return response()->json($this->jsonResponse);
    } 

    

    public function getClientAuditingList($id)
    {   
        $audit_status = AuditStatus::all();
        $auditing_list = ClientServiceAudit::where('client_id',$id)->get();
        return view('portal.company.partial.auditing_list',compact('id','audit_status','auditing_list'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientServiceAudit  $clientServiceAudit
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientServiceAudit $clientServiceAudit)
    {

    }
}
