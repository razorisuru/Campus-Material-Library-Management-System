<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EBook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ebooks = [
            [
                'title' => 'The Great Adventure',
                'author' => 'John Doe',
                'description' => 'An epic tale of adventure and discovery.',
                'publication_date' => '2023-05-01',
                'isbn' => '978-3-16-148410-0',
                'cover_image' => 'covers/adventure.jpg',
                'file_path' => 'ebooks/adventure.pdf',
            ],
            [
                'title' => 'Learning Laravel',
                'author' => 'Jane Smith',
                'description' => 'A comprehensive guide to mastering Laravel framework.',
                'publication_date' => '2023-06-15',
                'isbn' => '978-1-23-456789-0',
                'cover_image' => 'covers/laravel.jpg',
                'file_path' => 'ebooks/laravel.pdf',
            ],
            [
                'title' => 'Cooking 101',
                'author' => 'Alice Johnson',
                'description' => 'A beginner\'s guide to cooking with delicious recipes.',
                'publication_date' => '2023-07-22',
                'isbn' => '978-0-12-345678-9',
                'cover_image' => 'covers/cooking.jpg',
                'file_path' => 'ebooks/cooking.pdf',
            ],
        ];

        foreach ($ebooks as $ebook) {
            EBook::create($ebook);
        }
    }
}
