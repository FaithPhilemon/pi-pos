<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Providers\BookProvider;
use App\Models\Setting;
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
        // Fetch the settings from the database
        $settings = Setting::first(); // Assuming you have a single row for settings

        // Share the settings data with all views
        view()->share('settings', $settings);


        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
