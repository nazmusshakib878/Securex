<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class AuthController extends Controller
{
    public function viewSignup () {
        return view('pages.signup');
    }

    public function signup(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $data['password'] = bcrypt($data['password']);
        User::create($data);

        Alert::success('Success', 'Signup successful. Please login.');
        return redirect()->route('login');
    }

    public function loginCheck(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if(Auth::attempt($credentials, $request->boolean('remember'))){
            $request->session()->regenerate();

            if(Auth::user()->isAdmin == 0){
                Alert::success('Success', 'User Login Successfull');

                return redirect()->route('home');
            }else{
                Alert::success('Success', 'Admin Login Successfull');
                return redirect()->route('viewAdminPanel');
            }
        }else{
            Alert::error('Error', 'Invalid Credentials!');
            return redirect()->back()->withInput($request->only('email', 'remember'));
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('Success', 'Logout Successfull');

        return redirect()->route('login');
    }
}
