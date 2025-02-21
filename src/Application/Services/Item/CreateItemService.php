<?php

namespace ManuelLuvuvamo\BugCourier\Application\Services\Item;

use Illuminate\Support\Facades\Mail;
use ManuelLuvuvamo\BugCourier\Domain\Item\Item;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;

class CreateItemService
{
    private ?ItemRepository $itemRepository;

    public function __construct(?ItemRepository $itemRepository = null)
    {
        $this->itemRepository = $itemRepository;
    }

    public function execute(CreateItemDto $data): void
    {
        $item = new Item($data->title, $data->description, $data->metadata, $data->status);

        if ($this->itemRepository) {
            $this->itemRepository->save($item);
        }

        if (config('bug-courier.reporting.email.enabled')) {
            $this->sendErrorEmail($item);
        }
    }

    private function sendErrorEmail(Item $item): void
    {
        $emailData = [
            'title'       => $item->title(),
            'description' => $item->description(),
            'metadata'    => $item->metadata(),
        ];

        try {
            Mail::send('bug-courier::emails.item_report', $emailData, function ($message) {
                $message->to(config('bug-courier.reporting.email.address'))
                    ->subject('Error 500 - Execution Failure on '.date('Y/m/d H:i:s').' ['.env('APP_NAME').']');
            });
        } catch (\Throwable $exception) {
            \Log::error('Failed to send error report email', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
        }
    }
}
