<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\Classroom;

class SectionSeeder extends Seeder
{
    public function run()
    {
        $letters = ['A', 'B', 'C'];

        foreach (Classroom::all() as $classroom) {
            foreach ($letters as $letter) {
                Section::create([
                    'name' => $letter,
                    'classroom_id' => $classroom->id,
                ]);
            }
        }
    }
}