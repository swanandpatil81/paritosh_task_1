<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;
use Validator;
use Session;
use Hash;

class LoginController extends Controller{
    
	function index(Request $request){

        if(! $request->session()->get('user_id')){
            return view('login'); 
        }else{
            return redirect('/distance_calc?distance=800&smoothroad=400&badroad=200&workinprogress=200&break=');
        }
    }

    function check_login(Request $request){
		$this->validate($request, [
			'username'   => 'required',
			'password'  => 'required'
		]);

		$result = DB::select("select id,username,password from users where username='".$request->username."'");

		if(count($result) == 1){
			if(Hash::check($request->password,$result[0]->password)){

				$request->session()->flush();
                $request->session()->put('user_id',$result[0]->id);

				return redirect('/distance_calc?distance=800&smoothroad=400&badroad=200&workinprogress=200&break=');
			}else{
				return back()->with('error', 'Wrong Password');
			}
		}else{
			return back()->with('error', 'Wrong Login Details');
		}

    }

    public function logout(){
        session()->flush();
        return redirect('/');
    }

    public function create_password($password){
    	echo Hash::make($password);
    }

}
