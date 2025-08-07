<?php

namespace App\Http\Requests\Mobile\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StartCallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'channel' => 'required|string|max:191|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'channel.required' => __('mobile/calls.channel_required'),
            'channel.string'   => __('mobile/calls.channel_string'),
            'channel.max'      => __('mobile/calls.channel_max'),
            'channel.min'      => __('mobile/calls.channel_min'),
        ];
    }
}