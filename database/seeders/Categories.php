<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Lecture Note', 'Presentation', 'Test', 'Activity', 'C-Form'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
