<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;


class AuthController extends Controller
{
    public function viewSignup () {
        return view('pages.signup');
    }

    public function redirectToGoogle()
    {
        if (!config('services.google.client_id') || !config('services.google.client_secret')) {
            Alert::error('Error', 'Google OAuth is not configured. Please set GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in .env.');
            return redirect()->back();
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Alert::error('Error', 'Google login failed. Please try again.');
            return redirect()->route('viewSignup');
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            Alert::success('Success', 'Logged in with Google successfully.');
            return $user->isAdmin ? redirect()->route('viewAdminPanel') : redirect()->route('home');
        }

        $user = User::create([
            'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
            'email' => $googleUser->getEmail(),
            'phone' => 'google_' . $googleUser->getId(),
            'password' => bcrypt(Str::random(16)),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        Alert::success('Success', 'Account created with Google successfully.');
        return redirect()->route('home');
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
                Alert::success('Success', 'User Login Successful');

                return redirect()->route('home');
            }else{
                Alert::success('Success', 'Admin Login Successful');
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

        Alert::success('Success', 'Logout Successful');

        return redirect()->route('login');
    }
}
