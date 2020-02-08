<?php
namespace App\Http\Controllers\portal\company;

use Auth;
use App\User;
use App\Models\Portal;
use App\Models\Client;
use App\Models\ClientOtherInfo;
use App\Models\ClientSecInfo;
use App\Models\ClientAddress;
use App\Models\EmployeeProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Carbon;
use Storage;
use Log;
use DB;
use File;


class CompanyManagementController extends Controller
{


    public $jsonResponse = ['success' => false, 'message' => 'Sorry!, unable to process your request' , 'data' => ''];


    /**
     * Display a listing of the resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $portal_id = Auth::user()->getPortal->id;
        Log::info('portal id data CompanyManagementController@index--:'.print_r($portal_id,true));
        $client_list = Client::where('portal_id',$portal_id)->get();


        return view('portal.company.index',compact('client_list'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function getClientDataByStatus(Request $request)
    {
        $status_data = $request->all();
        Log::info('portal id data CompanyManagementController@getClientDataByStatus--:'.print_r($status_data,true));
        $portal_id = Auth::user()->getPortal->id;
        $client_list = Client::where('portal_id',$portal_id)->where('Status',$status_data['status'])->get();

        return view('portal.company.statusdata_list',compact('client_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('portal.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('input data CompanyManagementController@store--:'.print_r($request->all(),true));
        $email = $request->input('Email');
        $validator = Validator::make($request->all(),[
            'Company_name' => 'required|unique:vishwa_client_info,Client_name',
            'logo' => 'nullable',
            'Registration_No'=>'required',
            // 'Source' => 'required',
            // 'Type' => 'required|alpha',
            // 'File_No' => 'required',
            // 'Box_No' => 'required',
            //
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $portal_id = Auth::user()->getPortal->id;
        Log::info('portal_id data CompanyManagementController@store--:'.print_r($portal_id,true));
        $date = $request->input('Date_Acquired');
        $date1 = str_replace('/', '-', $date);
        $Date_Acquired = date('Y-m-d', strtotime($date1));
        $client_data = new Client();
        $client_data->portal_id = $portal_id;
        $client_data->Client_name=ucfirst($request->input('Company_name'));
        if($request->hasfile('logo'))
            {
                $file = $request->file('logo');
                $extension = $file->getClientOriginalExtension();
                $fileName =time().'.'.$extension;
                if(Storage::disk('uploads')->put('company_images/'.$fileName,file_get_contents($request->file('logo')))){
                    $client_data->logo = $fileName;
                }
            }
        $client_data->Source=$request->input('Source');
        $client_data->Group=$request->input('Group');
        $client_data->Type=$request->input('Type');
        $client_data->File_No=$request->input('File_No');
        $client_data->Registration_No=$request->input('Registration_No');
        $client_data->Box_No=$request->input('Box_No');
        $client_data->Status=$request->input('Status');
        $client_data->Website=$request->input('Website');
        $client_data->Activities=$request->input('Activities');
        $client_data->Date_Acquired=$Date_Acquired;
        $client_data->save();
        $insert_id = $client_data->id;
        Log::info('new client id  CompanyManagementController@store--:'.print_r($insert_id,true));
        $request->session()->flash('success_message','Add Successfully!!');
        return redirect()->route('company');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        // $id = base64_decode($id);
        // Log::info('show client id  CompanyManagementController@show--:'.print_r($id,true));
        // $company_details = Client::find($id);
        // $countries=DB::table('vishwa_country_code_master')->get();
        // Log::info('Client/Company data on id  CompanyManagementController@show--:'.print_r($company_details,true));
        // $email = User::where('id',$company_details->user_id)->value('email');
        // // $address=ClientAddress::where('client_id',$id)->get();
        // // $client_other =ClientOtherInfo::where('client_id',$id)->first();
        // // $client_fees =ClientFees::where('client_id',$id)->first();
        // // $activities = Activities::All();
        // // $categories = Category::All();
        // // $sources = Source::where('is_active',1)->get();
        // // $types = Type::where('is_active',1)->get();
        // // $auditStatus = AuditStatus::All();
        // // $FormCategory = FormCategory::All();
        // // $FormName = FormName::All();
        // // $address_list=ClientAddress::where('client_id',$id)->get();
        // // $auditing_list = ClientServiceAudit::where('client_id',$id)->get();
        // // $accounting = AccountingFees::where('client_id',$id)->get();
        // // $forms_list = ClientServiceForm::where('client_id',$id)->get();
        // // $ClientServiceAccountingData =ClientServiceAccounting::where('client_id',$id)->first();
        // $countries=DB::table('vishwa_country_code_master')->get();
        // // $accounting_list = ClientServiceAccounting::where('client_id',$id)->get();
        // Log::info('user Email  CompanyManagementController@show--:'.print_r($email,true));
        // return view('portal.company.show',compact('email','company_details','countries','id'));
        $id = base64_decode($id);
        // $portal_id = Auth::user()->getPortal->id;
        Log::info('portal id data CompanyManagementController@show--:'.print_r($id,true));
        $client_list = Client::where('id',$id)->get();

        // return($client_list);
        return view('portal.company.show',compact('client_list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $id = base64_decode($id);
        Log::info('Company_Edit id from  CompanyManagementController@edit--:'.print_r($id,true));
        // $client_info_data =Client::find($id);
        // $client_other =ClientOtherInfo::where('client_id',$id)->first();
        // $client_fees =ClientFees::where('client_id',$id)->first();
        // $activities = Activities::All();
        // $categories = Category::All();
        // $sources = Source::where('is_active',1)->get();
        // $types = Type::where('is_active',1)->get();
        // $auditStatus = AuditStatus::All();
        // $FormCategory = FormCategory::All();
        //  $FormName = FormName::All();
        // //dd($FormCategory);
        // $address_list=ClientAddress::where('client_id',$id)->get();
        // $auditing_list = ClientServiceAudit::where('client_id',$id)->get();
        // $accounting = AccountingFees::where('client_id',$id)->get();
        // $forms_list = ClientServiceForm::where('client_id',$id)->get();
        // $ClientServiceAccountingData =ClientServiceAccounting::where('client_id',$id)->first();
        // $countries=DB::table('vishwa_country_code_master')->get();
        // return view('portal.company.edit',compact('id','client_info_data','client_list','activities','client_other','categories','client_sec','accounting','FormCategory','auditStatus','ClientServiceAudit','ClientServiceFormData','ClientServiceAccountingData','select_tab','FormName','select_fee_tab','select_sec_tab','select_info_tab','select_services_tab','client_audit_insert_id','select_form_tab','select_audit_tab','service_form_id','SelectAccountingTab','auditing_list','forms_list','sources','types','address_list','countries'));


        $portal_id = Auth::user()->getPortal->id;
        Log::info('portal id data CompanyManagementController@edit--:'.print_r($portal_id,true));
        $client_list = Client::where('id',$id)->get();
        // $client_info_data =Client::find($id);

// foreach($client_list as $c){
//   print($c->Client_name);
// }

        return view('portal.company.edit',compact('client_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        Log::info('input data CompanyManagementController@Update--:'.print_r($request->all(),true));

        $email = $request->input('Email');
        $validator = Validator::make($request->all(),[
            'Company_name' => 'required',
            'logo' => 'nullable',
            'Registration_No'=>'required',
            // 'Source' => 'required',
            // 'Type' => 'required|alpha',
            // 'File_No' => 'required',
            // 'Box_No' => 'required',
            //
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $portal_id = Auth::user()->getPortal->id;
        $id = base64_decode($id);
        Log::info('portal_id data CompanyManagementController@Update--:'.print_r($portal_id,true));
        $date = $request->input('Date_Acquired');
        $date1 = str_replace('/', '-', $date);
        $Date_Acquired = date('Y-m-d', strtotime($date1));
        $client_data =Client::where('id',$id)->first();
        $client_data->portal_id = $portal_id;
        $client_data->Client_name=ucfirst($request->input('Company_name'));
        if($request->hasfile('logo'))
            {
                // $client_data->logo->delete();
                $file = $request->file('logo');
                $extension = $file->getClientOriginalExtension();
                $fileName =time().'.'.$extension;
                if(Storage::disk('uploads')->put('company_images/'.$fileName,file_get_contents($request->file('logo')))){
                    $oldfile = $client_data->logo;
                    $client_data->logo = $fileName;
                    File::delete(public_path('uploads/company_images/'. $oldfile));
                }
            }
        $client_data->Source=$request->input('Source');
        $client_data->Group=$request->input('Group');
        $client_data->Type=$request->input('Type');
        $client_data->File_No=$request->input('File_No');
        $client_data->Registration_No=$request->input('Registration_No');
        $client_data->Box_No=$request->input('Box_No');
        $client_data->Status=$request->input('Status');
        $client_data->Website=$request->input('Website');
        $client_data->Activities=$request->input('Activities');
        $client_data->Date_Acquired=$Date_Acquired;
        $client_data->save();
        $insert_id = $client_data->id;
        Log::info('new client id  CompanyManagementController@store--:'.print_r($insert_id,true));
        $request->session()->flash('success_message','Update Successfully!!');
        if($client_data->save()){
          $this->jsonResponse['success'] = true;
          $this->jsonResponse['message'] = "Successfully saved info";
        }
        // return response()->json($this->jsonResponse);
          return redirect()->route('company');
    }

    public function feeUpdate(Request $request)
    {


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
    /**
     * data are coming from jquery for email validation
     *
     * @param    $request get email for unique validation
     * @return response
     */
    public function checkEmailUniqueValidation(Request $request)
    {
        $email = $request->input('email');
       $get_data =  Client::where('Email',$email)->first();
        if(!empty($get_data))
        {
            echo "Email Already Exist";
        }
        else
        {

        }
        exit();
    }

    public function checkMobileUniqueValidation(Request $request)
    {
        $mobile = $request->input('mobile');
        $get_data =  Client::where('Mobile',$mobile)->first();
        if(!empty($get_data))
        {
            echo "Mobile No. Already Exist";
        }
        else
        {

        }
        exit();
    }

    public function checkUniqueUpdateValidation(Request $request)
    {
        $id =0;
        $mobile = $request->input('mobile');
        $id = $request->input('id');
        $colum = $request->input('colum');
        if($request->input('id') && $request->input('id')!='')
            $id=$request->input('id');

        $Customer= Client::where($colum,$mobile)->where('id','<>',$id)->get();
        $data= $Customer->pluck('id','id')->toArray();
        if($Customer->count()>0){
            return 'false';
        }else{
            return 'OK';
        }
       exit;
    }


}
