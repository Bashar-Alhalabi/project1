<?php

return [
    'joined' => 'You joined the call successfully.',
    'validation' => [
        'call_id_required' => 'call_id is required.',
        'call_id_integer' => 'call_id must be an integer.',
        'call_exists' => 'The requested call does not exist.',
    ],
    'errors' => [
        'not_student' => 'Authenticated user is not a student.',
        'no_section' => 'Student is not assigned to any section.',
        'fetch_failed' => 'Failed to fetch scheduled calls. Please try again.',
        'call_not_active' => 'This call is not active (either not started or already ended).',
        'cannot_rejoin_after_left' => 'You cannot re-enter the call after you have left it.',
        'already_in_call' => 'You are already in the call.',
        'not_in_section' => 'You are not in the section allowed to join this call.',
        'join_failed' => 'Failed to join the call. Please try again.',
    ],
];