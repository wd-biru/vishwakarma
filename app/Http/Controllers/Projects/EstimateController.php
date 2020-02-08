<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\JobsRepository;
use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\Jobs\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB;
use Validator;

use Session;
use App\Models\MaterialItem;
use App\Models\Indent;
use App\Models\MasterMaterialsGroup;
use Log;

use PDF;

/**
 * Project Jobs Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class EstimateController extends Controller
{


    public function index(Project $project)
    {
        $material_item = null;
        $material_group = MasterMaterialsGroup::all();
        $record = Indent::all();

        $Indent = $record->groupBy('unique_no');


        return view('projects.estimate.index', compact('project', 'material_group', 'material_item', 'Indent'));
    }


    public function Addindent(Project $project, Request $request)
    {
        $pro_id = $request->input('project_id');

        $material_group = MasterMaterialsGroup::all();


        return view('projects.estimate.addindent', compact('project', 'material_group', 'pro_id'));
    }


//    public function Getmaterialitem(Project $project)
//    {
//
//////        $data = MaterialItem::select('group_id','material_name')->where('id',$group_id)->take(100)->get();
////        $data=DB::table('vishwa_materials_item')
////            ->join('vishwa_unit_masters','vishwa_materials_item.material_unit','vishwa_unit_masters.id')
////            ->where('vishwa_materials_item.group_id',$group_id)
////            ->get();
//
//        return response()->json($group_id);
//    }

    public function getmatrial(Project $project)
    {

////        $data = MaterialItem::select('group_id','material_name')->where('id',$group_id)->take(100)->get();
//        $data=DB::table('vishwa_materials_item')
//            ->join('vishwa_unit_masters','vishwa_materials_item.material_unit','vishwa_unit_masters.id')
//            ->where('vishwa_materials_item.group_id',$group_id)
//            ->get();

        return response()->json($project);
    }






    public function downloadPDF(Project $project, Request $request)
    {


        $unique_no = $request->input('unique_no');

        $indent = DB::table('vishwa_indent')
            ->Join('vishwa_master_material_group', 'vishwa_indent.group_id', '=', 'vishwa_master_material_group.id')
            ->where('vishwa_indent.unique_no', $unique_no)
            ->get();


        $pdf = PDF::loadView('projects.estimate.pdf', compact('indent'));
        return $pdf->download('indent.pdf');

    }


    /**
     * @param Project $project
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insertindent(Project $project, Request $request)
    {


        $created_by = Auth::user()->id;
        $input = $request->all();
        $group_id = $request->input('group_id');
        $unique_no = rand();
        $project_id = $request->input('project_id');
        $inserted_value[] = "";
        $input_text[] = "";
        $input_qty[] = "";


        foreach ($group_id as $group_key => $group_value) {
            $indent = new Indent();
            $indent->unique_no = $unique_no;
            $indent->group_id = $group_value;
            $indent->project_id = $project_id;
            $indent->created_by = $created_by;
            $indent->save();
            $inserted_value[] = $indent->id;



            $count = 0;
            foreach ($input as $input_key => $input_value) {

                $input_text[] = $input_key;
                $input_qty[] = $input_value;

            }

            $input_field_count = count($input_text) - 1;
            $input_qty_count = count($input_qty) - 1;
            $ins = count($inserted_value);

            for ($j = 0; $j < $ins; $j++) {

                $mat_item = MaterialItem::all();

                for ($k = 4; $k <= $input_field_count; $k++) {
                    foreach ($mat_item as $item) {

                        if (($item->material_name == $input_text[$k]) && ($input_qty[$k] != null)) {

                            $indents = new Indent();
                            $indents->where('id', $inserted_value[$j]);

                            $indents->item_name = $item->material_name;
                            $indents->qty = $input_qty[$k];
                            $indents->item_id = $item->id;
                            $indents->save();

                        }


                    }


                }
                return redirect()->route('projects.estimation.index', ['id' => $project_id]);
            }

        }
    }
}






     

