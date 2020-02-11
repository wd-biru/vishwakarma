<?php

namespace App\Http\Controllers\admin\master\ActivityGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VishwaManPower;

class ManPowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manPowers = VishwaManPower::all();
        return view('admin.master.Manpower.index' , compact('manPowers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.master.Manpower.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $manPower = new VishwaManPower();
        $manPower->man_power_type = $request->man_power_type;
        $manPower->save(); 
        $request->Session()->flash('success_message','Man Power Added Successfully!!');
        return redirect()->route('manPower.index') ; 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manPower = VishwaManPower::find($id);
        return view('admin.master.Manpower.edit' , compact('manPower'));
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
        $manPower = VishwaManPower::find($id);
        $manPower->man_power_type = $request->man_power_type;
        $manPower->save(); 
        $request->Session()->flash('success_message','man Power Updated Successfully!!');
        return redirect()->route('manPower.index') ; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteManPower($id)
    {
        $manPower = VishwaManPower::find($id)->delete();
        Session()->flash('success_message','Man Power Deleted Successfully!!');
        return redirect()->route('manPower.index') ; 
    }
}
