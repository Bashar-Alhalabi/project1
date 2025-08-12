<?php

return [
    'created' => 'Quiz created successfully.',
    'validation' => [
        // name
        'name_required' => 'Quiz name is required.',
        'name_string' => 'Quiz name must be a string.',
        'name_min' => 'Quiz name must be at least :min characters.',
        'name_max' => 'Quiz name must not exceed :max characters.',

        // subject
        'subject_required' => 'Subject is required.',
        'subject_integer' => 'Subject id must be an integer.',
        'subject_exists' => 'Selected subject does not exist.',

        // classroom
        'classroom_required' => 'Classroom is required.',
        'classroom_integer' => 'Classroom id must be an integer.',
        'classroom_exists' => 'Selected classroom does not exist.',

        // section
        'section_required' => 'Section is required.',
        'section_integer' => 'Section id must be an integer.',
        'section_exists' => 'Selected section does not exist.',

        // start & end times
        'start_required' => 'Start time is required.',
        'start_date' => 'Start time must be a valid date/time.',
        'end_required' => 'End time is required.',
        'end_date' => 'End time must be a valid date/time.',
        'end_after_start' => 'End time must be after start time.',

        // questions container
        'questions_required' => 'You must provide at least one question.',
        'questions_array' => 'Questions must be an array.',
        'questions_min' => 'You must provide at least :min question(s).',

        // question text
        'question_required' => 'Question text is required.',
        'question_string' => 'Question text must be a string.',

        // question mark
        'question_mark_required' => 'Question mark is required.',
        'question_mark_numeric' => 'Question mark must be a number.',
        'question_mark_min' => 'Question mark must be at least :min.',

        // answers container
        'answers_required' => 'Answers for the question are required.',
        'answers_array' => 'Answers must be an array.',
        'min_answers' => 'Each question must have at least :min answers.',

        // answer text
        'answer_required' => 'Answer text is required.',
        'answer_string' => 'Answer text must be a string.',

        // is_correct flag
        'is_correct_required' => 'Each answer must include the is_correct flag (true/false).',
        'is_correct_boolean' => 'The is_correct flag must be boolean (true or false).',
    ],

    'errors' => [
        'not_teacher' => 'Authenticated user is not a teacher.',
        'teacher_not_assigned' => 'You are not assigned to teach this subject for the given section.',
        'min_answers_per_question' => 'Each question must have at least two answers.',
        'answer_correct_flag' => 'Each answer must include the is_correct boolean flag.',
        'one_correct_answer' => 'Each question must have exactly one correct answer.',
        'total_mark_exceeded' => 'Total mark of the quiz must not exceed 20.',
        'save_failed' => 'Failed to save the quiz. Please try again.',
    ],
];