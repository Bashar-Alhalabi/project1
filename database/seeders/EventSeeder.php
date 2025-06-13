<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Semester;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run()
    {
        $semesters = Semester::all();

        foreach ($semesters as $sem) {
            // create two events per semester
            $start = Carbon::parse($sem->start_date)->addWeeks(2);
            $end = $start->copy()->addDays(2);
            Event::create([
                'title' => "Orientation for {$sem->name}",
                'notes' => "Welcome event for {$sem->name}.",
                'start_date' => $start->toDateString(),
                'end_date' => $end->toDateString(),
                'semester_id' => $sem->id,
            ]);

            $start2 = Carbon::parse($sem->end_date)->subWeeks(2);
            $end2 = $start2->copy()->addDays(1);
            Event::create([
                'title' => "Final Assembly for {$sem->name}",
                'notes' => "Closing ceremony for {$sem->name}.",
                'start_date' => $start2->toDateString(),
                'end_date' => $end2->toDateString(),
                'semester_id' => $sem->id,
            ]);
        }
    }
}
