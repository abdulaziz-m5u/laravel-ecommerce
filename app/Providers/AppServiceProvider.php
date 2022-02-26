<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrap();
        View::composer('*', function ($view) {
            $view->with('categories_menu', Category::with('children')->whereNull('category_id')->get());
            $view->with('tags_menu', Tag::withCount('products')->get());
            $view->with('recent_reviews',  Review::with('product','user')->whereStatus(true)->latest()->limit(5)->get());
        });
    }
}
