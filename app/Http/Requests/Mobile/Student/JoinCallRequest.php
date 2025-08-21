<?php

namespace App\Http\Requests\Mobile\Student;

use Illuminate\Foundation\Http\FormRequest;

class JoinCallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'call_id' => ['required', 'integer', 'exists:calls,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'call_id.required' => __('mobile/call.validation.call_id_required'),
            'call_id.integer' => __('mobile/call.validation.call_id_integer'),
            'call_id.exists' => __('mobile/call.validation.call_exists'),
        ];
    }
}
