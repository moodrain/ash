<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $languages = request()->getLanguages();
        foreach ($languages as $language) {
            if (str_contains($language, 'zh')) {
                break;
            }
            if (str_contains($language, 'en')) {
                app()->setLocale('en');
                break;
            }
        }
    }
}
