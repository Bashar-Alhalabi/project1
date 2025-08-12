<?php

namespace App\Http\Requests\Mobile\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;
use App\Models\SectionSubject;

class CreateCallRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Route middleware IsTeacher should guard this, but keep true here.
        return true;
    }

    public function rules(): array
    {
        return [
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'started_at' => ['required', 'date'],
        ];
    }

    /**
     * Additional validation that requires DB lookups or the authenticated user.
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if ($validator->fails()) {
                return;
            }
            $user = Auth::user();
            $teacher = $user ? $user->teacher : null;
            if (!$teacher) {
                $validator->errors()->add('teacher', __('mobile.call.errors.not_teacher'));
                return;
            }
            $sectionId = $this->input('section_id');
            $assigned = SectionSubject::where('section_id', $sectionId)
                ->where('teacher_id', $teacher->id)
                ->exists();
            if (!$assigned) {
                $validator->errors()->add('section_id', __('mobile.call.errors.section_not_assigned'));
            }
            try {
                $started = Carbon::parse($this->input('started_at'));
            } catch (\Throwable $e) {
                $validator->errors()->add('started_at', __('mobile.call.validation.started_date'));
                return;
            }
            if ($started->lt(now())) {
                $validator->errors()->add('started_at', __('mobile.call.validation.started_in_past'));
            }
        });
    }

    /**
     * Localized messages for standard rules only.
     */
    public function messages(): array
    {
        return [
            'section_id.required' => __('mobile.call.validation.section_required'),
            'section_id.integer' => __('mobile.call.validation.section_integer'),
            'section_id.exists' => __('mobile.call.validation.section_exists'),
            'started_at.required' => __('mobile.call.validation.started_required'),
            'started_at.date' => __('mobile.call.validation.started_date'),
        ];
    }
}