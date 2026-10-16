@extends('layouts.auth')

@section('title', 'Login')
@section('heading', 'Welcome back')
@section('subheading', 'Continue your journey with us')

@section('content')
    @if (session('status'))
        <div class="auth-alert auth-alert--success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST" novalidate>
        @csrf

        <div class="field">
            <label class="field-label" for="email">Email Address <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="mail" /></span>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" autocomplete="email" required autofocus @class(['is-invalid' => $errors->has('email')])>
            </div>
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label class="field-label" for="password">Password <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="lock" /></span>
                <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required @class(['has-eye', 'is-invalid' => $errors->has('password')])>
                <button type="button" class="input-eye" onclick="toggleEye('password', this)" aria-label="Tampilkan password">
                    <x-icon name="eye-off" /><x-icon name="eye-on" />
                </button>
            </div>
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="check-row">
            <input type="checkbox" id="remember" name="remember" @checked(old('remember'))>
            <label for="remember">Remember me</label>
        </div>

        <button type="submit" class="btn-auth">Login</button>

        <p class="auth-footer-link">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
    </form>

    <div class="auth-divider"><span>or</span></div>

    <a href="{{ route('auth.google') }}" class="btn-google">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M17.64 9.205c0-.639-.057-1.252-.164-1.841H9v3.481h4.844a4.14 4.14 0 0 1-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.615z" fill="#4285F4"/>
            <path d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z" fill="#34A853"/>
            <path d="M3.964 10.71A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.71V4.958H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
            <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.958L3.964 7.29C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
        </svg>
        Continue with Google
    </a>
@endsection
