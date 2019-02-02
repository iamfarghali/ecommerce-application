<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Country;
use Auth;
use Hash;
use Mail;
use DB;

class UserController extends Controller
{
    public function loginRegister() {
        if (auth()->user() == null) {
        	return view('users.login_register');
        } else {
            return redirect('/');
        }
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

            // send register email
            // $email = $data['email'];
            // $messageData = ['email' => $email, 'name' => $data['name']];
            // Mail::send('emails.register', $messageData, function($message) use($email) {
            //     $message->to($email)->subject('Registration with E-Commerce Website');
            // });
            
            // send confirmation email
            $email = $data['email'];
            $messageData = ['email' => $email, 'name' => $data['name'], 'code' => base64_encode($email)];
            Mail::send('emails.confirm', $messageData, function($message) use($email) {
                $message->to($email)->subject('Confirm Your Account Plz.');
            });
            return redirect()->back()->withSuccessMessage("Please confirm your email to active your account.");  
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
            $attemptAdminData = [
                'email' => $data['email'],
                'password' => $data['password'],
                'admin' => '1',
            ];
            $attemptUserData = [
                'email' => $data['email'],
                'password' => $data['password']
            ];

            if (Auth::attempt($attemptAdminData)) 
            {
                session()->put('adminSession', $data['email']);
                session()->put('userSession', $data['email']);
                
                if (! empty(session()->get('session_id')) ) {
                    $session_id = session()->get('session_id');
                    DB::table('cart')->where('session_id', $session_id)->update(['user_email' => $data['email']]);
                }
                return redirect('/cart');
            } 
            elseif (Auth::attempt($attemptUserData)) 
            {
                $status = auth()->user()->status;
                if ($status < 1) {
                    Auth::logout();
                    return redirect()->back()->withErrorMessage("Your Account Not Active, Check Your E-Mail please.");
                }
                session()->put('userSession', $data['email']);
                if (! empty(session()->get('session_id')) ) {
                    $session_id = session()->get('session_id');
                    DB::table('cart')->where('session_id', $session_id)->update(['user_email' => $data['email']]);
                }
                return redirect('/cart');
            }
            else 
            {
                return redirect()->back()->withErrorMessage("Invalid Email or password.");
            }  
        } 
        else 
        {
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
    public function confirmUserAccount($code) {
        if (! empty($code)) {
            $email = base64_decode($code);
            if (User::where('email', $email)->count() > 0) {
                $user = User::where('email', $email)->first();
                if ($user->status == 1) {
                    return redirect('/login-register')->withSuccessMessage('You can login now.');
                } else {
                    User::where('email', $email)->update(['status' => '1']);
                    // send register email
                    $email = $user->email;
                    $messageData = ['email' => $email, 'name' => $user->name];
                    Mail::send('emails.welcome', $messageData, function($message) use($email) {
                        $message->to($email)->subject('Welcome to E-Commerce Website');
                    });
                    return redirect('/login-register')->withSuccessMessage('You can login now.');
                }
            } else {
                return redirect('/login-register')->withErrorMessage('Your Email not found, register please.');    
            }
        }
    }
    public function logout() {
        session()->flush();
        Auth::logout();
        return redirect('/');
    }
}
