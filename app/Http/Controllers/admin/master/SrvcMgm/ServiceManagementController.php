<?php

namespace App\Http\Controllers\admin\master\SrvcMgm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaMasterServiceGroup;
use App\Models\VishwaMasterServiceTypes;
// use App\Models\MasterMaterialsGroup;
// use App\Models\MasterUnit;
// use App\Models\MaterialItem;
use Session;
use Validator;
use DB;
use Log;

class ServiceManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceGroup=VishwaMasterServiceGroup::all();

        // $serviceType=VishwaMasterServiceGroup::find($serviceGroup->id)->getServiceType;
       return view('admin.master.serviceManagement.service_type',compact('serviceGroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     *  a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
          'servicename' => 'required|unique:vishwa_master_service_groups,servicename',
          'is_active'=>'required'
      ]);

      $serviceGroupData=new VishwaMasterServiceGroup;

      $serviceGroupData->servicename=$request->input('servicename');
      $serviceGroupData->is_active=$request->input('is_active');
      $serviceGroupData->save();

      if(  $serviceGroupData->save()==true)
      {
      return redirect()->back()->with('success_message','Service group Added successfully');
    }
    else {
      return redirect()->back()->with('error_message','Something Went Wrong');
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        dd("gg");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      VishwaMasterServiceGroup::find($id)->delete();
      Session::flash('error_message', 'Service Group Deleted Successfully!');
      return redirect()->route('SrvcMgm.index');
    }

    public function deleteService($id)
    {
      VishwaMasterServiceTypes::find($id)->delete();
      Session::flash('error_message', 'Service Group Deleted Successfully!');
      return redirect()->back();
    }

    public function isActiveGroup(Request $request , $id)
    {
            VishwaMasterServiceGroup::where('id', $id)->update(['is_active' =>$request->input('is_active')]);

            $serviceGroup = DB::table('vishwa_master_service_groups')->get();
            if($request->input('is_active')==0){
                Session::flash('error_message', 'Status DeActivated !!');
            }else{
                Session::flash('success_message', 'Status Activated !!');

            }
            return back();
    }

    public function GetServiceItem(Request $request,$id)
   {
        $serviceGroup=VishwaMasterServiceGroup::all();
        $serviceType=VishwaMasterServiceTypes::all();
       $serviceGroupType=VishwaMasterServiceGroup::find($id);
      $filterServiceData=VishwaMasterServiceTypes::where('master_id',$id)->get();
       $groupdata=VishwaMasterServiceGroup::where('id',$id)->first();
       return view('admin.master.serviceManagement.service_type',compact('serviceType','serviceGroup','filterServiceData','serviceGroupType','groupdata'));

   }

   public function isActiveService(Request $request , $id)
  {
          VishwaMasterServiceTypes::where('id', $id)->update(['is_active' =>$request->input('is_active_item')]);
          if($request->input('is_active_item')==0){
              Session::flash('error_message', 'Status DeActivated !!');
          }else{
              Session::flash('success_message', 'Status Activated !!');

          }
          return back();

  }



  public function updateServiceGroupItem(Request $request)
  {

      $this->validate($request, [
          'edit_service_name' => 'required'

      ]);

       $postData = $request->all();
       $update_array = [
          'id'=>$postData['updated_service_item_id'],
          'servicetype'=>$postData['edit_service_name']
      ];

      $result =VishwaMasterServiceTypes::where('id','!=',$postData['edit_service_name'])
      ->where('servicetype',trim($postData['edit_service_name']))
      ->first();

      if($result == null)
      {
          VishwaMasterServiceTypes::where('id',$postData['updated_service_item_id'])->update($update_array);
          Session::flash('success_message', 'Service Type Updated successfully!');
      }
      else
      {
          Session::flash('error_message', 'Something Went Wrong');
      }

          return redirect()->back();
          // return redirect('/');

  }


  public function masterServiceGroup(Request $request)
  {

    $this->validate($request, [
        'servicename' => 'required'

    ]);

     $postData = $request->all();
     $update_array = [
        'id'=>$postData['update_id'],
        'servicename'=>$postData['servicename']
    ];

    $result = VishwaMasterServiceGroup::where('id','!=',$postData['servicename'])
    ->where('servicename',trim($postData['servicename']))
    ->first();

    if($result == null)
    {
        VishwaMasterServiceGroup::where('id',$postData['update_id'])->update($update_array);
        Session::flash('success_message', 'Service Type Updated successfully!');
    }
    else
    {
        Session::flash('error_message', 'Something Went Wrong');
    }

        // return redirect()->route('masterServiceGroup');
        return back();


}

#adding service type to service group

public function addServiceItem(Request $request,$id)
{
  // $this->validate($request, [
  //     'servicename' => 'required|unique:vishwa_master_service_item,servicetype',
  //     'is_active'=>'required'
  // ]);
    $postData =  $request->all();
    $insert_array = [
        'master_id'   =>$id,
        'servicetype' =>trim($postData['servicetype']),
        'is_active'=>trim($postData['is_active']),
    ];

    $result = VishwaMasterServiceTypes::where('servicetype',trim($postData['servicetype']))
        ->where('master_id',$id)
        ->first();
    if($result==null)
    {
       $service_item = VishwaMasterServiceTypes::insert($insert_array);
       Session::flash('success_message', 'Service Type  Added Successfully!');
    }
    else
    {
        Session::flash('error_message', 'Something Went Wrong !!');
    }
        // return redirect()->route('addServiceItem',$id);
        return back();
}

}
