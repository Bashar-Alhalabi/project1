<?php

namespace App\Http\Requests\Mobile\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuizRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'classroom_id' => ['required', 'integer', 'exists:classrooms,id'],
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.question' => ['required', 'string', 'min:5', 'max:255'],
            'questions.*.mark' => ['required', 'numeric', 'min:0'],
            'questions.*.answers' => ['required', 'array', 'min:2'],
            'questions.*.answers.*.answer' => ['required', 'string', 'min:1', 'max:120'],
            'questions.*.answers.*.is_correct' => ['required', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            // name
            'name.required' => __('mobile/quiz.validation.name_required'),
            'name.string' => __('mobile/quiz.validation.name_string'),
            'name.min' => __('mobile/quiz.validation.name_min'),
            'name.max' => __('mobile/quiz.validation.name_max'),

            // subject
            'subject_id.required' => __('mobile/quiz.validation.subject_required'),
            'subject_id.integer' => __('mobile/quiz.validation.subject_integer'),
            'subject_id.exists' => __('mobile/quiz.validation.subject_exists'),

            // classroom
            'classroom_id.required' => __('mobile/quiz.validation.classroom_required'),
            'classroom_id.integer' => __('mobile/quiz.validation.classroom_integer'),
            'classroom_id.exists' => __('mobile/quiz.validation.classroom_exists'),

            // section
            'section_id.required' => __('mobile/quiz.validation.section_required'),
            'section_id.integer' => __('mobile/quiz.validation.section_integer'),
            'section_id.exists' => __('mobile/quiz.validation.section_exists'),

            // start & end times
            'start_time.required' => __('mobile/quiz.validation.start_required'),
            'start_time.date' => __('mobile/quiz.validation.start_date'),

            'end_time.required' => __('mobile/quiz.validation.end_required'),
            'end_time.date' => __('mobile/quiz.validation.end_date'),
            'end_time.after' => __('mobile/quiz.validation.end_after_start'),

            // questions container
            'questions.required' => __('mobile/quiz.validation.questions_required'),
            'questions.array' => __('mobile/quiz.validation.questions_array'),
            'questions.min' => __('mobile/quiz.validation.questions_min'),

            // each question text
            'questions.*.question.required' => __('mobile/quiz.validation.question_required'),
            'questions.*.question.string' => __('mobile/quiz.validation.question_string'),
            'questions.*.question.min' => __('mobile/quiz.validation.question_min'),
            'questions.*.question.max' => __('mobile/quiz.validation.question_max'),

            // each question mark
            'questions.*.mark.required' => __('mobile/quiz.validation.question_mark_required'),
            'questions.*.mark.numeric' => __('mobile/quiz.validation.question_mark_numeric'),
            'questions.*.mark.min' => __('mobile/quiz.validation.question_mark_min'),

            // answers container for each question
            'questions.*.answers.required' => __('mobile/quiz.validation.answers_required'),
            'questions.*.answers.array' => __('mobile/quiz.validation.answers_array'),
            'questions.*.answers.min' => __('mobile/quiz.validation.min_answers'),

            // each answer text
            'questions.*.answers.*.answer.required' => __('mobile/quiz.validation.answer_required'),
            'questions.*.answers.*.answer.string' => __('mobile/quiz.validation.answer_string'),
            'questions.*.answers.*.answer.min' => __('mobile/quiz.validation.answer_min'),
            'questions.*.answers.*.answer.max' => __('mobile/quiz.validation.answer_max'),

            // each answer correctness flag
            'questions.*.answers.*.is_correct.required' => __('mobile/quiz.validation.is_correct_required'),
            'questions.*.answers.*.is_correct.boolean' => __('mobile/quiz.validation.is_correct_boolean'),
        ];
    }
}
