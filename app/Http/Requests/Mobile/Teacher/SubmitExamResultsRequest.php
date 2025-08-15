<?php

namespace App\Http\Requests\Mobile\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class SubmitExamResultsRequest extends FormRequest
{
    public function authorize(): bool
    {
        // controller performs auth/teacher checks
        return true;
    }

    public function rules(): array
    {
        return [
            'results' => ['required', 'array', 'min:1'],
            'results.*.student_id' => ['required', 'integer', 'distinct', 'exists:students,id'],
            'results.*.result' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'results.required' => __('mobile/exam.validation.results_required'),
            'results.array' => __('mobile/exam.validation.results_array'),
            'results.min' => __('mobile/exam.validation.results_min'),

            'results.*.student_id.required' => __('mobile/exam.validation.student_id_required'),
            'results.*.student_id.integer' => __('mobile/exam.validation.student_id_integer'),
            'results.*.student_id.distinct' => __('mobile/exam.validation.student_id_distinct'),
            'results.*.student_id.exists' => __('mobile/exam.validation.student_id_exists'),

            'results.*.result.required' => __('mobile/exam.validation.result_required'),
            'results.*.result.numeric' => __('mobile/exam.validation.result_numeric'),
            'results.*.result.min' => __('mobile/exam.validation.result_min'),
        ];
    }
}
