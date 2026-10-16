<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'whatsapp' => ['required', 'string', 'regex:/^\+?[0-9\s\-]{9,20}$/'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'terms' => ['accepted'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'whatsapp.regex' => 'Please enter a valid WhatsApp number, e.g. +62 812 3456 7890.',
            'terms.accepted' => 'You must agree to the Terms & Conditions and Privacy Policy.',
        ];
    }

    /**
     * Normalise the WhatsApp number to digits with a leading "+".
     */
    public function normalizedWhatsapp(): string
    {
        $digits = preg_replace('/\D/', '', $this->input('whatsapp'));

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        return '+'.$digits;
    }
}
