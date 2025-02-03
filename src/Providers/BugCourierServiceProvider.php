<?php

namespace ManuelLuvuvamo\BugCourier\Providers;

use Illuminate\Support\ServiceProvider;
use ManuelLuvuvamo\BugCourier\Domain\ItemRepository;
use ManuelLuvuvamo\BugCourier\Infra\ItemAzureDevopsRepository;
use ManuelLuvuvamo\BugCourier\Infra\ItemGithubRepository;
use ManuelLuvuvamo\BugCourier\Infra\ItemTrelloRepository;
use ManuelLuvuvamo\BugCourier\Http\Middleware\HandleServerError;
use Illuminate\Routing\Router;

class BugCourierServiceProvider extends ServiceProvider
{
	public function register()
	{
    $this->mergeConfigFrom(__DIR__.'/../../config/bug-courier.php', 'bug-courier');

    $this->app->bind(ItemRepository::class, function ($app) {

      if (config('bug-courier.reporting.azure_devops.enable')) {
        return new ItemAzureDevopsRepository();
      } else if (config('bug-courier.reporting.github.enable')) {
        return new ItemGithubRepository();
      } else if (config('bug-courier.reporting.trello.enable')) {
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
      $this->loadViewsFrom(__DIR__.'/../../resources/views', 'bug-courier');
    }

		$this->publishes([
      __DIR__.'/../../config/bug-courier.php' => config_path('bug-courier.php'),
    ], 'bug-courier-config');

    $this->publishes([
      __DIR__.'/../../resources/assets' => public_path('vendor/bug-courier'),
  ], 'bug-courier-assets');

  $this->publishes([
    __DIR__.'/../../resources/views' => resource_path('views/vendor/bug-courier'),
  ], 'bug-courier-views');

	}
}