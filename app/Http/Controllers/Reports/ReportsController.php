<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaVendorsRegistration;
use App\Models\MasterUnit;
use App\Models\MaterialItem;
use App\Models\VishwaStoreInventoryQuantity;
use App\Models\Cities;
use App\Models\MasterMaterialsGroup;
use App\Models\Portal;
use App\Models\VishwaProjectStore;
use App\Entities\Projects\Project; 
use App\User;
use Session;
use DB;
use Validator;
use Log;
use Auth;
use Response;

class ReportsController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

            $id = Auth::user()->id;
            $emp_id = null;
            $reportdata = null;
            if(Auth::user()->user_type=="employee")
            {       

            }
            else
            {
            $reuslt = Portal::where('user_id',$id)->first();
            $portal_id = $reuslt->id;
            }

             $projects = Project::where('portal_id',$portal_id)->get();
             $MaterialsGroup =MasterMaterialsGroup::all();
          
 
        return view('Reports.index',compact('store_detail','projects','MaterialsGroup','reportdata'));
    }


    public function getStore(Request $request)
    {   
      
        $project_id = $request->input('project_id');
        $projects = VishwaProjectStore::where('project_id',$project_id)->get();
        return $projects;
       
    }

    public function getReport(Request $request)
    {   

       // dd($request->all());

             $project_id = $request->input('project');
             $store_id = $request->input('store');
             $material_group_id = $request->input('material_group');


             $id = Auth::user()->id;
            $emp_id = null;
            if(Auth::user()->user_type=="employee")
            {       

            }
            else
            {
            $reuslt = Portal::where('user_id',$id)->first();
            $portal_id = $reuslt->id;
            }





             $projects = Project::where('portal_id',$portal_id)->get();
             $MaterialsGroup =MasterMaterialsGroup::all();
          


                 $reportdata = VishwaStoreInventoryQuantity::join('vishwa_materials_item','vishwa_materials_item.id','vishwa_store_inventory_qty.item_id')
                  ->where('vishwa_store_inventory_qty.project_id',$project_id)
                  ->where('vishwa_store_inventory_qty.group_id',$material_group_id)
                  ->where('vishwa_store_inventory_qty.store_id',$store_id)  
                  ->groupBy('item_id')
                   ->select('vishwa_materials_item.*','vishwa_store_inventory_qty.portal_id','vishwa_store_inventory_qty.item_id','vishwa_store_inventory_qty.project_id','vishwa_store_inventory_qty.store_id',DB::raw("SUM(vishwa_store_inventory_qty.qty) as availableQty"))
                  ->get();  

                  //dd($reportdata);

                  

              return view('Reports.index',compact('store_detail','projects','MaterialsGroup','reportdata'));
    
       
    }

    public function getitemtransaction(Request $request)
    {   
      // /  dd($request->all());

        
        $store_id = $request->input('store');
        $item_id = $request->input('item');
        $portal_id = $request->input('portal');
        $project_id = $request->input('project');

        $transdata = VishwaStoreInventoryQuantity::where('project_id',$project_id)
                  ->where('portal_id',$portal_id)
                  ->where('store_id',$store_id)
                  ->where('item_id',$item_id) 
                  ->get();  


                 $store = VishwaProjectStore::all();



                   
            return Response::json(array('data' => $transdata,'store' => $store));
       
    }



}