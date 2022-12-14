<?php

namespace App\Providers;

use App\Http\Repositories\ArticleRepository;
use App\Http\Repositories\Repository;
use App\Http\Repositories\CobaRepository;
use App\Http\Repositories\ContactRepository;
use App\Http\Repositories\DocumentRepository;
use App\Http\Repositories\Interfaces\ArticleInterface;
use App\Http\Repositories\Interfaces\CobaInterface;
use App\Http\Repositories\Interfaces\ContactInterface;
use App\Http\Repositories\Interfaces\DocumentInterface;
use App\Http\Repositories\Interfaces\ProjectInterface;
use App\Http\Repositories\Interfaces\RepositoryInterface;
use App\Http\Repositories\Interfaces\UserInterface;
use App\Http\Repositories\ProjectRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(RepositoryInterface::class, Repository::class);
        $this->app->bind(CobaInterface::class, CobaRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(ContactInterface::class, ContactRepository::class);
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
        $this->app->bind(ArticleInterface::class, ArticleRepository::class);
        $this->app->bind(DocumentInterface::class, DocumentRepository::class);
    }
}
