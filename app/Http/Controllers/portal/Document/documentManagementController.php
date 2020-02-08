<?php

namespace App\Http\Controllers\portal\Document;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Portal;
use App\Models\Document;
use App\Models\DocumentShare;
use App\Models\EmployeeProfile;
use Auth;
use Log;
use DB;
use Storage;
use Carbon\Carbon;
use Validator;


class DocumentManagementController extends Controller
{
    public function index()
    {      
      $portal=Portal::where('user_id',Auth::id())->first();     
      Log::info('DocumentManagementController@index data from portal id'.print_r($portal,true));
      $employeeDetails=EmployeeProfile::where('portal_id',$portal->id)->get();    
      $documentshare=Document::where('portal_id',$portal->id)->where('employee_id',NULL)->get();  
      return view('portal.document.upload',compact('portal','employeeDetails','documentshare'));
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
      
      DB::beginTransaction();
      try {
        $postData=$request->all();
        Log::info('Portal upload data documentManagementController@store'.print_r($postData,true));
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
       $store_doc_detail->doc_name = $request->input('doc_name');
       $store_doc_detail->upload_by = Auth::user()->name;
       $store_doc_detail->for_approval = $request->input('for_approval_emp_id');
       $store_doc_detail->doc_description = $request->input('doc_description'); 
       $store_doc_detail->upload_date = Carbon::parse($request->input('upload_date'));
        $store_doc_detail->status='APPROVED';

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
     Log::info('NEW ID Document documentManagementController@store'.print_r($store_doc_detail->id,true));
     $store_doc_detail_id = $store_doc_detail->id;


     $data1=$request->input('doc_share');
     $data = count($data1);

     for($i=0;$i<count($data1);$i++){


       Log::info('employee_id='.print_r($data,true));
       Log::info('on NEW CRETED ID DocumentShare documentManagementController@store'.print_r($info_save->id,true));
       $info_save = new DocumentShare();
       $info_save->doc_share_id= $store_doc_detail_id;
       $info_save->portal_id=$request->input('portal_id');
       $info_save->shareEmployee_id= $data1[$i];
       $info_save->doc_name=$request->input('doc_name');
       $info_save->created_by=Auth::user()->name;

       $info_save->save();
       Log::info('NEW ID DocumentShare documentManagementController@store'.print_r($info_save->id,true));
     }             
     $request->session()->flash('success_message','document Upload Successfully!!');       
            
     DB::commit();
   } catch (\Exception $e) {
    DB::rollback();

    $request->session()->flash('error_message','DATABASE Error Found');    
  }

  return redirect()->route('documentManagemet.index');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function share(Request $request)
    {
      Log::info('my document share details = documentManagementController@share'.print_r($request->all(),true));
     $data=Portal::where('user_id',Auth::id())->first();
     $documentshare=Document::where('portal_id',$data->id)->where('employee_id',NULL)->get();
     
     $documentsharewith=DocumentShare::where('portal_id',$data->id)->where('employee_id',NULL)->get();
     
     return view('portal.document.myDocumentShareDetails',compact('data','documentshare','documentsharewith'));

   }


    public function show(Request $request)
    {
      Log::info('Approval documentManagementController@show'.print_r($request->all(),true));
      $data=Portal::where('user_id',Auth::id())->first();
      $document=Document::where('portal_id',$data->id)->where('for_approval',0)->where('employee_id','!=',null)->get();
      return view('portal.document.showDocApprovalRequest',compact('data','document'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function documentShareWithMe(Request $request)
    {
       Log::info('docShareWithMe = documentManagementController@documentShareWithMe'.print_r($request->all(),true));
        $data=Portal::where('user_id',Auth::id())->first();
         $documentShare=Document::where('portal_id',$data->id)->where('employee_id','!=',NULL)->get();
        $documentShareWithMe=DocumentShare::where('portal_id',$data->id)->where('shareEmployee_id',0)->get();

       return view('portal.document.docShareWithMe',compact('documentShare','documentShareWithMe'));
            
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
Log::info('docApproval status = EmployeeDocumentsController@update'.print_r($request->all(),true));
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
      return view('portal.document.partials.share_list',compact('documentsharewith','portalData'));
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
      $documentshare=Document::where('portal_id',Auth::user()->getPortal->id)->where('employee_id',NULL)->where('id',$postData['doc_id'])->first();   
      return view('portal.document.partials.docDetail',compact('documentshare'));            
    }
}
