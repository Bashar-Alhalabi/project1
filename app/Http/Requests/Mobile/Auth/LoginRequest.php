<?php

namespace App\Http\Requests\Mobile\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'string', 'min:5', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:64'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('mobile/auth/auth.email_required'),
            'email.email' => __('mobile/auth/auth.email_invalid'),
            'email.min' => __('mobile/auth/auth.email_min'),
            'email.max' => __('mobile/auth/auth.email_max'),
            'password.required' => __('mobile/auth/auth.password_required'),
            'password.min' => __('mobile/auth/auth.password_min'),
            'password.max' => __('mobile/auth/auth.password_max'),
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $firstError = $validator->errors()->first();

        throw new HttpResponseException(
            response()->json([
                'message' => $firstError,
            ], 422)
        );
    }
}
