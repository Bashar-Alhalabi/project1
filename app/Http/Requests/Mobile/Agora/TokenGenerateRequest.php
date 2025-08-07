<?php

namespace App\Http\Requests\Mobile\Agora;

use Illuminate\Foundation\Http\FormRequest;

class TokenGenerateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'channel' => 'required|string|max:191|min:1',
            'uid' => 'required|integer|min:1|max:240',
        ];
    }

    public function messages(): array
    {
        return [
            'channel.required' => __('mobile/agora.channel_required'),
            'channel.string'   => __('mobile/agora.channel_string'),
            'channel.max'      => __('mobile/agora.channel_max'),
            'channel.min'      => __('mobile/agora.channel_min'),

            'uid.required' => __('mobile/agora.uid_required'),
            'uid.integer'   => __('mobile/agora.uid_integer'),
            'uid.max'      => __('mobile/agora.uid_max'),
            'uid.min'      => __('mobile/agora.uid_min'),
        ];
    }
}
