<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Subjects extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'degree_programme_id' => 1,
                'subject_code' => 'IT 251',
                'name' => 'ADVANCED DEVELOPMENT',
                'description' => 'osss',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'degree_programme_id' => 2,
                'subject_code' => 'IT 257',
                'name' => 'BIO INFORMATICS',
                'description' => 'Eng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'degree_programme_id' => 1,
                'subject_code' => 'IT 345',
                'name' => 'ARTIFICIAL INTELLIGENCE',
                'description' => 'Eng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'degree_programme_id' => 2,
                'subject_code' => 'IT 368',
                'name' => 'PROPOSAL PRESENTATION',
                'description' => 'Eng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
