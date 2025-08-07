<?php

namespace App\Http\Requests\Mobile\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role_id === 2;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'type'       => 'required|string|in:positive,negative',
            'reason'     => 'required|string|min:4|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => __('mobile/notes.student_required'),
            'student_id.exists'   => __('mobile/notes.student_exists'),
            'type.required'       => __('mobile/notes.type_required'),
            'type.string'         => __('mobile/notes.type_string'),
            'type.in'            => __('mobile/notes.type_in'),
            'reason.required'     => __('mobile/notes.reason_required'),
            'reason.string'       => __('mobile/notes.reason_string'),
            'reason.max'          => __('mobile/notes.reason_max'),
            'reason.min'          => __('mobile/notes.reason_min'),
        ];
    }
}
