<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','check_role']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/login');
    }


    public function passwordChange(Request $request)
    {
        $id = Auth::user()->id;
        $details =Auth::user()->where('id',$id)->update([
                'email'  =>  $request->input('email'),
                'password'  =>  bcrypt($request->input('password')),
        ]);
        $request->session()->flash('success_message','Password Change Successfully!!'); 
        $rolename = Auth::user()->user_type;
        //dd($rolename);
        switch ($rolename) {
            case 'admin':
                return redirect()->route('admin.dashboard');
                break;
            case 'portal':
                return redirect()->route('portal.dashboard');
                break;
            case 'company':
                return redirect()->route('company.dashboard');
                break;
            case 'employee':
                return redirect()->route('employee.dashboard');
                break;
            default:
                return redirect()->route('logout');
                break;
        }

      
    }
}
