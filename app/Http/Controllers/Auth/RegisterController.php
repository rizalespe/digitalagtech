<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'whatsapp' => $request->normalizedWhatsapp(),
            'password' => $request->validated('password'),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended(route('home'))
            ->with('status', 'Welcome aboard, '.$user->name.'!');
    }
}
