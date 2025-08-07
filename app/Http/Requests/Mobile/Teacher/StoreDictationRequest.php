<?php

namespace App\Http\Requests\Mobile\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreDictationRequest extends FormRequest
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
            'student_id' => ['required','exists:students,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'result'     => ['required','numeric','min:0','max:10'],
        ];
    }
    public function messages(): array
    {
        return [
            'student_id.required' => __('mobile.dictation.validation.student_required'),
            'student_id.exists'   => __('mobile.dictation.validation.student_exists'),
            'subject_id.required' => __('mobile.dictation.validation.subject_required'),
            'subject_id.exists'   => __('mobile.dictation.validation.subject_exists'),
            'result.required'     => __('mobile.dictation.validation.result_required'),
            'result.numeric'      => __('mobile.dictation.validation.result_numeric'),
            'result.min'          => __('mobile.dictation.validation.result_min'),
            'result.max'          => __('mobile.dictation.validation.result_max'),
        ];
    }
}
