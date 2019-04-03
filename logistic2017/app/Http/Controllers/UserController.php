<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class UserController extends Controller
{
    private $route = 'user';
    
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:manage.account');
        view()->share('route', $this->route);
    }
    
    public function index() {
    	$itemList = User::get();
    	return view($this->route.'.index', compact('itemList'));
    }

    public function create() {
    	return view($this->route.'.create');
    }

    public function edit(User $user) {
    	return view($this->route.'.edit', compact('user'));
    }

    public function store(Request $request) {
    	$this->validate($request, [
    		'username' => 'required|string|min:6|max:255|unique:users',
    		'password' => 'required|confirmed|min:6',
    	]);

		$user           = new User;
		$user->username = $request->input('username');
		$user->password = Hash::make($request->input('password'));
    	$user->save();
    	return redirect()->route($this->route.'.index');
    }

    public function update(Request $request, User $user) {
    	$rules = [
    		'username' => 'required|string|min:6|max:255|unique:users,username,'.$user->id,
    	];

    	if($request->has('changepassword')) {
			$rules['password'] = 'required|confirmed|min:6';
			$user->password    = Hash::make($request->input('password'));
    	}
    	$this->validate($request, $rules);

		$user->username = $request->input('username');
    	$user->save();
    	return redirect()->route($this->route.'.edit', $user->id)->with('success', '<i class="fa fa-check"></i> แก้ไขข้อมูลแล้ว !');
    }

    public function destroy(User $user) {
    	$user->delete();
    	return redirect()->route($this->route.'.index');
    }
}
