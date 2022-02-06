<?php

namespace App\Providers;

use App\Models\Article\ArticlesRepository;
use App\Models\Article\ElasticSearchRepository;
use App\Models\Article\EloquentRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Foundation\Application;
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
        $this->app->bind(ArticlesRepository::class, function (Application $app) {
            if (! config('services.search.enabled')) {
                return new EloquentRepository();
            }
            return new ElasticSearchRepository(
                $app->make(Client::class)
            );
        });
        $this->app->bind(Client::class, function (Application $app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
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
