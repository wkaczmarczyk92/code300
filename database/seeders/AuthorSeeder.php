<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        $genders = ['male', 'female'];

        foreach ($books as $book) {
            $gender = $genders[array_rand($genders)];
            $book->authors()->create([
                'first_name' => fake()->firstName($gender),
                'last_name' => fake()->lastName($gender)
            ]);
        }
    }
}
