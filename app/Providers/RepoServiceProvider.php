<?php

namespace App\Providers;

use App\Http\Repository\RepoTags;
use App\Http\Repository\RepoPosts;
use App\Http\Repository\RepoRegister;
use Illuminate\Support\ServiceProvider;
use App\Http\RepositoryInterface\PostInterface;
use App\Http\RepositoryInterface\TagsInterface;
use App\Http\RepositoryInterface\RegisterInterface;

class RepoServiceProvider extends ServiceProvider
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
        $this->app->bind(RegisterInterface::class,RepoRegister::class);
        $this->app->bind(TagsInterface::class,RepoTags::class);
        $this->app->bind(PostInterface::class,RepoPosts::class);
    }
}
