<?php
namespace App\Http\Controllers\portal\company;

use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
use Illuminate\Http\Request;
use Log;
use DB;
use Auth;
use Session;

class CompanyAddressController extends Controller
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
        Log::info('Input data CompanyAddressController@store--:'.print_r($request->all(),true));
        Log::info('For PORTAL ID CompanyAddressController@store--:'.print_r(Auth::user()->getPortal->id,true));
        Log::info('For Client_id CompanyAddressController@store--:'.print_r($request->input('client_id'),true));
        if (!empty($request->input('update_id'))) {
            $ClientAddress= ClientAddress::where('id',$request->input('update_id'))->first();
            $ClientAddress->portal_id=Auth::user()->getPortal->id;
            $ClientAddress->client_id=$request->input('client_id');
            $ClientAddress->Address=$request->input('Address');
            $ClientAddress->City=$request->input('City');
            $ClientAddress->Post_code=$request->input('Post_code');
            $ClientAddress->Country_id=$request->input('Country_id');
            $ClientAddress->Contact_Person=$request->input('Contact_Person');
            $ClientAddress->Telephone=$request->input('Telephone');
            $ClientAddress->Fax=$request->input('Fax');
            $ClientAddress->Mobile=$request->input('Mobile');
            $ClientAddress->Alternate_Mobiles=$request->input('Alternate_Mobile');
            $ClientAddress->Email=$request->input('Email');
            $ClientAddress->Alternate_Email=$request->input('Alternate_Email');
            if($ClientAddress->save()){
                $this->jsonResponse['success'] = true;
                $this->jsonResponse['message'] = "Successfully Upadate info";
            }else{
                $this->jsonResponse['error'] = true;
                $this->jsonResponse['message'] = "Wrong info Entered";
            }
        }else{
            $ClientAddress=new ClientAddress();
            $ClientAddress->portal_id=Auth::user()->getPortal->id;
            $ClientAddress->client_id=$request->input('client_id');
            $ClientAddress->Address=$request->input('Address');
            $ClientAddress->City=$request->input('City');
            $ClientAddress->Post_code=$request->input('Post_code');
            $ClientAddress->Country_id=$request->input('Country_id');
            $ClientAddress->Contact_Person=$request->input('Contact_Person');
            $ClientAddress->Telephone=$request->input('Telephone');
            $ClientAddress->Fax=$request->input('Fax');
            $ClientAddress->Mobile=$request->input('Mobile');
            $ClientAddress->Alternate_Mobiles=$request->input('Alternate_Mobile');
            $ClientAddress->Email=$request->input('Email');
            $ClientAddress->Alternate_Email=$request->input('Alternate_Email');
            if($ClientAddress->save()){
                $this->jsonResponse['success'] = true;
                $this->jsonResponse['message'] = "Successfully saved info";
            }else{
                $this->jsonResponse['error'] = true;
                $this->jsonResponse['message'] = "Wrong info Entered";
            }
            Log::info('New Address Id CompanyAddressController@store--:'.print_r($ClientAddress->id,true));
        }        
        return response()->json($this->jsonResponse);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientSecInfo  $clientSecInfo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        //dd($request->all());
        $editData = [];
        
        $inputs = $request->all();
        $status = $inputs['status'];
        Log::info('client id for address CompanyAddressController@show--:'.print_r($inputs,true));
        if (isset($inputs['add_id']) && !empty($inputs['add_id'])) {
            $editData = DB::table('acc_client_address')->where('id',$inputs['add_id'])->first();
        //dd($editData);
        }

        $countries=DB::table('acc_country_code_master')->get();
        $address=DB::table('acc_client_address')
            ->leftjoin('acc_country_code_master','acc_client_address.Country_id','acc_country_code_master.id')
            ->select('acc_client_address.*','acc_country_code_master.name as Country_name')
            ->where('acc_client_address.client_id',$inputs['Update_id'])
            ->get();
    return view('portal.company.partial.address_list',compact('address','countries','editData','status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientSecInfo  $clientSecInfo
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientSecInfo  $clientSecInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Log::info('Input data CompanyAddressController@update--:'.print_r($request->all(),true));
        Log::info('For PORTAL ID CompanyAddressController@update--:'.print_r(Auth::user()->getPortal->id,true));
        Log::info('For address_update_id CompanyAddressController@update--:'.print_r($request->input('address_update_id'),true));
        $ClientAddress= ClientAddress::where('id',$request->input('address_update_id') )->first();
        $ClientAddress->portal_id=Auth::user()->getPortal->id;
        $ClientAddress->Address=$request->input('Address');
        $ClientAddress->City=$request->input('City');
        $ClientAddress->Post_code=$request->input('Post_code');
        $ClientAddress->Country_id=$request->input('Country_id');
        $ClientAddress->Contact_Person=$request->input('Contact_Person');
        $ClientAddress->Telephone=$request->input('Telephone');
        $ClientAddress->Fax=$request->input('Fax');
        $ClientAddress->Mobile=$request->input('Mobile');
        $ClientAddress->Alternate_Mobiles=$request->input('Alternate_Mobile');
        $ClientAddress->Email=$request->input('Email');
        $ClientAddress->Alternate_Email=$request->input('Alternate_Email');
        if($ClientAddress->save()){
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = "Successfully UPDATE info";
        }else{
            $this->jsonResponse['error'] = true;
            $this->jsonResponse['message'] = "Wrong info Entered";
        }
        Log::info('New Address Id CompanyAddressController@update--:'.print_r($ClientAddress->id,true));
        return response()->json($this->jsonResponse);
    }

    //check unique register no. on update client
    
    public function checkRegisterUniqueValidation(Request $request)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientSecInfo  $clientSecInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info('Client address delete id CompanyAddressController@destroy==:'.$id);
        $delete_data = ClientAddress::where('id',$id)->first();
        $delete_data->delete();
        Session::flash('error_message','Delete Successfully!!');
        return back();
    }
}
