<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Classroom;

class SubjectSeeder extends Seeder
{
    public function run()
    {

        $names = ['Math', 'Science', 'History', 'Language'];

        foreach (Classroom::all() as $classroom) {
            foreach ($names as $name) {
                Subject::create([
                    'classroom_id' => $classroom->id,
                    'name' => $name,
                    'amount' => 40,
                ]);
            }
        }
    }
}