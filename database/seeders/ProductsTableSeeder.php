<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Providers\BookProvider;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            $bookFaker = app(BookProvider::class);
            $bookTitle = $bookFaker->title; // Generates a random book title
            $bookISBN = $bookFaker->ISBN; // Generates a random book ISBN
            $author = $faker->name;

            Product::create([
                'name' => $bookTitle,
                'author' => $faker->name,
                'ISBN' => $bookISBN,
                'description' => $faker->paragraph,
                'stock' => $faker->numberBetween(10, 20),
                'alert_quantity' => $faker->numberBetween(2, 5),
                'manage_stock' => 1, 
                'price' => $faker->randomFloat(2, 500, 5000), 
                'category_id' => $faker->numberBetween(1, 10), // Assuming you have 10 categories
                'contact_id' => null, 
                'store_id' => $faker->numberBetween(1, 2), 
                'image' => 'path-to-book-image.jpg',
            ]);
        }
    }
}
