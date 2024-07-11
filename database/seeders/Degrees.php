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
                'name' => 'BSC',
                'description' => 'bsc',
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
