<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
		if ($request->isMethod('post'))
		{
			$data = $request->input();
			if (Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'admin'=>'1']))
			{
                session()->put('adminSession', $data['email']);
				session()->put('userSession', $data['email']);
				return redirect('/admin/dashboard');
			}
			else
			{
				return redirect('/admin')->withErrorMessage('Invalid Email Or Password!');
			}
    	} else {
            if (session()->has('adminSession')) {
                return redirect('/admin/dashboard');
            } else {
            	return view('admin.admin_login');
            }
        }
    }

    public function dashboard()
    {
    	if (session()->has('adminSession'))
    	{
	        return view('admin.dashboard');
    	}
    	else
    	{
    		return redirect('/admin')->withErrorMessage('Please Login!');
    	}
    }

    public function setting()
    {
	    return view('admin.setting');
    }

    public function logout()
    {
    	session()->flush();
    	return redirect('/admin');
    }

    public function checkPassword()
    {
    	$password = request()->get('current_pwd');
    	$current_password = User::where(['id'=>'1'])->first()->password;
    	if (Hash::check($password , $current_password))
    	{
    		echo 'true'; die;
    	}
    	else
    	{
    		echo 'false'; die;
    	}
    }

    public function updatePassword()
    {
    	if (request()->isMethod('post'))
    	{
	    	$sentPassword = request()->get('current_pwd');
	    	$current_password = User::where(['id'=>'1'])->first()->password;
	    	if (Hash::check($sentPassword , $current_password))
	    	{
	    		$password = bcrypt(request()->get('new_pwd'));
	    		User::where('id', '1')->update(['password'=>$password]);
	    		return redirect('/admin/setting')->withSuccessMessage('Password Updated Successfully');
	    	}
	    	else 
	    	{
	    		return redirect('/admin/setting')->withErrorMessage('Current Password Incorrect.');
	    	}
    	}

    }
}
