<?php

namespace Database\Seeders;

use App\Models\EBookCategory;
use Illuminate\Database\Seeder;
use App\Models\EBookCategoryJoin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EBookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiction', 'description' => 'Books that contain stories created from the imagination.'],
            ['name' => 'Non-Fiction', 'description' => 'Books that are based on facts and real events.'],
            ['name' => 'Children\'s Books', 'description' => 'Books written specifically for children.'],
            ['name' => 'Young Adult', 'description' => 'Books aimed at young adult readers, typically ages 12-18.'],
            ['name' => 'Education', 'description' => 'Books used for educational purposes.'],
            ['name' => 'Business', 'description' => 'Books related to business and management.'],
            ['name' => 'Health & Wellness', 'description' => 'Books about maintaining health and well-being.'],
            ['name' => 'Technology', 'description' => 'Books about technological advancements and related subjects.'],
            ['name' => 'Cooking', 'description' => 'Books containing recipes and cooking techniques.'],
            ['name' => 'Arts & Photography', 'description' => 'Books about various forms of art and photography.'],
        ];

        foreach ($categories as $category) {
            EBookCategory::create($category);
        }


        $ebook_categories = [
            [
                'ebook_id' => 1,
                'category_id' => 1,
            ],
            [
                'ebook_id' => 2,
                'category_id' => 2,
            ],
            [
                'ebook_id' => 3,
                'category_id' => 3,
            ],
            [
                'ebook_id' => 1,
                'category_id' => 2,
            ],
            [
                'ebook_id' => 2,
                'category_id' => 3,
            ],
            [
                'ebook_id' => 3,
                'category_id' => 1,
            ],
            [
                'ebook_id' => 1,
                'category_id' => 3,
            ],
            [
                'ebook_id' => 2,
                'category_id' => 1,
            ],
            [
                'ebook_id' => 3,
                'category_id' => 2,
            ],
            [
                'ebook_id' => 1,
                'category_id' => 4,
            ],
            [
                'ebook_id' => 2,
                'category_id' => 5,
            ],
            [
                'ebook_id' => 3,
                'category_id' => 6,
            ],
        ];

        foreach ($ebook_categories as $ebook_category) {
            EBookCategoryJoin::create($ebook_category);
        }
    }
}
