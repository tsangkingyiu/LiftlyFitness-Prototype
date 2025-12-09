<?php

namespace Modules\Frontend\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        // return Socialite::driver('google')->redirect();
        // return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();

        if (empty(env('GOOGLE_CLIENT_ID')) || empty(env('GOOGLE_CLIENT_SECRET')) || empty(env('GOOGLE_REDIRECT_URL'))) {
            return redirect()->back()->withErrors(__('frontend::message.google_configuration'));
        } else {
            return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();
        }
    }


    public function handleGoogleCallback(Request $request)
    {
       
        try {
            // $googleUser = Socialite::driver('google')->user();
            $googleUser = Socialite::driver('google')->stateless()->user();

            $fullName = explode(' ', $googleUser->getName(), 2);
            $firstName = $fullName[0]; 
            $lastName = isset($fullName[1]) ? $fullName[1] : '';
        
            $existingUser = User::where('email', $googleUser->getEmail())->first();
        
            if (!$existingUser) {
                $username = stristr($googleUser->getEmail(), '@', true) . rand(100, 1000);
        
                $newUser = User::create([
                    'google_id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'username' => $username,
                    'first_name' => $firstName,
                    'last_name' => $lastName,    
                    'display_name' => $firstName . " " . $lastName,
                    'status' => 'active',
                    'password' => Hash::make($googleUser->getName() . '@' . $googleUser->getId()),
                    'login_type' => 'gmail'
                ]);
                $avatarUrl = $googleUser->getAvatar();
                if ($avatarUrl) {
                    $newUser->addMediaFromUrl($avatarUrl)->toMediaCollection('profile_image');
                }
                $newUser->assignRole('user');
        
                Auth::loginUsingId($newUser->id);
            } else {
                Auth::loginUsingId($existingUser->id);
            }

            $language_code = getUserPreference('language_code') ?? app()->getLocale();
            App::setLocale($language_code);
            session()->put('locale', $language_code);

            return redirect()->route('user.dashboard')->withSuccess(__('frontend::message.login_success'));
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}