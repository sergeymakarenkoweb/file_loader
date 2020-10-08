<?php

namespace App\Providers;

use App\Core\Connectors\FacebookConnector;
use App\Core\Facades\UploadFacade;
use App\Core\Factories\FilterStrategyFactory;
use App\Core\Factories\ImageFactory;
use App\Core\Factories\ImageGroupFactory;
use App\Core\Repositories\AlbumRepository;
use App\Core\Repositories\ImageGroupRepository;
use App\Core\Repositories\ImageRepository;
use App\Core\Repositories\InstagramRepository;
use App\Core\Repositories\SizeRepository;
use App\Core\Services\AlbumService;
use App\Core\Services\ImageService;
use App\Core\Services\InstagramService;
use App\Core\Repositories\StorageRepository;
use App\Core\Strategies\BlurFilterStrategy;
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
        $this->app->singleton(FacebookConnector::class);
        $this->app->singleton(StorageRepository::class);
        $this->app->singleton(UploadFacade::class);
        $this->app->singleton(FilterStrategyFactory::class);
        $this->app->singleton(ImageFactory::class);
        $this->app->singleton(ImageGroupFactory::class);
        $this->app->singleton(AlbumRepository::class);
        $this->app->singleton(ImageGroupRepository::class);
        $this->app->singleton(ImageRepository::class);
        $this->app->singleton(InstagramRepository::class);
        $this->app->singleton(SizeRepository::class);
        $this->app->singleton(StorageRepository::class);
        $this->app->singleton(AlbumService::class);
        $this->app->singleton(ImageService::class);
        $this->app->singleton(InstagramService::class);
        $this->app->singleton(BlurFilterStrategy::class);
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
