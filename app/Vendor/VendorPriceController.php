<?php
namespace App\Http\Controllers\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaVendorsRegistration;
use App\Models\MasterUnit;
use App\Models\MaterialItem;
use App\Models\VishwaVendorsPrice;
use App\Models\MasterMaterialsGroup;
use App\Models\Portal;
use App\Models\VishwaVendorPortalMapping;
use App\Models\VishwaVendorIndentMapping;
use App\Models\VishwaIndentVendorsPrice;
use App\Models\IndentMaster;
use App\User;
use Session;
use DB;
use Validator;
use Carbon\Carbon;
use Log;
use Auth;
use App\Models\VishwaGroupType;

class VendorPriceController extends Controller
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
     

        $vendor_material_group=MasterMaterialsGroup::all(); 
        $group_type = VishwaGroupType::all();

        return view('vendor-user.VendorPrice.vendor_price',compact('vendor_material_group','group_type'));
    }

    public function getItemListPrice(Request $request)
    { 
          
        $group_type_id=$request->group_type_id;
        
        $group_id=$request->group_id;

         $group_type_name=DB::table('vishwa_group_type')
            ->select('group_type_name')
            ->where('id',$group_type_id) 
            ->first(); 
        $mat_itam_list=DB::table('vishwa_materials_item')
            ->join('vishwa_unit_masters','vishwa_materials_item.material_unit','vishwa_unit_masters.id')
            ->where('vishwa_materials_item.group_id',$group_id) 
            ->select('vishwa_materials_item.*','vishwa_unit_masters.material_unit')
            ->get(); 
        $getVendorItemPrice = VishwaVendorsPrice::where('vendor_id',Auth::user()->getVendor->id)->where('group_id',$group_id)->get();

       
        return view('vendor-user.VendorPrice.partials.create-list',compact('mat_itam_list','getVendorItemPrice'));

    }

    public function vedorIndent(Request $request)
    { 
  
        $indentVendor = VishwaVendorIndentMapping::where('vendor_id',Auth::user()->getVendor->id)->orderBy('indent_id', 'desc')->get(); 

    


        return view('vendor-user.VendorPrice.vendor_indent',compact('indentVendor'));


        // return response()->json($data);
    }

    public function vendorIndentPrice(Request $request,$id)
    {   

        $indentVendor = VishwaVendorIndentMapping::where('vendor_id',Auth::user()->getVendor->id)->get();
        $vendor_item_price =  DB::select("SELECT vishwa_indent_items.*, vishwa_materials_item.material_name,       vishwa_indent_items.qty  FROM `vishwa_indent_items`
              INNER JOIN vishwa_materials_item ON vishwa_materials_item.id=vishwa_indent_items.item_id
                   WHERE vishwa_indent_items.group_id= vishwa_materials_item.group_id
                   AND vishwa_indent_items.indent_id='$id'");

       // $vendor_indent_id = IndentItem::where('vishwa_indent_items.indent_id',$id)->first();
                            
        $vendor_indent_id = VishwaIndentVendorsPrice::where('vendor_id',Auth::user()->getVendor->id)
        ->where('indent_id',$id)
        ->first();  

      

        $getIndentPrice = VishwaIndentVendorsPrice::where('vendor_id',Auth::user()->getVendor->id)
        ->where('indent_id',$id)
        ->get();


        // $maxIndentPrice = VishwaIndentVendorsPrice::where('vendor_id',Auth::user()->getVendor->id)
        // ->get();

        return view('vendor-user.VendorPrice.vendor_indent',compact('indentVendor','vendor_item_price','getIndentPrice','vendor_indent_id' ,'id'));
        
    }


    public function getEachVendorPrice(Request $request)
    {

        $item_id=$request->item_id;
        $vendor_id=$request->vendor_id;
        $indent_id=$request->indent_id;
        $price=$request->price;
        $obj = new IndentMaster();
        $valueLowest = $obj->getPriceAginstEachVendor($vendor_id,$indent_id,$item_id,$price); 
        return response()->json($valueLowest);
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIndentyPrice(Request $request)
    {
     
      $vendor_id  = Auth::user()->getVendor->id;
      
      $updated_id = $request->input('updated_id');
      $item_id = $request->input('item_id');
      $indent_id = $request->input('indent_id');
      $unit = $request->input('unit');
      $qty = $request->input('qty');
      $price =  $request->input('price');
      $total =  $request->input('total');
      $tax_rate =  $request->input('tax_rate');
      $remarks =  $request->input('remarks');
      $freight =  $request->input('freight');
      $loading =  $request->input('loading');
      $kpcharges =  $request->input('kpcharges');


      foreach ($item_id as $key => $value) {

        if($price[$key] != null && $total[$key]!= null && $tax_rate[$key]!= null && $freight!= null && $loading!= null && $kpcharges!= null){

          $update = VishwaIndentVendorsPrice::where('item_id',$value)->where('indent_id',$indent_id[$key])->where('vendor_id',$vendor_id)->delete();
          $material_data =  MaterialItem::find($value);
          $VishwaIndentPrice = new VishwaIndentVendorsPrice();
          $VishwaIndentPrice->vendor_id = $vendor_id;
          $VishwaIndentPrice->indent_id = $indent_id[$key];
          $VishwaIndentPrice->item_id = $value;
          $VishwaIndentPrice->unit = $unit[$key];
          $VishwaIndentPrice->qty = $qty[$key];
          $VishwaIndentPrice->price = $price[$key];
          $VishwaIndentPrice->total = $total[$key];
          $VishwaIndentPrice->tax_rate = $tax_rate[$key];
          $VishwaIndentPrice->remarks = $remarks[$key];
          $VishwaIndentPrice->group_id = $material_data->group_id;
          $VishwaIndentPrice->material_name =$material_data->material_name;
          $VishwaIndentPrice->freight = $freight;
          $VishwaIndentPrice->loading = $loading;
          $VishwaIndentPrice->kpcharges =$kpcharges;
          $VishwaIndentPrice->save();

        }  # code...
      }
        Session::flash('success_message', 'Vendor Indent Price Added Successfully!');
        return redirect()->back();
    }



     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePrice(Request $request)
    {

      //  dd($request->all());

        $item_id = $request->input('item_id');
        $price = $request->input('price');
        $effective_date = $request->input('effective_date');
        $VishwaVendorsPricearray = null;
        $VishwaStageDetailsarrayemp = null;
        $VishwaStageDetailsarrayseq = null;




        foreach ($item_id as $key => $item_idvalue)
        { 
            if($price[$key] != null && $effective_date[$key]!= null) {

           
            
                $update = VishwaVendorsPrice::where('item_id',$item_idvalue)->where('vendor_id',Auth::user()->getVendor->id)->delete();
        
                $VishwaVendorsPrice = new VishwaVendorsPrice();
                $VishwaVendorsPrice->vendor_id = Auth::user()->getVendor->id;
                $VishwaVendorsPrice->group_id = $request->input('group_id');
                $VishwaVendorsPrice->portal_id = null;
                $VishwaVendorsPrice->item_id = $item_idvalue;
                $VishwaVendorsPrice->price = $price[$key];
                $_dates = new Carbon(str_replace('/', '-',$effective_date[$key])); 
                $date = date('Y-m-d', strtotime($_dates)); 
                $VishwaVendorsPrice->effective_date = $date;
                $VishwaVendorsPrice->save();
            }
        } 
            Session::flash('success_message', 'Vendor Price Added Successfully!');
            return back();

         

       
    }


    
}