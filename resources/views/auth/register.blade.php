@extends('layouts.auth')

@section('title', 'Register')
@section('heading', 'Create Your Account')
@section('subheading', 'Learn, connect, and discover new opportunities.')

@section('content')
    <form action="{{ route('register') }}" method="POST" novalidate>
        @csrf

        <div class="field">
            <label class="field-label" for="name">Full Name <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="person" /></span>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Amara Mensah" autocomplete="name" required autofocus @class(['is-invalid' => $errors->has('name')])>
            </div>
            @error('name') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label class="field-label" for="email">Email Address <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="mail" /></span>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" autocomplete="email" required @class(['is-invalid' => $errors->has('email')])>
            </div>
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label class="field-label" for="whatsapp">WhatsApp Number <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="phone" /></span>
                <input type="tel" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="+62 812 3456 7890" autocomplete="tel" required @class(['is-invalid' => $errors->has('whatsapp')])>
            </div>
            @error('whatsapp') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label class="field-label" for="password">Password <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="lock" /></span>
                <input type="password" id="password" name="password" placeholder="Minimum 8 characters" autocomplete="new-password" required @class(['has-eye', 'is-invalid' => $errors->has('password')])>
                <button type="button" class="input-eye" onclick="toggleEye('password', this)" aria-label="Tampilkan password">
                    <x-icon name="eye-off" /><x-icon name="eye-on" />
                </button>
            </div>
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label class="field-label" for="password_confirmation">Confirm Password <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="lock" /></span>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" autocomplete="new-password" required class="has-eye">
                <button type="button" class="input-eye" onclick="toggleEye('password_confirmation', this)" aria-label="Tampilkan konfirmasi password">
                    <x-icon name="eye-off" /><x-icon name="eye-on" />
                </button>
            </div>
        </div>

        <div class="check-row">
            <input type="checkbox" id="terms" name="terms" value="1" required @checked(old('terms'))>
            <label for="terms">I agree to the <a href="#">Terms &amp; Conditions</a> and <a href="#">Privacy Policy</a></label>
        </div>
        @error('terms') <p class="field-error" style="margin-top:-14px;margin-bottom:16px">{{ $message }}</p> @enderror

        <button type="submit" class="btn-auth">Create Account</button>

        <p class="auth-footer-link">Already have an account? <a href="{{ route('login') }}">Log In</a></p>
    </form>
@endsection
