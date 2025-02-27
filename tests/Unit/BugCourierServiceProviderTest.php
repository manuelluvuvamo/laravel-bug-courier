<?php

namespace ManuelLuvuvamo\BugCourier\Tests;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Routing\Router;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;
use ManuelLuvuvamo\BugCourier\Http\Middleware\HandleServerError;
use ManuelLuvuvamo\BugCourier\Infra\Item\ItemAzureDevopsRepository;
use ManuelLuvuvamo\BugCourier\Infra\Item\ItemGithubRepository;
use ManuelLuvuvamo\BugCourier\Infra\Item\ItemTrelloRepository;
use ManuelLuvuvamo\BugCourier\Providers\BugCourierServiceProvider;
use Orchestra\Testbench\TestCase;

class BugCourierServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [BugCourierServiceProvider::class];
    }

    public function test_config_is_merged()
    {
        $config = $this->app->make(ConfigRepository::class);

        $this->assertNotNull($config->get('bug-courier'));
    }

    public function test_middleware_is_registered()
    {
        $router = $this->app->make(Router::class);

        $this->assertTrue(in_array(HandleServerError::class, $router->getMiddlewareGroups()['web'] ?? []));
    }

    public function test_repository_binding()
    {
        $config = $this->app->make(ConfigRepository::class);

        $config->set('bug-courier.reporting.azure_devops.enabled', true);
        $this->assertInstanceOf(ItemAzureDevopsRepository::class, $this->app->make(ItemRepository::class));

        $config->set('bug-courier.reporting.azure_devops.enabled', false);
        $config->set('bug-courier.reporting.github.enabled', true);
        $this->assertInstanceOf(ItemGithubRepository::class, $this->app->make(ItemRepository::class));

        $config->set('bug-courier.reporting.github.enabled', false);
        $config->set('bug-courier.reporting.trello.enabled', true);
        $this->assertInstanceOf(ItemTrelloRepository::class, $this->app->make(ItemRepository::class));
    }
}
