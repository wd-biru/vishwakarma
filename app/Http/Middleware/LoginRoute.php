<?php

namespace App\Http\Middleware;
// use Illuminate\Http\Request;
use Request;
use Closure;
use Auth;
use Log;
use Route;
class LoginRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

       // use AuthenticatesUsers;
    public function handle($request, Closure $next)
    {
        $userType=Auth()->user()->user_type;

        $url= Request::path();

        Log::info('LoginRoute middleware url -'.print_r($url,true));
        Log::info('User Type === '.$userType);

        $url_array=explode("/",$url); 
            // dd($url_array);
        
        if($url_array[0]==$userType or $url_array[0]=='passwordChange' or $url_array[0]=='projects' or $url_array[0]=='jobs' or $url_array[0]=='tasks'){
            return $next($request);
        }
        $request->session()->flush();
                return redirect('/');
    }
}
