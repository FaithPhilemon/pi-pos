<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Providers\BookProvider;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    private $words = array(
        // Lorem ipsum...
        'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',

        // and the rest of the vocabulary
        'a', 'ac', 'accumsan', 'ad', 'aenean', 'aliquam', 'aliquet', 'ante',
        'aptent', 'arcu', 'at', 'auctor', 'augue', 'bibendum', 'blandit',
        'class', 'commodo', 'condimentum', 'congue', 'consequat', 'conubia',
        'convallis', 'cras', 'cubilia', 'curabitur', 'curae', 'cursus',
        'dapibus', 'diam', 'dictum', 'dictumst', 'dignissim', 'dis', 'donec',
        'dui', 'duis', 'efficitur', 'egestas', 'eget', 'eleifend', 'elementum',
        'enim', 'erat', 'eros', 'est', 'et', 'etiam', 'eu', 'euismod', 'ex',
        'facilisi', 'facilisis', 'fames', 'faucibus', 'felis', 'fermentum',
        'feugiat', 'finibus', 'fringilla', 'fusce', 'gravida', 'habitant',
        'habitasse', 'hac', 'hendrerit', 'himenaeos', 'iaculis', 'id',
        'imperdiet', 'in', 'inceptos', 'integer', 'interdum', 'justo',
        'lacinia', 'lacus', 'laoreet', 'lectus', 'leo', 'libero', 'ligula',
        'litora', 'lobortis', 'luctus', 'maecenas', 'magna', 'magnis',
        'malesuada', 'massa', 'mattis', 'mauris', 'maximus', 'metus', 'mi',
        'molestie', 'mollis', 'montes', 'morbi', 'mus', 'nam', 'nascetur',
        'natoque', 'nec', 'neque', 'netus', 'nibh', 'nisi', 'nisl', 'non',
        'nostra', 'nulla', 'nullam', 'nunc', 'odio', 'orci', 'ornare',
        'parturient', 'pellentesque', 'penatibus', 'per', 'pharetra',
        'phasellus', 'placerat', 'platea', 'porta', 'porttitor', 'posuere',
        'potenti', 'praesent', 'pretium', 'primis', 'proin', 'pulvinar',
        'purus', 'quam', 'quis', 'quisque', 'rhoncus', 'ridiculus', 'risus',
        'rutrum', 'sagittis', 'sapien', 'scelerisque', 'sed', 'sem', 'semper',
        'senectus', 'sociosqu', 'sodales', 'sollicitudin', 'suscipit',
        'suspendisse', 'taciti', 'tellus', 'tempor', 'tempus', 'tincidunt',
        'torquent', 'tortor', 'tristique', 'turpis', 'ullamcorper', 'ultrices',
        'ultricies', 'urna', 'ut', 'varius', 'vehicula', 'vel', 'velit',
        'venenatis', 'vestibulum', 'vitae', 'vivamus', 'viverra', 'volutpat',
        'vulputate',
    );


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 25) as $index) {
            $bookFaker = app(BookProvider::class);
            $bookTitle = $bookFaker->title(); // Generates a random book title
            $bookISBN = $bookFaker->ISBN(); // Generates a random book ISBN
            // $category = Category::all();

            Product::create([
                'name' => $bookTitle,
                'author' => $faker->name,
                'ISBN' => $bookISBN,
                'description' => $this->customParagraph($faker, 3),
                'stock' => $faker->numberBetween(10, 20),
                'alert_quantity' => $faker->numberBetween(2, 5),
                'manage_stock' => 1, 
                'price' => $faker->randomFloat(2, 500, 5000), 
                'image' => 'path-to-book-image.jpg',
                'qr_code' => null,
                'barcode' => null,
                'category_id' => $faker->numberBetween(2, 12), //$category->random()->id, // Assuming you have 10 categories
                'contact_id' => null, 
                'store_id' => $faker->numberBetween(1, 2), 
            ]);
        }
    }


    public function customParagraph($faker, $nbSentences = 3)
    {
        $sentences = [];
        $wordCount = count($this->words);

        for ($i = 0; $i < $nbSentences; $i++) {
            $sentence = [];

            // Generate a random number of words for each sentence
            $sentenceLength = $faker->numberBetween(5, 15);

            for ($j = 0; $j < $sentenceLength; $j++) {
                // Pick a random word from the provided list
                $randomWord = $this->words[$faker->numberBetween(0, $wordCount - 1)];
                $sentence[] = $randomWord;
            }

            // Convert the array of words into a sentence
            $sentences[] = ucfirst(implode(' ', $sentence)) . '.';
        }

        return implode(' ', $sentences);
    }

}
