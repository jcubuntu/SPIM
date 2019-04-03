<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class AuthController extends Controller
{
	public function __construct() {
		$this->middleware('guest', ['except' => 'logout']);
	}

    public function showLogin() {
    	return view('auth.login');
    }

    public function login(Request $request) {
    	$inputs = $request->all();

        $this->validate($request,[
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if(Auth::attempt(['username' => $inputs['username'], 'password' => $inputs['password']], $request->has('remember'))) {
            return redirect()->intended('/');
        }
        else {
            return redirect()->back()->with('error', 'The username or password is incorrect.')->withInput();
        }
    }

    public function logout() {
    	Auth::logout();
    	return redirect()->route('home');
    }
}
