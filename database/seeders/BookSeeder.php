<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Book::factory()->count(10)->create()->each(function ($book) {
            $categories = \App\Models\Category::inRandomOrder()->take(2)->pluck('id');
            $book->categories()->attach($categories);
        });
    }
}
