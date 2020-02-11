<?php

namespace App\Http\Controllers\admin\master\itemType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DepartmentMaster;
use App\Models\VishwaGroupType;
use App\Models\MasterMaterialsGroup;
use Validator;
use DB;
use Log;
use Session;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $group_type = VishwaGroupType::all();
        return view('admin.master.itemtype.index',compact('group_type'));
    }


      public function store(Request $request)
    {                  
        $this->validate($request, [
            'group_type_name' => 'required|unique:vishwa_group_type,group_type_name',
        ]);

        $GroupType = new VishwaGroupType();
        $GroupType->group_type_name = trim($request->input('group_type_name'));        
         if($GroupType->save()){
                
            Session::flash('success_message', 'Group Category  Added Successfully!'); 

        }else
        {
            Session::flash('error_message', 'Some error Occur !!'); 
        }
            return redirect()->route('itemType.master') ;            
    }


     public function edit($id)
    {
        $GroupType = VishwaGroupType::find($id);
        
        return view('admin.master.itemtype.item_type_edit',compact('GroupType'));
    }


       public function update(Request $request)
    {
        Log::info('employee Update data DashboardEmployee@update ==:'.print_r($request->all(),true));

       $id = $request->input('id');
        $validator = Validator::make($request->all(),[
            'group_type_name' => 'required|unique:vishwa_group_type,group_type_name,'.$id,
            
        ]);
        //dd($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
       
        $data = VishwaGroupType::where('id',$id)->update([

            'group_type_name'=>$request->input('group_type_name'),
        
       ]);
        $request->session()->flash('success_message','Update Successfully!!');
        return redirect()->route('itemType.master');
    }

     public function delete($id)
    {
    
        VishwaGroupType::find($id)->delete();
        Session::flash('error_message', 'Group Category Deleted Successfully!');
        return redirect()->route('itemType.master');
    }





    public function getGroups(Request $request)
    {

    $group_type_id=$request->group_type_id;

    $data = MasterMaterialsGroup::where('group_type_id',$group_type_id)->get();

    return response()->json($data);
    }


    }