<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\ServiceMaster;
use Log;
use Session;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */ 
    
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
        $this->middleware('guest',compact('user_data'))->except('logout');
    }

     /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {

          //dd($user);
   Log::info('LoginController@authenticated');
        $rolename = $user->user_type; 
        switch ($rolename) {
            case 'admin':
                return redirect()->route('admin.dashboard');
                break;
            case 'portal':
                return redirect()->route('portal.dashboard');
                break;
            case 'vendor':
                return redirect()->route('vendor.dashboard');
                break;
            case 'company':
                return redirect()->route('company.dashboard');
                break;
            case 'employee':
                return redirect()->route('employee.dashboard');
                break;
            default:
            Session::flush();
                return redirect('/');
                break;
        }
    }

    
}
