<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\BookProvider;
use Faker\Generator as FakerGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FakerGenerator::class, function () {
            return \Faker\Factory::create();
        });
    
        $this->app->extend(FakerGenerator::class, function (FakerGenerator $faker) {
            $faker->addProvider(BookProvider::class);
    
            return $faker;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
