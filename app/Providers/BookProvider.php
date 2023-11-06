<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;

// namespace App\Providers;

use Faker\Generator as FakerGenerator;
use Faker\Provider\Base as FakerProviderBase;

class BookProvider extends FakerProviderBase
{
    protected $generator;

    public function __construct(FakerGenerator $generator)
    {
        parent::__construct($generator);
    }

    // public function title($nbWords = 5)
    // {
    //     $sentence = $this->generator->sentence($nbWords);
    //     return substr($sentence, 0, strlen($sentence) - 1);
    // }

    // php artisan db:seed --class=ProductsTableSeeder

    public function title()
    {
        $adjectives = ['The', 'A', 'An', 'My', 'Your', 'New', 'Ancient', 'Modern', 'Hidden', 'Forgotten', 'Epic', 'Magical', 'Enchanted', 'Timeless'];
    
        $nouns = [
            'Adventure', 'Mystery', 'Romance', 'Fantasy', 'Science Fiction', 'Thriller',
            'History', 'Biography', 'Science', 'Technology', 'Academia', 'Philosophy', 'Travel',
            'Martial Arts', 'Cooking', 'Gardening', 'Finance', 'Health', 'Psychology', 'Art',
            'Survival', 'Mythology', 'Music', 'Business', 'Nature', 'Politics', 'Comedy', 'Horror'
        ];

        $suffixes = [
            'Chronicles', 'Journey', 'Quest', 'Legacy', 'Odyssey', 'Revolution', 'Secrets', 'Destiny',
            'Conspiracy', 'Encounters', 'Whispers', 'Exploration', 'Revelations', 'Legends', 'Innovation',
            'Mysteries', 'Wonders', 'Reflections', 'Adventures', 'Tales', 'Escapades', 'Escapes', 'Wanderlust',
            'Melodies', 'Silhouettes', 'Visions', 'Discoveries', 'Frontiers', 'Confessions'
        ];

        $adjective = $adjectives[array_rand($adjectives)];
        $noun = $nouns[array_rand($nouns)];
        $suffix = $suffixes[array_rand($suffixes)];;

        return "{$adjective} {$noun} {$suffix}";
    }

    public function ISBN()
    {
        return $this->generator->ean13;
    }
}




// class BookProvider extends ServiceProvider
// {
    
//     /**
//      * Register services.
//      *
//      * @return void
//      */
//     public function register()
//     {
//         //
//     }

//     /**
//      * Bootstrap services.
//      *
//      * @return void
//      */
//     public function boot()
//     {
//         //
//     }
// }
