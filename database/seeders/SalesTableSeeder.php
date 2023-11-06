<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\SaleStatus;
use App\Models\PaymentStatus;
use App\Models\PaymentMethod;
use App\Models\ShippingStatus;
use Faker\Factory as Faker;

class SalesTableSeeder extends Seeder
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

    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $index) {
            $sale = Sale::create([
                'invoice_number' => $faker->unique()->randomNumber(6),
                'date' => $faker->dateTimeThisMonth,
                'phone_number' => $faker->phoneNumber,
                'customer_name' => $faker->name,
                'store' => 'Discovery World Bookshop',
                'total_amount' => $faker->randomFloat(2, 1000, 10000),
                'total_paid' => $faker->randomFloat(2, 0, 9000),
                'total_items' => $faker->numberBetween(2, 10),
                'shipping_details' => $this->customParagraph($faker, 2),
                'added_by' => $faker->numberBetween(1, 3), // Assuming user IDs 1 to 5
                'staff_note' => $this->customParagraph($faker, 2),
                'sale_note' => $this->customParagraph($faker, 2),
            ]);

            // Associate a random Sale Status
            $saleStatus = SaleStatus::inRandomOrder()->first();
            $sale->saleStatus()->associate($saleStatus);

            // Associate a random Payment Status
            $paymentStatus = PaymentStatus::inRandomOrder()->first();
            $sale->paymentStatus()->associate($paymentStatus);

            // Associate a random Payment Method
            $paymentMethod = PaymentMethod::inRandomOrder()->first();
            $sale->paymentMethod()->associate($paymentMethod);

            // Associate a random Shipping Status
            $shippingStatus = ShippingStatus::inRandomOrder()->first();
            $sale->shippingStatus()->associate($shippingStatus);

            $sale->save();
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

