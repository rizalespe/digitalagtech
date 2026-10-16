<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Google login failed. Please try again.']);
        }

        $user = User::firstOrCreate(
            ['google_id' => $googleUser->getId()],
            [
                'name'     => $googleUser->getName(),
                'email'    => $googleUser->getEmail(),
                'password' => null,
            ]
        );

        // Sync name/email if the user already existed via email registration.
        if (! $user->wasRecentlyCreated && ! $user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('home'));
    }
}
