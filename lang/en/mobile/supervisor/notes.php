<?php

return [
    'created' => 'Note created successfully.',

    'validation_failed' => 'Validation failed. Please correct the errors and try again.',

    'validation' => [
        'student_required' => 'Student is required.',
        'student_integer' => 'Student id must be an integer.',
        'student_exists' => 'Selected student does not exist.',

        'type_required' => 'Note type is required.',
        'type_in' => 'Note type must be either positive or negative.',

        'reason_required' => 'Reason is required.',
        'reason_string' => 'Reason must be a string.',
        'reason_min' => 'Reason must be at least :min characters.',
        'reason_max' => 'Reason must not exceed :max characters.',

        'value_numeric' => 'Value must be numeric.',
        'value_min' => 'Value must be at least :min.',

        'course_integer' => 'Course id must be an integer.',
        'course_exists' => 'Selected course does not exist.',

        'status_in' => 'Invalid status value.',
    ],

    'errors' => [
        'not_supervisor' => 'Authenticated user is not a supervisor.',
        'student_not_in_stage' => 'The specified student is not in your assigned stage.',
        'save_failed' => 'Failed to save the note. Please try again.',
    ],
];