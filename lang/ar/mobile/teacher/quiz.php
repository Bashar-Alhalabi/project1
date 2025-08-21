<?php

return [
    'created' => 'تم إنشاء الاختبار بنجاح.',
    'validation' => [
        // name
        'name_required' => 'اسم الاختبار مطلوب.',
        'name_string' => 'يجب أن يكون اسم الاختبار نصاً.',
        'name_min' => 'اسم الاختبار يجب ألا يقل عن :min أحرف.',
        'name_max' => 'اسم الاختبار يجب ألا يزيد عن :max حرف/أحرف.',

        // subject
        'subject_required' => 'المادة مطلوبة.',
        'subject_integer' => 'معرّف المادة يجب أن يكون رقماً صحيحاً.',
        'subject_exists' => 'المادة المحددة غير موجودة.',

        // classroom
        'classroom_required' => 'الصف/المجموعة مطلوبة.',
        'classroom_integer' => 'معرّف الصف/المجموعة يجب أن يكون رقماً صحيحاً.',
        'classroom_exists' => 'الصف/المجموعة المحددة غير موجودة.',

        // section
        'section_required' => 'الشعبة مطلوبة.',
        'section_integer' => 'معرّف الشعبة يجب أن يكون رقمًا صحيحًا.',
        'section_exists' => 'الشعبة المحددة غير موجودة.',

        // start & end times
        'start_required' => 'وقت البدء مطلوب.',
        'start_date' => 'وقت البدء يجب أن يكون تاريخاً/وقتاً صحيحاً.',
        'end_required' => 'وقت الانتهاء مطلوب.',
        'end_date' => 'وقت الانتهاء يجب أن يكون تاريخاً/وقتاً صحيحاً.',
        'end_after_start' => 'يجب أن يكون وقت الانتهاء بعد وقت البدء.',

        // questions container
        'questions_required' => 'يجب إضافة سؤال واحد على الأقل.',
        'questions_array' => 'حقل الأسئلة يجب أن يكون مصفوفة.',
        'questions_min' => 'يجب إضافة ما لا يقل عن :min سؤال(أسئلة).',

        // question text
        'question_required' => 'نص السؤال مطلوب.',
        'question_string' => 'نص السؤال يجب أن يكون نصاً.',
        'question_min' => 'نص السؤال يجب أن لا يقل عن :min حرفاً.',
        'question_max' => 'نص السؤال يجب أن لا يزيد على :max حرفاً.',
        // question mark
        'question_mark_required' => 'الدرجة الخاصة بالسؤال مطلوبة.',
        'question_mark_numeric' => 'درجة السؤال يجب أن تكون رقماً.',
        'question_mark_min' => 'درجة السؤال يجب ألا تقل عن :min.',

        // answers container
        'answers_required' => 'الإجابات مطلوبة لكل سؤال.',
        'answers_array' => 'حقل الإجابات يجب أن يكون مصفوفة.',
        'min_answers' => 'يجب أن يحتوي كل سؤال على ما لا يقل عن :min إجابتين.',

        // answer text
        'answer_required' => 'نص الإجابة مطلوب.',
        'answer_string' => 'نص الإجابة يجب أن يكون نصاً.',
        'answer_min' => 'نص الإجابة يجب أن لا يقل عن :min أحرف.',
        'answer_max' => 'نص الإجابة يجب أن لا يزيد على :max أحرف.',

        // is_correct flag
        'is_correct_required' => 'يجب تحديد حقل is_correct لكل إجابة (true/false).',
        'is_correct_boolean' => 'حقل is_correct يجب أن يكون قيمة منطقية (true أو false).',
    ],

    'errors' => [
        'not_teacher' => 'المستخدم الحالي ليس معلماً.',
        'teacher_not_assigned' => 'أنت غير مكلف بتدريس هذه المادة لهذه الشعبة.',
        'min_answers_per_question' => 'يجب أن يحتوي كل سؤال على إجابتين على الأقل.',
        'answer_correct_flag' => 'يجب تحديد حقل is_correct (true/false) لكل إجابة.',
        'one_correct_answer' => 'يجب أن يحتوي كل سؤال على إجابة صحيحة واحدة بالضبط.',
        'total_mark_exceeded' => 'المجموع الكلي للدرجات يجب ألا يتجاوز 20.',
        'save_failed' => 'فشل حفظ الاختبار. حاول مرة أخرى.',
    ],
];
