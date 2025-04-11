<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\User\AfterRegister;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.user.login');
    }

    public function google()
    {
        /* The line `return Socialite::driver('google')->redirect();` is using Laravel Socialite to
        initiate a redirect to Google for authentication. This code is telling Laravel to use the
        Socialite package to create a redirect URL for Google authentication. When this method is
        called, it will redirect the user to Google's authentication page where they can log in and
        authorize the application to access their Google account information. */
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $callback = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('google.login')->with('error', 'Failed to authenticate with Google.');
        }
        $data = [
            'name' => $callback->getName(),
            'email' => $callback->getEmail(),
            'avatar' => $callback->getAvatar(),
            'email_verified_at' => now(),
        ];
        // check if user already registered
        $user = User::whereEmail($data['email'])->first();
            try {
                Mail::to($user->email)->send(new AfterRegister($user));
            } catch (\Exception $e) {
                // Log the error or handle it as needed
                Log::error('Failed to send email: ' . $e->getMessage());
            }
        if (!$user) {
            $user = User::create($data);
            // send email after register
            Mail::to($user->email)->send(new AfterRegister($user));
        }

        Auth::login($user, true);
        return redirect()->route('welcome');
    }
}
