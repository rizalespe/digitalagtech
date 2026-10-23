@extends('layouts.auth')

@section('title', 'Register')
@section('heading', __('Create Your Account'))
@section('subheading', __('Learn, connect, and discover new opportunities.'))

@section('content')
    <form action="{{ route('register') }}" method="POST" novalidate>
        @csrf

        <div class="field">
            <label class="field-label" for="name">{{ __('Full Name') }} <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="person" /></span>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Amara Mensah" autocomplete="name" required autofocus @class(['is-invalid' => $errors->has('name')])>
            </div>
            @error('name') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label class="field-label" for="email">{{ __('Email Address') }} <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="mail" /></span>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" autocomplete="email" required @class(['is-invalid' => $errors->has('email')])>
            </div>
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label class="field-label" for="whatsapp">{{ __('WhatsApp Number') }} <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="phone" /></span>
                <input type="tel" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="+62 812 3456 7890" autocomplete="tel" required @class(['is-invalid' => $errors->has('whatsapp')])>
            </div>
            @error('whatsapp') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label class="field-label" for="password">{{ __('Password') }} <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="lock" /></span>
                <input type="password" id="password" name="password" placeholder="{{ __('Minimum 8 characters') }}" autocomplete="new-password" required @class(['has-eye', 'is-invalid' => $errors->has('password')])>
                <button type="button" class="input-eye" onclick="toggleEye('password', this)" aria-label="Tampilkan password">
                    <x-icon name="eye-off" /><x-icon name="eye-on" />
                </button>
            </div>
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label class="field-label" for="password_confirmation">{{ __('Confirm Password') }} <span class="req">*</span></label>
            <div class="input-wrap">
                <span class="input-icon"><x-icon name="lock" /></span>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Re-enter your password') }}" autocomplete="new-password" required class="has-eye">
                <button type="button" class="input-eye" onclick="toggleEye('password_confirmation', this)" aria-label="Tampilkan konfirmasi password">
                    <x-icon name="eye-off" /><x-icon name="eye-on" />
                </button>
            </div>
        </div>

        <div class="check-row">
            <input type="checkbox" id="terms" name="terms" value="1" required @checked(old('terms'))>
            <label for="terms">{!! __('I agree to the :terms and :privacy', ['terms' => '<a href="#">'.__('Terms & Conditions').'</a>', 'privacy' => '<a href="#">'.__('Privacy Policy').'</a>']) !!}</label>
        </div>
        @error('terms') <p class="field-error" style="margin-top:-14px;margin-bottom:16px">{{ $message }}</p> @enderror

        <button type="submit" class="btn-auth">{{ __('Create Account') }}</button>

        <p class="auth-footer-link">{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Log In') }}</a></p>
    </form>

    <div class="auth-divider"><span>{{ __('or') }}</span></div>

    <a href="{{ route('auth.google') }}" class="btn-google">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M17.64 9.205c0-.639-.057-1.252-.164-1.841H9v3.481h4.844a4.14 4.14 0 0 1-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.615z" fill="#4285F4"/>
            <path d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z" fill="#34A853"/>
            <path d="M3.964 10.71A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.71V4.958H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
            <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.958L3.964 7.29C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
        </svg>
        {{ __('Register with Google') }}
    </a>
@endsection
