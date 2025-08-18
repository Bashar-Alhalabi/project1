<?php

return [
    'store' => [
        'success' => 'Dictation result saved successfully.',
        'error' => 'Failed to save dictation result. Please try again.',
    ],

    'validation' => [
        'student_required' => 'Student ID is required.',
        'student_exists' => 'Selected student does not exist or is not in your section.',
        'subject_required' => 'Subject ID is required.',
        'subject_exists' => 'Selected subject does not exist.',
        'result_required' => 'Result value is required.',
        'result_numeric' => 'Result must be a number.',
        'result_min' => 'Result must be at least :min.',
        'result_max' => 'Result must be at least :max.',
    ],
];