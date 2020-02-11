<?php

namespace App\Http\Controllers\admin\master\BankMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaBankMaster;
use DB;
use Session;

class BankMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankmasters = VishwaBankMaster::all();
        return view('admin.master.Bankmaster.index' , compact('bankmasters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.master.Bankmaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bankmaster = new VishwaBankMaster();
        $bankmaster->bank_name = $request->bank_name;
        $bankmaster->ifsc_code = $request->ifsc_code;
        $bankmaster->address  = $request->address;
        $bankmaster->country = $request->country_name;
        $bankmaster->state = $request->state_name;
        $bankmaster->city = $request->city_name;
        $bankmaster->district = $request->district;
        $bankmaster->pincode = $request->pincode;
        $bankmaster->status = $request->status;
        $bankmaster->save();
        $request->session()->flash('success_message','Bank Record Created Successfully!!'); 

       return view('admin.master.Bankmaster.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bankmaster = VishwaBankMaster::find($id);
        return view('admin.master.Bankmaster.show' ,compact('bankmaster'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bankmaster = VishwaBankMaster::find($id);
        return view('admin.master.Bankmaster.edit', compact('bankmaster'));
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
        $bankmaster = VishwaBankMaster::find($id);
        $bankmaster->bank_name = $request->bank_name;
        $bankmaster->ifsc_code = $request->ifsc_code;
        $bankmaster->address  = $request->address;
        $bankmaster->country = $request->country_name;
        $bankmaster->state = $request->state_name;
        $bankmaster->city = $request->city_name;
        $bankmaster->district = $request->district;
        $bankmaster->pincode = $request->pincode;
        $bankmaster->status = $request->status;
        $bankmaster->save();
        $request->session()->flash('success_message','Bank Record Updated Successfully!!'); 

        return redirect()->route('bankMaster.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function bankDelete($id)
    {
        $bankMaster=VishwaBankMaster::find($id)->delete();
        $request->session()->flash('success_message','Bank Record Deleted Successfully!!'); 
        return back()->with('bankMaster',$bankMaster);
    }

    public function getCityName(Request $request)
    {
        $city = strtolower($request->get('city'));
        $data = DB::table('vishwa_cities')
            ->where(strtolower('name'), 'LIKE', "%{$city}%")
            ->get();

        $output = '<ul class="dropdown-menu" style="display:block !important; position:relative !important;">';
        foreach ($data as $row) {

            $output .= '<li  class="selectCity"><a href="#" id="' . $row->id . '" data-id="' . $row->id . '" onclick="cityFadeOut(this)" data-name="' . $row->name . '" >' . $row->name. '</a></li>';
        }
        $output .= '</ul>';

        echo $output;

    }


    public function getStateName(Request $request)
    {
        $state = strtolower($request->get('state'));
        $data = DB::table('vishwa_states')
            ->where(strtolower('name'), 'LIKE', "%{$state}%")
            ->get();

        $output = '<ul class="dropdown-menu" style="display:block !important; position:relative !important;">';
        foreach ($data as $row) {

            $output .= '<li class="selectState"><a href="#" id="' . $row->id . '" data-id="' . $row->id . '" onclick="stateFadeOut(this)" data-name="' . $row->name . '" >' . $row->name. '</a></li>';
        }
        $output .= '</ul>';

        echo $output;

    }

    public function getCountryName(Request $request)
    {
        $country = strtolower($request->get('country'));
        $data = DB::table('vishwa_countries')
            ->where(strtolower('name'), 'LIKE', "%{$country}%")
            ->get();

        $output = '<ul class="dropdown-menu" style="display:block !important; position:relative !important;">';
        foreach ($data as $row) {

            $output .= '<li class="selectCountry"><a href="#" id="' . $row->id . '" data-id="' . $row->id . '" onclick="countryFadeOut(this)" data-name="' . $row->name . '" >' . $row->name. '</a></li>';
        }
        $output .= '</ul>';

        echo $output;

    }


}
