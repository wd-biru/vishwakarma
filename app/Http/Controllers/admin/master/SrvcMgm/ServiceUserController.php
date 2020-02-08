<?php

namespace App\Http\Controllers\admin\master\SrvcMgm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaServiceRegistration;
use App\Models\VishwaServiceRegistrationProjects;
use Session;
use Validator;
use DB;
use Log;


class ServiceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $serviceregister=VishwaServiceRegistration::all();
      return view('admin.master.serviceManagement.service_list',compact('serviceregister'));
      // return $serviceregister->contact_name ;
      // return($serviceregister);
       // $serviceType=VishwaServiceRegistration::find($serviceregister->id)->regProject;
      // foreach($serviceregister as $list)
      // {
      //     print(count($serviceType=$list::find($list->id)->regProject));
      //     // print(count($serviceType));
      // }
      //  // return($serviceType->regProject);


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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     *
     */



    public function show($id)
    {
      // Log::info('portal ShoW Id PortalManagement@show==:'.print_r($id,true));
      // $companies = Client::where('portal_id',$id)->get();
      // $portal_show_values = Portal::find($id);
      // $email = User::where('id',$portal_show_values->user_id)->value('email');
      $viewInfo=VishwaServiceRegistration::findOrFail($id);
      return view('admin.master.serviceManagement.service_show',compact('viewInfo'));
      // return($viewInfo->contact_name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      // Log::info('Portal Edit Id PortalManagement@edit==:'.print_r($id,true));
      // $portal_edit_values = Portal::find($id);
      // $data = Auth::user()->where('id',$portal_edit_values->user_id)->first();
      // $menus=DB::table('vishwa_menu_master')->where('menu_config',1)->get();
      // $portals_menu = DB::table('vishwa_menu_permission')->where('user_id',$portal_edit_values->user_id)->where('is_active',1)->get();
      // return view('admin.portal.edit',compact('portal_edit_values','data','menus','portals_menu'));

       $viewInfo=VishwaServiceRegistration::findOrFail($id);
       return view('admin.master.serviceManagement.service_edit',compact('viewInfo'));

      // return $viewInfo;
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
        return "waiting for update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          return "waiting for action";
    }

    public function moreInfo()
    {
        return "waiting for action";
    }

    public function projectInfo()
    {
        return "waiting for action";
    }

    public function documentInfo()
    {
        return "waiting for action";
    }
}
