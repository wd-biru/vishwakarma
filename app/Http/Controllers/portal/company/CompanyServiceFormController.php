<?php

namespace App\Http\Controllers\portal\company;

use App\Models\ClientServiceForm;
use DB;
use Illuminate\Http\Request;
use App\Models\FormName;
use App\Models\FormCategory;
use App\Http\Controllers\Controller;
use Log;

class CompanyServiceFormController extends Controller
{
    public $jsonResponse = ['success' => false, 'message' => 'Sorry!, unable to process your request' , 'data' => ''];

    public function formStore(Request $request,$id)
    {

        Log::info('CompanyServiceFormController@formStore INPUT DATA==:'.print_r($request->all(),true));
        Log::info('CompanyServiceFormController@formStore ON ID==:'.print_r($id,true));
        $date = $request->input('year');
        $date1 = str_replace('/', '-', $date);
        $year = date('Y-m-d', strtotime($date1));
        $service_form = new ClientServiceForm();
        $service_form->category_id=$request->input('category_id');
        $service_form->client_id=$id;
        $service_form->name=$request->input('tax_file_id');
        $service_form->year=$year;
        $service_form->status=$request->input('status');
        $service_form_id= $service_form->id;
        if($service_form->save()){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "Successfully saved info";
        }
        Log::info('CompanyServiceFormController@formStore NEW ENTRY ID ClientServiceForm==:'.print_r($service_form->id,true));
        return response()->json($this->jsonResponse);
    }
    
