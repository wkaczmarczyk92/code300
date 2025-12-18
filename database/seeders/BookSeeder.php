<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i <= 100; $i++) {
            $title_lenght = rand(1, 6);
            Book::create([
                'title' => fake()->sentence($title_lenght)
            ]);
        }
    }
}
