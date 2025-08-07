<?php

namespace App\Http\Controllers\Api\V1\Mobile\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SectionSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TeacherScheduleController extends Controller
{
    public function weekly(): JsonResponse
    {
        $teacherId = Auth::user()->teacher->id;
        $slots = SectionSchedule::with(['section', 'period', 'subject'])
            ->where('teacher_id', $teacherId)
            ->orderBy('day_of_week')
            ->orderBy('period_id')
            ->get()
            ->groupBy('day_of_week');
        $schedule = $slots->mapWithKeys(function ($daySlots, $day) {
            return [$day => $daySlots->map(function ($slot) {
                return [
                    'section'   => $slot->section->name,
                    'period'    => $slot->period->name,
                    'time'      => $slot->period->start_time . ' - ' . $slot->period->end_time,
                    'subject'   => $slot->subject->name,
                ];
            })->values()];
        });
        return response()->json([
            'success'  => true,
            'schedule' => $schedule,
        ]);
    }
}
