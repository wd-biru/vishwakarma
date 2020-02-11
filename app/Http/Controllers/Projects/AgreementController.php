<?php

namespace App\Http\Controllers\Projects;

use App\Models\IndentMaster;
use App\Models\VishwaAgreementFile;
use Illuminate\Http\Request;
use App\Models\AgreementItem;
use Illuminate\Support\Facades\DB;
use App\Entities\Projects\Project;
use App\Models\VishwaProjectStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterMaterialsGroup;
use App\Models\VishwaVendorsRegistration;
use App\Models\VishwaVendorIndentMapping;
use Validator;
use App\Models\VishwaGroupType;



class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     */

    public function index(Project $project)
    {
        
        $pro_id=$project->id;
        $record = IndentMaster::Join('users', 'vishwa_indent_masters.created_by', '=', 'users.id')
            ->Join('vishwa_projects', 'vishwa_indent_masters.project_id', '=', 'vishwa_projects.id')
            ->where('vishwa_indent_masters.project_id', $pro_id)
            ->select('vishwa_indent_masters.*','users.name as user_name')
            ->orderByDesc('id')
            ->get();
        return view('projects.agreement.index' , compact('project','data','record'));

    }


    public function Addagreement(Project $project, Request $request)
    {
        $groupType = VishwaGroupType::where('group_type_name','rentable')->first();
        $material_group = MasterMaterialsGroup::where('group_type_id',$groupType->id)->get();

        return view('projects.agreement.addagreement', compact('project', 'material_group'));
    }

    public function viewAgreement(Project $project, Request $request)
    {
        $arr = AgreementItem::pluck('item_id')->toArray();

        $data=DB::table('vishwa_materials_item')
            ->join('vishwa_rentable_item_price','vishwa_materials_item.id','vishwa_rentable_item_price.item_id')
            ->whereIn('vishwa_materials_item.id',$arr)
            ->select('vishwa_materials_item.material_name','vishwa_rentable_item_price.*')
            ->orderBy('id','desc')
            ->get();

        return view('projects.agreement.viewagreement' , compact('project','data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project,Request $request)
    {
        $this->validate($request, [
            'recovery_rate' => 'required',
        ]);

        $group_id = $request->input('group_id');
        $grp_arr = count($group_id);
        for ($i = 0; $i < $grp_arr; $i++) {
            $agreementItem = new AgreementItem();
            $agreementItem->item_id = $request->item_id[$i];
            $agreementItem->recovery_rate = $request->recovery_rate[$i];
            $agreementItem->remarks = $request->remarks[$i];
            $agreementItem->save();
        }
        $request->session()->flash('success_message','Agreement item successfully created.');
        return redirect()->route('projects.agreement.index', compact('project'));

    }


    public function updateAgreement(Project $project, Request $request)
    {
        $this->validate($request, [
            'recovery_rate' => 'required',
        ]);

        $id = $request->updated_material_item_id;
        $agreementItem = AgreementItem::find($id);
        $agreementItem->recovery_rate = $request->recovery_rate;
        $agreementItem->remarks = $request->remarks;
        $agreementItem->save();

        $request->session()->flash('success_message','Agreement item updated successfully .');
        return redirect()->route('projects.agreement.index', compact('project'));

    }

    public function deleteAgreement(Request $request , $id)
    {
        $editInfo=AgreementItem::where('id',$id)->delete();

        $request->session()->flash('success_message','Agreement item deleted successfully .');
        return redirect()->back();

    }

    public function uploadAgreement(Project $project,Request $request)
    {
        return view('projects.agreement.upload', compact('project'));
    }


    public function dropzoneStore(Request $request)
    {

        $target_dir = "public/images/uploads/Agreements_Copy/";
        $Filename = $request->file('uploadedDocx');
        $oldFilename = $Filename->getClientOriginalName();
        $path_parts = pathinfo($oldFilename);
        $newFileName = $path_parts['filename'] . '_' . time() . '.' . $path_parts['extension'];
        $target_file = $target_dir . $newFileName;

        if ($request->hasfile('uploadedDocx')) {
            if (move_uploaded_file($_FILES['uploadedDocx']['tmp_name'], $target_file)) {
                $status = 1;
            }
            $client_data = new VishwaAgreementFile();
//            $client_data->agreement_id = $request->input('client_id');
            $client_data->uploaded_docx = $newFileName;
            $client_data->save();
        }

    }


}



    

     





     

