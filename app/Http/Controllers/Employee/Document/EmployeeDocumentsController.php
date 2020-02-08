<?php

namespace App\Http\Controllers\Employee\Document;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeProfile;
use App\Models\Document;
use App\Models\Portal;
use App\Models\DocumentShare;
use Auth;
use Log;
use DB;
use Storage;
use Carbon\Carbon;
use Validator;
class EmployeeDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
      $employee=EmployeeProfile::where('user_id',Auth::id())->first();
      $portal=Portal::where('id',$employee->portal_id)->first();
      $empdetails=EmployeeProfile::where('portal_id',$employee->portal_id)->get();      
      $data=$empdetails->whereNotIn('user_id',Auth::id());
      $documentshare=Document::where('portal_id',Auth::user()->getEmp->portal_id)->where('employee_id',Auth::user()->getEmp->id)->get();
      return view('employee.document.upload',compact('data','empdetails','employee','portal','documentshare'));
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
      $data=$request->input('doc_share');
      $portal_id=$request->input('portal_id');
      $employee_id=$request->input('employee_id');
      DB::beginTransaction();
      try {
        $postData=$request->all();
        Log::info('upload data EmployeeDocumentsController@store'.print_r($postData,true));
        $validator = Validator::make($request->all(),[
          'doc_name' => 'required',
          'doc_description' => 'required',
          'upload_date' => 'required',
         
          'doc_file' => 'sometimes|mimes:doc,docx,xls,jpeg,jpg,gif,sql,xlsx,ppt,pdf,zip|max:10000',
          'doc_share'=>'required',
        ]);

        if ($validator->fails()){  
         return redirect()->back()->withErrors($validator)->withInput();   
        }
           $store_doc_detail = new Document();
           $store_doc_detail->portal_id = $request->input('portal_id');
           $store_doc_detail->employee_id = $request->input('employee_id'); 
           $store_doc_detail->doc_name = $request->input('doc_name');
           $store_doc_detail->upload_by = Auth::user()->name;
      
            if(($request->input('for_approval_emp_id'))==NULL)
                  $store_doc_detail->for_approval=NULL;
            else{
                  $store_doc_detail->for_approval = $request->input('for_approval_emp_id');
                }
           $store_doc_detail->doc_description = $request->input('doc_description'); 
           $store_doc_detail->upload_date = Carbon::parse($request->input('upload_date'));
           $store_doc_detail->remark_upload = $request->input('remark_upload');

           if($request->hasFile('doc_file')){
            $file = $request->file('doc_file');
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $filename = $file->getClientOriginalName();
            $name = $timestamp . '-' . $filename;  

            if($file->move('public/storage/uploads/document', $name)){

             $store_doc_detail->doc_file = $name;


           }
     }

     $store_doc_detail->save();
     $store_doc_detail_id = $store_doc_detail->id;


     $data1=$request->input('doc_share');
     $data = count($data1);

     for($i=0;$i<count($data1);$i++){


       Log::info('employee_id EmployeeDocumentsController@store==:'.print_r($data,true));
       $info_save = new DocumentShare();
       $info_save->doc_share_id= $store_doc_detail_id;
       $info_save->portal_id=$request->input('portal_id');
       $info_save->employee_id=$request->input('employee_id');
       $info_save->shareEmployee_id= $data1[$i];
       $info_save->doc_name=$request->input('doc_name');
       $info_save->created_by=Auth::user()->name;

       $info_save->save();
     }             
     $request->session()->flash('success_message','document Upload Successfully!!');       
            
     DB::commit();
   } catch (\Exception $e) {
    DB::rollback();

    $request->session()->flash('error_message','DATABASE Error Found');    
  }
  return back();
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function share(Request $request)
    {
      Log::info('my document share details = EmployeeDocumentsController@share'.print_r($request->all(),true));
     $data=EmployeeProfile::select('id','portal_id')->where('user_id',Auth::id())->first();
     $documentshare=Document::where('portal_id',$data->portal_id)->where('employee_id',$data->id)->get();
     $documentsharewith=DocumentShare::where('portal_id',$data->portal_id)->where('employee_id',$data->id)->get();
      //dd($documentshare);
     return view('employee.document.myDocumentShareDetails',compact('data','documentshare','documentsharewith'));

   }


   public function show(Request $request)
   {
  Log::info('showDocApprovalRequest EmployeeDocumentsController@show==:'.print_r($request->all(),true));
    $data=EmployeeProfile::select('id','portal_id')->where('user_id',Auth::id())->first();
    $document=Document::where('portal_id',$data->portal_id)->where('for_approval',$data->id)->get();
    return view('employee.document.showDocApprovalRequest',compact('data','document'));

  }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function documentShareWithMe(Request $request)
    {
       Log::info('docShareWithMe EmployeeDocumentsController@documentShareWithMe==:'.print_r($request->all(),true));
        $data=EmployeeProfile::select('id','portal_id')->where('user_id',Auth::id())->first();
        $documentShare=Document::where('portal_id',$data->portal_id)->get();
        $documentShareWithMe=DocumentShare::where('portal_id',$data->portal_id)->where('shareEmployee_id',$data->id)->get();
       return view('employee.document.docShareWithMe',compact('documentShare','documentShareWithMe'));
            
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
Log::info('docApproval status EmployeeDocumentsController@update==:'.print_r($request->all(),true));
      $doc_id=$request->input('doc_id');
      $status=$request->input('status');
      $remark=$request->input('remark_approve');


      if($status=='APPROVED')
      {
       $data=Document::where('id', $doc_id)->update([
        'status'=>$status,
        'active'=>1,
        'remark_approve'=>$remark,
      ]);

     }
     if($status=='PENDING')
      {
       $data=Document::where('id', $doc_id)->update([
        'status'=>$status,
        'active'=>0,
        'remark_approve'=>$remark,
      ]);

     }


     if($status=='REJECTED')
     {  
         $validator = Validator::make($request->all(),[
          'remark_approve' => 'required',
        ]);

        if ($validator->fails()){              

         return redirect()->back()->withErrors($validator)->withInput();   
       }
       $data=Document::where('id', $doc_id)->update([
        'status'=>$status,
        'active'=>2,
        'remark_approve'=>$remark,
      ]);

     }
     $request->session()->flash('success_message','document Status Updated Successfully!!');
     return back();
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getShareList(Request $request)
    {
      $postData=$request->all();
      Log::info('doc-id EmployeeDocumentsController@getShareList'.print_r($postData,true));      
      $documentsharewith=DocumentShare::where('doc_share_id',$postData['doc_id'])->get();
      foreach ($documentsharewith as $key => $value) {
        if ($value->shareEmployee_id==0) {
          $portalData=  Portal::where('id',$value->portal_id)->first();
        }
      }      
      Log::info('docs share list EmployeeDocumentsController@getShareList'.print_r($documentsharewith,true));  
      return view('employee.partials.share_list',compact('documentsharewith','portalData'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDocDetail(Request $request)
    {
      $postData=$request->all();
      Log::info('doc-id EmployeeDocumentsController@getDocDetail'.print_r($postData,true));  
      $documentshare=Document::where('id',$postData['doc_id'])->first();   
      if ($documentshare->for_approval==0) {
         $portalData=  Portal::where('id',$documentshare->portal_id)->first();
        }  
      Log::info('docs share list EmployeeDocumentsController@getDocDetail'.print_r($documentshare,true));  
      return view('employee.partials.docDetail',compact('documentshare','portalData'));            
    }
  }
