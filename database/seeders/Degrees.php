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
                'id' => '1',
                'name' => 'BScIT',
                'description' => 'Bachelor of Science in Information Technology',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2',
                'name' => 'B-Tech',
                'description' => 'B. Tech. in Information Technology & Communication',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '3',
                'name' => 'BAGD',
                'description' => 'BA (General) Degree',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '4',
                'name' => 'BBM',
                'description' => 'Bachelor of Business Management (Honours) Degree',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '5',
                'name' => 'BABL',
                'description' => 'BA Special Degree in Buddhist Leadership',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '6',
                'name' => 'PALI',
                'description' => 'BA Special Degree in Pali Studies',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        foreach ($degreeProgrammes as $programme) {
            DegreeProgramme::create($programme);
        }
    }
}
