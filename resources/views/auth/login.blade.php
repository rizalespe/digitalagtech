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
@endsection
