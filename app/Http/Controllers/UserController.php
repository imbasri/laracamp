<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
        $callback = Socialite::driver('google')->user();
        $data = [
            'name' => $callback->getName(),
            'email' => $callback->getEmail(),
            'avatar' => $callback->getAvatar(),
            'email_verified_at' => now(),
        ];

        $user = User::updateOrCreate(
            ['email' => $callback->getEmail()],
            $data
        );
        Auth::login($user, true);
        return redirect()->route('welcome');

    }
}
