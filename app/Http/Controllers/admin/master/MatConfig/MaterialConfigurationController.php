<?php

namespace App\Http\Controllers\admin\master\MatConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MaterialConfig;
use App\Models\MaterialFormulae;
use Session;
use DB;
use Validator;

class MaterialConfigurationController extends Controller
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
    public function index(Request $request)
    {   

        $materialConfigs = MaterialConfig::where('item_id',$request->id)->get();
        $material_config_by_item = MaterialConfig::where('item_id',$request->id)->get();
        $materialFormulae = MaterialFormulae::where('item_id',$request->id)->get();

        return view('admin.master.MatConfig.index' ,compact('request','materialConfigs','material_config_by_item','materialFormulae'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $materialConfig = new MaterialConfig();
        $materialConfig->item_id = $request->item_id;
        $materialConfig->item_name = $request->item_name;
        $materialConfig->label_text = $request->label_text;
        $materialConfig->control_type = $request->control_type;
        $materialConfig->default_value = $request->default_value;
        $materialConfig->is_calculated = $request->is_calculated;
        $materialConfig->save();

        // if($request->is_calculated == 'true'){
        // $formulae = implode(",",$request->input('formulae'));
        // $MaterialFormulae = new MaterialFormulae();
        // $MaterialFormulae->item_id = $request->item_id;
        // $MaterialFormulae->formulae = $formulae;
        // $MaterialFormulae->save();


        // }

        return redirect()->back()->with('success', 'Data Inserted Successfully');;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateMaterialConfigItem(Request $request)
    {
        $update_id = $request->updated_material_item_id;
        $materialConfig = MaterialConfig::find($update_id);
        $materialConfig->label_text = $request->label_text;
        $materialConfig->control_type = $request->control_type;
        $materialConfig->default_value = $request->default_value;
        $materialConfig->is_calculated = $request->is_calculated;
        $materialConfig->save();

        return redirect()->back();

    }


     public function editFormulae($id,$item_id)
    {

         $formulae = array();
         $materialConfig =  MaterialConfig::find($id);
       
         $material_config_by_item = MaterialConfig::where('item_id',$item_id)->get();
        $mat_formulae = MaterialFormulae::where('id',$id)->first();

          if(!empty($mat_formulae)){
            $formulae = explode(",",$mat_formulae->formulae);
          }
     
  
        return view('admin.master.MatConfig.material_config_edit',compact('materialConfig','mat_formulae','material_config_by_item','item_id','formulae'));
    }


      public function UpdateFormulae(Request $request)
    {
     
      
        $formulae = implode(",",$request->input('formulae'));
        $update_id = $request->mat_formulae_id;
        if(!empty($update_id)){
            $MaterialFormulae = MaterialFormulae::find($update_id);
        }else{
             $MaterialFormulae = new MaterialFormulae();
        }
        $MaterialFormulae->item_id = $request->item_id;
        $MaterialFormulae->formulae_name = $request->formulae_name;
        $MaterialFormulae->formulae = $formulae;
        $MaterialFormulae->save();

        return redirect()->back();
    }

       public function deleteConfig($id)
    {
    
        MaterialConfig::find($id)->delete();
        Session::flash('error_message', 'Material Config Deleted Successfully!');
        return redirect()->route('master.matMgmt');
    }

         public function deleteFormulae($id)
    {
    
        MaterialFormulae::find($id)->delete();
        Session::flash('error_message', 'Material formulae Deleted Successfully!');
        return redirect()->route('master.matMgmt');
    }

    
}
       