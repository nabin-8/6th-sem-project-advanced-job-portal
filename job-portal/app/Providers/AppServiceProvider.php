<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share FAQs with all views using View::composer
        \Illuminate\Support\Facades\View::composer('components.layout.footer', function ($view) {
            $view->with('faqs', \App\Models\Faq::where('is_published', true)->orderBy('order')->take(5)->get());
        });
    }
}
