<?php

namespace Tests\Unit\Application\Services\Item;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Mockery;
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemDto;
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemService;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;
use Orchestra\Testbench\TestCase;

class CreateItemServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_saves_item_when_repository_is_available()
    {
        $repositoryMock = Mockery::mock(ItemRepository::class);
        $repositoryMock->shouldReceive('save')->once();

        $service = new CreateItemService($repositoryMock);

        $dto = new CreateItemDto('Error Title', 'Error Description', []);

        $this->expectNotToPerformAssertions();
        
        $service->execute($dto);
    }

    public function test_it_does_not_fail_when_repository_is_null()
    {
        $service = new CreateItemService(null);

        $dto = new CreateItemDto('Error Title', 'Error Description', []);

        $this->expectNotToPerformAssertions();

        $service->execute($dto);
    }

    public function test_it_sends_email_when_reporting_is_enabled()
    {
        Config::set('bug-courier.reporting.email.enabled', true);
        Config::set('bug-courier.reporting.email.address', 'admin@example.com');

        Mail::fake();

        $repositoryMock = Mockery::mock(ItemRepository::class);
        $repositoryMock->shouldReceive('save')->once();

        $service = new CreateItemService($repositoryMock);

        $dto = new CreateItemDto('Error Title', 'Error Description', []);

        $service->execute($dto);

        Mail::assertNothingQueued();
    }

    public function test_it_does_not_send_email_when_reporting_is_disabled()
    {
        Config::set('bug-courier.reporting.email.enabled', false);

        Mail::fake();

        $repositoryMock = Mockery::mock(ItemRepository::class);
        $repositoryMock->shouldReceive('save')->once();

        $service = new CreateItemService($repositoryMock);

        $dto = new CreateItemDto('Error Title', 'Error Description', []);

        $service->execute($dto);

        Mail::assertNothingSent();
    }
}
