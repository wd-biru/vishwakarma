<?php

namespace App\Http\Controllers\admin\portals;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use log;
use Carbon\Carbon;
use App\Models\Portal;
use Auth;

class MenuController extends Controller
{
    public $jsonResponse = ['success' => false, 'message' => 'Sorry!, unable to process your request' , 'data' => ''];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        $postData = $request->all();
        Log::info('MenuController@store INPUT DATA IDs==:'.print_r($postData,true));
        $portal=$postData['portal_id'] ;     
        Log::info('MenuController@store ON Portal id SAVE DATA==:'.print_r($portal,true));
        $user_login_id = Portal::where('id',$portal)->value('user_id');
        Log::info('MenuController@store ON login id ==:'.print_r($user_login_id,true));
        $check_data_ = DB::table('vishwa_menu_permission')->where('user_id',$user_login_id)->where('menu_id',$postData['menu_id'])->first();

        if (!empty($check_data_)) {
            if ($check_data_->is_active===0) {
                $check_data_ = DB::table('vishwa_menu_permission')->where('user_id',$user_login_id)->where('menu_id',$postData['menu_id'])->update([
                    'is_active'=> 1,
                    'updated_at' => Carbon::now(),
                ]);
                if($check_data_==true){
                    $this->jsonResponse['success'] = true;
                    $this->jsonResponse['message'] = "PERMISSON GARANTED";
                }       
                return response()->json($this->jsonResponse);
            }else{
                $check_data_ = DB::table('vishwa_menu_permission')->where('user_id',$user_login_id)->where('menu_id',$postData['menu_id'])->update([
                    'is_active'=> 0,
                    'updated_at' => Carbon::now(),
                ]);
                if($check_data_==true){
                    $this->jsonResponse['error'] = true;
                    $this->jsonResponse['message'] = "PERMISSON REVOKED";
                }       
                return response()->json($this->jsonResponse);
            }
         
        } else {
            $save_info_menu = DB::table('vishwa_menu_permission')->insert([
                'user_id' => $user_login_id,
                'menu_id' => $postData['menu_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]); 
            Log::info('MenuController@store new id data ==:'.print_r($save_info_menu,true));
            if($save_info_menu==true){
                $this->jsonResponse['success'] = true;
                $this->jsonResponse['message'] = "PERMISSON GARANTED";
            }
            return response()->json($this->jsonResponse);
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
        // Log::info('portal id for menu MenuController@show==:'.print_r($id,true));
        // $menus=DB::table('vishwa_menu_master')->where('parent_id',0)->get(['id','menu_name']);
        // if ($menus) {              
        //   $this->jsonResponse['success'] = true;
        //   $this->jsonResponse['message'] = "Same Entry Found!!";
        //   $this->jsonResponse['data'] = $menus;
        //   return response()->json($this->jsonResponse);             
        // }        
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
        //
    }
}
