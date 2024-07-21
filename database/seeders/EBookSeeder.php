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
            [
                'title' => 'The Science of Happiness',
                'author' => 'Bob Brown',
                'description' => 'Explore the science behind happiness and well-being.',
                'publication_date' => '2023-08-30',
                'isbn' => '978-3-16-148411-7',
                'cover_image' => 'covers/happiness.jpg',
                'file_path' => 'ebooks/happiness.pdf',
            ],
            [
                'title' => 'History of Art',
                'author' => 'Emma White',
                'description' => 'An overview of art history from ancient times to the modern era.',
                'publication_date' => '2023-09-05',
                'isbn' => '978-1-23-456780-1',
                'cover_image' => 'covers/art.jpg',
                'file_path' => 'ebooks/art.pdf',
            ],
            [
                'title' => 'Programming Basics',
                'author' => 'James Green',
                'description' => 'Learn the fundamentals of programming with practical examples.',
                'publication_date' => '2023-10-10',
                'isbn' => '978-0-12-345679-6',
                'cover_image' => 'covers/programming.jpg',
                'file_path' => 'ebooks/programming.pdf',
            ],
            [
                'title' => 'Gardening Tips',
                'author' => 'Laura Blue',
                'description' => 'Essential tips and tricks for successful gardening.',
                'publication_date' => '2023-11-12',
                'isbn' => '978-3-16-148412-4',
                'cover_image' => 'covers/gardening.jpg',
                'file_path' => 'ebooks/gardening.pdf',
            ],
            [
                'title' => 'Travel the World',
                'author' => 'Michael Black',
                'description' => 'A travel guide to the most beautiful destinations around the globe.',
                'publication_date' => '2023-12-01',
                'isbn' => '978-1-23-456781-8',
                'cover_image' => 'covers/travel.jpg',
                'file_path' => 'ebooks/travel.pdf',
            ],
            [
                'title' => 'Health and Fitness',
                'author' => 'Sophia Grey',
                'description' => 'A comprehensive guide to maintaining health and fitness.',
                'publication_date' => '2024-01-15',
                'isbn' => '978-0-12-345680-2',
                'cover_image' => 'covers/fitness.jpg',
                'file_path' => 'ebooks/fitness.pdf',
            ],
            [
                'title' => 'The Future of Technology',
                'author' => 'Daniel Silver',
                'description' => 'Insights into emerging technologies and their impact on society.',
                'publication_date' => '2024-02-20',
                'isbn' => '978-3-16-148413-1',
                'cover_image' => 'covers/technology.jpg',
                'file_path' => 'ebooks/technology.pdf',
            ],
            [
                'title' => 'Mystery at the Mansion',
                'author' => 'Olivia Gold',
                'description' => 'A thrilling mystery novel set in a grand mansion.',
                'publication_date' => '2024-03-30',
                'isbn' => '978-1-23-456782-5',
                'cover_image' => 'covers/mystery.jpg',
                'file_path' => 'ebooks/mystery.pdf',
            ],
        ];

        foreach ($ebooks as $ebook) {
            EBook::create($ebook);
        }
    }
}
