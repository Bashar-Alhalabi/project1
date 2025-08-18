<?php

return [
    // top-level validation summary used when returning the collected errors
    'validation_failed' => 'Validation failed. Please correct the errors and try again.',

    // detailed validation messages
    'validation' => [
        // max_result (not accepted from teacher in controller but keep message)
        'max_result_numeric' => 'Max result must be a number.',
        'max_result_min' => 'Max result must be at least :min.',

        // results container
        'results_required' => 'Results are required.',
        'results_array' => 'Results must be an array of student results.',
        'results_min' => 'You must provide at least :min result(s).',

        // student id messages
        'student_id_required' => 'Student id is required for each result.',
        'student_id_integer' => 'Student id must be an integer.',
        'student_id_distinct' => 'Student ids must be unique (no duplicates).',
        'student_id_exists' => 'Selected student does not exist.',

        // result value messages
        'result_required' => 'Result value is required for each student.',
        'result_numeric' => 'Result must be a numeric value.',
        'result_min' => 'Result must be at least :min.',
        'result_max' => 'Result must not exceed :max.',
    ],

    // business logic errors
    'errors' => [
        'not_teacher' => 'Authenticated user is not a teacher.',
        'invalid_exam' => 'Invalid exam.',
        'exam_not_open' => 'This exam is not open for entering results.',
        'teacher_not_assigned' => 'You are not assigned to teach this subject for the exam section.',
        'max_result_not_set' => 'This exam does not have a maximum result set by the supervisor.',
        'student_not_in_section' => 'The specified student does not belong to the exam\'s section.',
    ],

    // success / store messages
    'store' => [
        'success' => 'Exam results saved successfully.',
        'error' => 'Failed to save exam results. Please try again.',
    ],
];