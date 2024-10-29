<?php

namespace Database\Seeders;

use App\Models\DegreeProgramme;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Degrees extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degreeProgrammes = [
            [
                'name' => 'BSc',
                'description' => 'Bachelor of Science in Information Technology',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'B-Tech',
                'description' => 'B. Tech. in Information Technology & Communication',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'B-TECH',
                'description' => 'btech',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($degreeProgrammes as $programme) {
            DegreeProgramme::create($programme);
        }
    }
}
