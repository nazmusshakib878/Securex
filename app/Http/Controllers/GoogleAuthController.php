<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;

class GoogleAuthController extends Controller
{
   
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

           
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
               
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    
                    'password' => Hash::make(uniqid())
                ]);
            }

       
            Auth::login($user);

            
            return redirect('/dashboard'); 

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Google Login Failed. Please try again.');
        }
    }
}