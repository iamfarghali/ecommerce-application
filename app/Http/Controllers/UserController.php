<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Country;
use Auth;
use Hash;

class UserController extends Controller
{
    public function loginRegister() {
    	return view('users.login_register');
    }
    
    public function register() {
        $data = request()->except('_token');
        $countUser = User::where('email', $data['email'])->count();
        if ($countUser > 0) {
            return redirect()->back()->withErrorMessage("Email is already exist.");
        } else {

            $user = new User;
            $user->name = $data['name'];
            $user->password = bcrypt($data['password']);
            $user->email = $data['email'];
            $user->save();

            // dd($data);
            
            $attemptData = [
                'email' => $data['email'],
                'password' => $data['password']
            ];

            $attempt = Auth::attempt($attemptData);

            if ($attempt) {
                session()->put('userSession', $data['email']);
                return redirect('/cart')->withSuccessMessage("Welcome!");
            } else {
                return redirect()->back()->withErrorMessage("Something is wrong!");
            }    
        }
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

    public function login() {
        if ( request()->isMethod('post') ) {
            $data = request()->all();
            $attemptData = [
                'email' => $data['email'],
                'password' => $data['password']
            ];

            $attempt = Auth::attempt($attemptData);

            if ($attempt) {
                if (! empty(session()->get('userSession')) ) {
                    session()->forget('userSession');
                }
                session()->put('userSession', $data['email']);
                return redirect('/cart');
            } else {
                return redirect()->back()->withErrorMessage("Invalid Email or password.");
            }  
        } else {
            return redirect()->back();
        }
    }

    public function account() {
        if ( request()->isMethod('post') ) {
            $data = request()->all();
            $user = User::find($data['user_id']);
            $user->name     = $data['name'];
            $user->address  = $data['address'];
            $user->city     = $data['city'];
            $user->state    = $data['state'];
            $user->country  = $data['country'];
            $user->pincode  = $data['pincode'];
            $user->mobile   = $data['mobile'];
            $user->save();
            return redirect()->back()->withSuccessMessage('Your information is updated successfully.');
        }

        $userDetails = auth()->user();
        $countries = Country::get();
        return view('users.account', compact('countries', 'userDetails'));
    }

    public function checkPassword() {
        $sentPassword = request()->currentPassword;
        $user = auth()->user();
        if (Hash::check($sentPassword, $user->password)) {
            echo 'true';
            return;
        } else {
            echo 'false';
            return;
        }
    }

    public function updatePassword() {
        $data = request()->all();
        $user = auth()->user();

        if ($data['newPassword'] == $data['confirmPassword'] && Hash::check($data['newPassword'], $user->password) ) {
            $user->password = bcrypt($data['newPassword']);
            $user->save();
            return redirect()->back()->withSuccessMessage('Password is updated successfully.');    
        } else {
            return redirect()->back()->withErrorMessage('Password Incorrect Or make sure the confirm password is the same new password.');
        }
    }

    public function logout() {
        session()->forget('userSession');
        Auth::logout();
        return redirect('/');
    }
}