    public function formUpdate(Request $request)
    {
        Log::info('CompanyServiceFormController@formUpdate INPUT DATA==:'.print_r($request->all(),true));
        $edit_id = $request->input('form_edit_id');
        Log::info('CompanyServiceFormController@formUpdate Edit ON ID==:'.print_r($$edit_id ,true));
        $date = $request->input('year');
        $date1 = str_replace('/', '-', $date);
        $year = date('Y-m-d', strtotime($date1));
        $service_form = ClientServiceForm::where('id',$edit_id)->update([
            'category_id'
                           => $request->input('category_id'),
            'Year'
                           => $year,
            'status'
                           => $request->input('status'),
            'name'
                           => $request->input('tax_file_id'),
        ]);
         if($service_form==true){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "Successfully saved info";
        }
        return response()->json($this->jsonResponse);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $forms_info_id=$request->input('Update_id');
        Log::info('form iD more data CompanyServiceFormController@index==:'.print_r($forms_info_id,true));
        $forms_list = ClientServiceForm::where('id',$forms_info_id)->first();

        if(!empty($forms_list)){
                $this->jsonResponse['success'] = true;
                
                $this->jsonResponse['data'] = $forms_list;
            }
           return response()->json($this->jsonResponse); 
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
        Log::info('CompanyServiceFormController@store INPUT DATA==:'.print_r($request->all(),true));
        Log::info('CompanyServiceFormController@store ON ID==:'.print_r($id,true));
        $date = $request->input('year');
        $date1 = str_replace('/', '-', $date);
        $year = date('Y-m-d', strtotime($date1));
        $service_form = new ClientServiceForm();
        $service_form->category_id=$request->input('category_id');
        $service_form->client_id=$id; 
        $service_form->name=$request->input('tax_file_id');
        $service_form->year=$year;
        $service_form->status=$request->input('status');
        $service_form_id= $service_form->id;
        if($service_form->save()){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "Successfully saved info";
        }
        Log::info('CompanyServiceFormController@formStore NEW ENTRY ID ClientServiceForm==:'.print_r($service_form->id,true));
        return response()->json($this->jsonResponse);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientServiceForm  $clientService
     * @return \Illuminate\Http\Response
     */
    public function show(ClientServiceForm $clientService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientServiceForm  $clientService
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientServiceForm $clientService,Request $request)
    {
        Log::info('CompanyServiceFormController@edit edit DATA==:'.print_r($request->all(),true));
        $client_audit_id =$request->input('client_audit_id');
        $client_id = $request->input('client_id');
        $service_form_id = $request->input('service_form_id');
        return redirect()->route('clientPage',['inserted_id'=>$client_id,'select_services_tab'=> 1,'client_audit_insert_id'=>$client_audit_id,'service_form_id'=>$service_form_id,'select_form_tab'=>1]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientServiceForm  $clientService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientServiceForm $clientService)
    {
        Log::info('CompanyServiceFormController@update edit DATA==:'.print_r($request->all(),true));
        $validation = $request->validate([
            'Date_delivered' => 'required',
            'Date_obtained' => 'required',  
        ]);
        $date = $request->input('Date_delivered');
        $date1 = str_replace('/', '-', $date);
        $Date_delivered = date('Y-m-d', strtotime($date1));
        $date_chk = $request->input('Date_obtained');
        $date_obtained_1 = str_replace('/', '-', $date_chk);
        $Date_obtained = date('Y-m-d', strtotime($date_obtained_1));
        $service_form_id = $request->input('forms_info_id');
        
        Log::info('CompanyServiceFormController@update UPDATE service_form_id DATA==:'.print_r($service_form_id,true));
        $ClientServiceForm = ClientServiceForm::where('id',$service_form_id)->update([
                'Date_delivered'=>$Date_delivered,
                'Date_obtained'=>$Date_obtained,
                'Comments'=>$request->input('Comments'),
            ]);
        if($ClientServiceForm==true){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "Successfully saved info";
        }
        return response()->json($this->jsonResponse);
    }


    public function active(Request $request,$id,$val,$client_id,$client_audit_id)
    {
        $client_audit_id =$client_audit_id;
        $client_id = $client_id;
        $service_form_id = $id;
        ClientServiceForm::where('id',$service_form_id)->update([
            'Status'=>$val,
        ]);
        if($val == 0)
        {
            $request->session()->flash('success','Data has been deactive successfully!!');
        }
        else
        {
            $request->session()->flash('success','Data has been active successfully!!');
        }

        if($client_audit_id == 0)
        {
            return redirect()->route('clientPage',['inserted_id'=>$client_id,'select_services_tab'=> 1,'service_form_id'=>$service_form_id,'select_form_tab'=>1]);

        }
        else
        {
            return redirect()->route('clientPage',['inserted_id'=>$client_id,'select_services_tab'=> 1,'client_audit_insert_id'=>$client_audit_id,'service_form_id'=>$service_form_id,'select_form_tab'=>1]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientServiceForm  $clientService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientServiceForm $clientService)
    {
        //
    }

    /**
     * get tax file name according tax type id.
     *
     * @param  taxTypeId
     * @return json
     */
    public function getFile(Request $request)
    {

        $tax_type_id = $request->input('taxTypeId');
        $Customer= DB::table('acc_form_name')->where('category_id',$tax_type_id)->get();

        $File=$Customer->pluck('tax_file_name','id')->toArray();

        return response()->json($File);
    }
    /**
     * get data using jquery for update and return response
     *
     * @param  taxTypeId
     * @return json
     */

    public function formUpdateData(Request $request,$id)
    {
        Log::info('CompanyServiceFormController@formUpdateData');
        $client_id =$id;
        $edit_id =$request->input('edit_id');
        $category_id =$request->input('category_id');
        $tax_file =$request->input('tax_file');
        $update_year =$request->input('update_year');
        $update_status =$request->input('update_status');
        $date = $request->input('update_year');
        $date1 = str_replace('/', '-', $date);
        $year = date('Y-m-d', strtotime($date1));
        $service_form = ClientServiceForm::find($edit_id);
        $service_form->category_id=$request->input('category_id');
        $service_form->client_id=$client_id;
        $service_form->tax_file_id=$tax_file;
        $service_form->year=$year;
        $service_form->status=$update_status;
        $service_form->save();
        $request->session()->flash('success','data update successfully');
        echo 'ok';
        exit;
    }

    public function getClientFormsList($id)
    {
        Log::info('CompanyServiceFormController@getClientFormsList ON ID==:'.print_r($id,true));
        $forms_list = ClientServiceForm::where('client_id',$id)->get();
        $FormCategory = FormCategory::all();
        $form_names = FormName::all();
        return view('portal.company.partial.forms_list',compact('forms_list','FormCategory','form_names'));
    }
}
