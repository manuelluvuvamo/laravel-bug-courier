<?php

namespace ManuelLuvuvamo\BugCourier\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;
use ManuelLuvuvamo\BugCourier\Http\Middleware\HandleServerError;
use ManuelLuvuvamo\BugCourier\Infra\Item\ItemAzureDevopsRepository;
use ManuelLuvuvamo\BugCourier\Infra\Item\ItemGithubRepository;
use ManuelLuvuvamo\BugCourier\Infra\Item\ItemTrelloRepository;

class BugCourierServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/bug-courier.php', 'bug-courier');

        $this->app->bind(ItemRepository::class, function ($app) {
            if (Config::get('bug-courier.reporting.azure_devops.enabled')) {
                return new ItemAzureDevopsRepository();
            } elseif (Config::get('bug-courier.reporting.github.enabled')) {
                return new ItemGithubRepository();
            } elseif (Config::get('bug-courier.reporting.trello.enabled')) {
                return new ItemTrelloRepository();
            }
        });
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        $router = $this->app->make(Router::class);

        $router->pushMiddlewareToGroup('web', HandleServerError::class);

        if (config('bug-courier.views_enabled')) {
            $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'bug-courier');
        }

        $this->publishes([
            __DIR__ . '/../../config/bug-courier.php' => config_path('bug-courier.php'),
        ], 'bug-courier-config');

        $this->publishes([
            __DIR__ . '/../../resources/assets' => public_path('vendor/bug-courier'),
        ], 'bug-courier-assets');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/bug-courier'),
        ], 'bug-courier-views');
    }
}
