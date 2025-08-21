<?php

return [
    'created' => 'تم إنشاء المكالمة بنجاح.',
    'scheduled_created' => 'تم جدولة المكالمة بنجاح.',
    'started' => 'تم بدء المكالمة المجدولة.',

    'validation' => [
        'section_required' => 'الشعبة مطلوبة.',
        'section_integer' => 'معرّف الشعبة يجب أن يكون رقمًا صحيحًا.',
        'section_exists' => 'الشعبة المحددة غير موجودة.',

        'subject_required' => 'المادة مطلوبة.',
        'subject_integer' => 'معرّف المادة يجب أن يكون رقمًا صحيحًا.',
        'subject_exists' => 'المادة المحددة غير موجودة.',

        'scheduled_required' => 'وقت الجدولة مطلوب.',
        'scheduled_date' => 'وقت الجدولة يجب أن يكون تاريخ/وقت صحيح.',
        'scheduled_after_now' => 'يجب أن يكون وقت الجدولة في المستقبل.',

        'started_required' => 'وقت البدء مطلوب.',
        'started_date' => 'وقت البدء يجب أن يكون تاريخ/وقت صحيح.',
        'started_in_past' => 'لا يمكن أن يكون وقت البدء في الماضي.',

        'duration_integer' => 'المدة يجب أن تكون رقماً (بالدقائق).',
        'duration_min' => 'المدة يجب ألا تقل عن :min دقيقة.',
        'duration_max' => 'المدة يجب ألا تتجاوز :max دقيقة.',

        'channel_string' => 'اسم القناة يجب أن يكون نصاً.',
        'channel_max' => 'اسم القناة يجب ألا يزيد عن :max حرف/أحرف.',
    ],

    'errors' => [
        'not_teacher' => 'المستخدم الحالي ليس معلماً.',
        'fetch_scheduled_failed' => 'فشل جلب المكالمات المجدولة. حاول مرة أخرى.',
        'section_or_subject_not_assigned' => 'أنت غير مكلف بتدريس/إدارة الشعبة والمادة المحددة.',
        'scheduled_overlap' => 'لديك بالفعل مكالمة مجدولة تتداخل مع هذا الوقت.',
        'scheduled_overlap_with_active' => 'لديك مكالمة نشطة تتداخل مع وقت الجدولة.',
        'active_call_exists' => 'لديك مكالمة نشطة حالياً. أنهِها قبل بدء مكالمة جديدة.',
        'not_owner_of_scheduled' => 'أنت لست مالك هذه المكالمة المجدولة.',
        'invalid_scheduled_status' => 'لا يمكن بدء هذه المكالمة المجدولة (الحالة غير صحيحة).',
        'cannot_start_before_scheduled' => 'لا يمكنك بدء المكالمة المجدولة قبل وقتها المحدد.',
        'cannot_start_before_scheduled_detail' => 'لا يمكن بدء المكالمة المجدولة قبل :scheduled_at.',
        'save_failed' => 'فشل حفظ بيانات المكالمة. حاول مرة أخرى.',
    ],
];
