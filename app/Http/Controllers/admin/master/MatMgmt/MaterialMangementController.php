<?php

namespace App\Http\Controllers\admin\master\MatMgmt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterMaterialsGroup;
use App\Models\VishwaGroupType;
use App\Models\MasterUnit;
use App\Models\MaterialItem;
use Session;
use DB;
use Validator;

class MaterialMangementController extends Controller
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
        $group_type_id = $request->input('group_type_id');
        if($group_type_id == null){
              $group_material = MasterMaterialsGroup::all();
          }else{
              $group_material = MasterMaterialsGroup::where('group_type_id',$group_type_id)->get();
          }
      
        $group_type = VishwaGroupType::all();
       

       // dd($group_type);
        return view('admin.master.MatMgmt.group_material',compact('group_material','group_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {                  
        $this->validate($request, [
             'group_type_id' => 'required',
            'group_name' => 'required',
        ]);

        $groupmaterial = new MasterMaterialsGroup();
        $groupmaterial->group_name = trim($request->input('group_name'));
        $groupmaterial->group_type_id = trim($request->input('group_type_id'));          
        $result = MasterMaterialsGroup::where('group_name',trim($groupmaterial->group_name))->first();  

        if($result==null)
        {
            $groupmaterial->save(); 
            Session::flash('success_message', 'Group Material  Added Successfully!'); 
        }
        else
        {
            Session::flash('error_message', 'Group Material Already Exits !!'); 
        }
            return redirect()->route('master.matMgmt') ;            
    }


    public function GroupMaterialIsActive(Request $request , $id)
    {
         
        
            MasterMaterialsGroup::where('id', $id)->update(['is_active' =>$request->input('is_active')]);

            $group_material = MasterMaterialsGroup::get();
            if($request->input('is_active')==0){
                Session::flash('error_message', 'Status DeActivated !!'); 
            }else{
                Session::flash('success_message', 'Status Activated !!'); 

            }
            return back();
    }

     public function GroupMaterialIsActiveItem(Request $request , $id)
    {
         
        
            MaterialItem::where('id', $id)->update(['is_active_item' =>$request->input('is_active_item')]);

            $group_material_item = MaterialItem::get();

            if($request->input('is_active_item')==0){
                Session::flash('error_message', 'Status DeActivated !!'); 
            }else{
                Session::flash('success_message', 'Status Activated !!'); 

            }
            return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {   
            return view('admin.master.MatMgmt.group_material') ;
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $group_material = MasterMaterials::find($id);
        // return view('admin.master.MatMgmt.edit-group_material');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function masterGroupUpdate(Request $request)
    {
       
       
        $this->validate($request, [
            'group_name' => 'required'
            
        ]);
        
         $postData = $request->all();
         $update_array = [
            'id'=>$postData['update_id'],
            'group_name'=>$postData['group_name'] 
        ];

        $result = MasterMaterialsGroup::where('id','!=',$postData['group_name'])
        ->where('group_name',trim($postData['group_name']))
        ->first(); 

        if($result == null)
        {

            MasterMaterialsGroup::where('id',$postData['update_id'])->update($update_array);
            Session::flash('success_message', 'Group Material  Updated successfully!');            
        }
        else
        {
            Session::flash('error_message', 'Group Material  Not Updated!!');
        }

            return redirect()->route('master.matMgmt');
        
    }

     public function Getgroupitem(Request $request,$id)
    {   
      
        $material_unit = MasterUnit::all();
        $group_material = MasterMaterialsGroup::all();
//        $material_item = MaterialItem::where('group_id',$id)->get();

         $group_type = VishwaGroupType::all();
        $material_item=DB::table('vishwa_materials_item')
            ->join('vishwa_unit_masters','vishwa_materials_item.material_unit','vishwa_unit_masters.id')
            ->where('vishwa_materials_item.group_id',$id)
            ->select('vishwa_materials_item.*','vishwa_unit_masters.material_unit as mat_unit')->get();
               
        $groupdata = MasterMaterialsGroup::where('id',$id)->first();


        return view('admin.master.MatMgmt.group_material',compact('group_material','material_item','groupdata','material_unit','group_type'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addGroupItem(Request $request,$g_id)
    {
        $postData =  $request->all();
        $insert_array = [
            'group_id'      =>$g_id,
            'material_name' =>trim($postData['material_name']),
            'material_unit' =>trim($postData['material_unit']),
            'material_description'=>trim($postData['material_description'])
        ];

        $result =MaterialItem::where('material_name',trim($postData['material_name']))
            ->where('group_id',$g_id)
            ->first();         
        if($result==null)
        {    
           $material_item = MaterialItem::insert($insert_array);
           Session::flash('success_message', 'Material Item  Added Successfully!'); 
        }
        else
        {
            Session::flash('error_message', 'Material Item Name Already Exits !!'); 
        }
            return redirect()->route('Getgroupitem',$g_id); 
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        MasterMaterialsGroup::find($id)->delete();
        Session::flash('error_message', 'Group Material Deleted Successfully!');
        return redirect()->route('master.matMgmt');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteGroupItem($id)
    {
       
        $g_id=MaterialItem::where('id',$id)->first()->group_id;
        MaterialItem::find($id)->delete();        
        Session::flash('error_message', 'Group Material Item Deleted Successfully!');
        return redirect()->route('Getgroupitem',$g_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateGroupItem(Request $request)
    { 
        $postData =  $request->all();
        $update_material_item_array = [
            'id'      =>$postData['updated_material_item_id'],
            'material_name'=>trim($postData['material_name']),
            'material_unit'=>trim($postData['material_unit']),
            'material_description'=>trim($postData['material_description'])
        ];

        $result = MaterialItem::where('id','!=',$postData['updated_material_item_id'])
            ->where('material_name',trim($postData['material_name']))
            ->first();  

        if($result == null)
        {
            MaterialItem::where('id',$postData['updated_material_item_id'])->update($update_material_item_array);
            Session::flash('success_message', 'Group Material Item Updated Successfully!');             
        }
        else
        {
            Session::flash('error_message', 'Group Material Item Not Updated!!');
        }
            $g_id=MaterialItem::where('id',$postData['updated_material_item_id'])
            ->first()->group_id;
             return redirect()->route('Getgroupitem',$g_id);
    }
}
       