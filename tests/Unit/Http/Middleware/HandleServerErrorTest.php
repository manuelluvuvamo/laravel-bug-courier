<?php

namespace Tests\Feature\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use ManuelLuvuvamo\BugCourier\Providers\BugCourierServiceProvider;
use Orchestra\Testbench\TestCase;
use Symfony\Component\HttpFoundation\Response;
use ManuelLuvuvamo\BugCourier\Http\Middleware\HandleServerError;
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemService;
use Mockery;

class HandleServerErrorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Session::start();
    }

    protected function getPackageProviders($app)
    {
        return [BugCourierServiceProvider::class];
    }

    public function test_it_handles_server_error_and_stores_exception()
    {
        $mockService = Mockery::mock(CreateItemService::class);
        $this->app->instance(CreateItemService::class, $mockService);

        Config::set('bug-courier.automatic_reporting', true);

        $request = Request::create('/test-route', 'GET');

        $exception = new \Exception('Test Exception', 500);
        $response = new Response('', 500);
        $response->exception = $exception;

        $middleware = new HandleServerError();
        $middleware->handle($request, fn() => $response);

        $this->assertEquals('Error 500 - Execution Failure in '.$exception->getFile().' Captured on '.date('Y/m/d H:i:s'), Session::get('exception_title'));
        $this->assertStringContainsString('Test Exception', Session::get('exception_message'));
    }
}
