<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Author;
use App\Models\User;
use App\Policies\BookPolicy;
use App\Policies\AuthorPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        Book::class => BookPolicy::class,
        Author::class => AuthorPolicy::class,
        User::class => UserPolicy::class,
    ];

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
        //
    }
}
