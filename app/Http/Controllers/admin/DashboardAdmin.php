<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Portal;
use App\Models\AdminImage;
use App\User;
use Auth;
use Validator;
use Storage;

class DashboardAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portals = Portal::all();
        return view('admin.dashboard',compact('portals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.master.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = Auth::user()->id;
        $data = User::where('id',$id)->first();
        $imgdata = AdminImage::where('user_id', $id)->orderBy('id', 'desc')->first();
        return view('admin.profile.show',compact('data','imgdata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $portal_id = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admin_data = new AdminImage();
        if($request->hasfile('image_name'))
            {
                $file = $request->file('image_name');
                $extension = $file->getClientOriginalExtension();
                $fileName =time().'.'.$extension;
                if(Storage::disk('uploads')->put('admin_images/'.$fileName,file_get_contents($request->file('image_name')))){
                    $admin_data->image_name = $fileName;
                }
            }
        $admin_data->user_id = Auth::user()->id;
        $admin_data->save();
        $id = Auth::user()->id;
        $data = User::where('id',$id)->first();
        $data->name=$request->input('name');
        $data->save();
        $request->session()->flash('success_message','Update Successfully!!');
        return redirect()->route('admin.profile');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
