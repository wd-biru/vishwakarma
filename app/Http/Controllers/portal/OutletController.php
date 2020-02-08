<?php

namespace App\Http\Controllers\portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class OutletController extends Controller
{


    public function index(Request $request)
    {

        if (Auth::user()->getRocode!=null) {

            $rocode=Auth::user()->getRocode->id;
//            dd($rocode);

        }
        $AdminconfigtModelss = DB::table('vishwa_admin_configs')
            ->leftjoin('vishwa_outlet_configs','vishwa_outlet_configs.field_name','vishwa_admin_configs.field_name')
            ->where('vishwa_outlet_configs.portal_no',$rocode)
            ->orderBy('vishwa_admin_configs.config_order')
            ->get();
        $AdminconfigtModels = $AdminconfigtModelss->groupBy('category');
        // dd($AdminconfigtModelss,$AdminconfigtModels);
        // dd( $AdminconfigtModels);

//        dd($AdminconfigtModelss);
        return view('portal.outlet_config',compact('AdminconfigtModels'));
    }

}
