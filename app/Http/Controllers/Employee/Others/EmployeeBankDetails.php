<?php

namespace App\Http\Controllers\Employee\Others;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeBankDetail;
use Auth;
use Storage;
use Validator;
use session;
use Log;

class EmployeeBankDetails extends Controller
{
    public function index()
    {
        
    }

    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
            $postData=$request->all();
          //dd($postData);
            $id=$request->input('employee_id');
            $validator = Validator::make($request->all(),[
                'account_holder_name' => 'required',
                'bank_name' => 'required',   
                'account_number' => 'required|numeric',
                'branch_name' => 'required',
                'ifsc_code' => 'required',
                'iban_number' => 'required',
                
            ]);

            //$data=EmployeeBankDetail::where('employee_id', $id)->first();

            if ($validator->fails()||(isset($data))) {              
              $this->jsonResponse['error'] = true;
              $this->jsonResponse['message'] = "Same Entry Found!!";
              return response()->json($this->jsonResponse);  
              exit();              
            }
            $store_detail = new EmployeeBankDetail();
            $store_detail->employee_id = $request->input('employee_id');
            $store_detail->portal_id = $request->input('portal_id'); 
            $store_detail->account_holder_name = $request->input('account_holder_name'); 
            $store_detail->bank_name = $request->input('bank_name'); 
            $store_detail->account_number = $request->input('account_number');
            $store_detail->branch_name = $request->input('branch_name');
            $store_detail->iban_number = $request->input('iban_number');
            $store_detail->ifsc_code = $request->input('ifsc_code');
            
            
            if ($store_detail->save()) {              
              $this->jsonResponse['success'] = true;
              $this->jsonResponse['message'] = "Entry Created SuccessFully";            
            }
           
        return response()->json($this->jsonResponse);
    }

public function show($portal,$employee)
    {
        $data=EmployeeBankDetail::where('portal_id',$portal)->where('employee_id',$employee)->get();
        //dd('sghfjksdhjklfskl');
       
        return view('employee.partials.employeeBank',compact('data'));
    }
}
