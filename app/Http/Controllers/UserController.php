<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function loginRegister() {
    	if(request()->isMethod('post')) {
    		$data = request()->except('_token');
    		$user = new User;
    		$user->name = $data['name'];
    		$user->password = bcrypt($data['name']);
    		$user->email = $data['email'];
    		$user->save();
    		return redirect('/')->withSuccessMessage("Welcome , $user->name");
    	}

    	return view('users.login_register');
    }

    public function checkEmail() {
    	$email = request()->email;
    	$countUser = User::where('email', $email)->count();
    	if ($countUser > 0) {
    		echo "false";
    	} else {
    		echo "true";
    	} 
    }
}
