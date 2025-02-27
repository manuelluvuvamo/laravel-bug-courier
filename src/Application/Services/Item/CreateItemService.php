<?php

namespace ManuelLuvuvamo\BugCourier\Application\Services\Item;

use Illuminate\Support\Facades\Mail;
use ManuelLuvuvamo\BugCourier\Domain\Item\Item;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;
use ManuelLuvuvamo\BugCourier\Mail\ItemReportMail;

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
            'title' => $item->title(),
            'description' => $item->description(),
            'metadata' => $item->metadata(),
        ];

        try {
            $mailable = new ItemReportMail($emailData);

            if (config('bug-courier.reporting.email.queue', false)) {
                Mail::to(config('bug-courier.reporting.email.address'))->queue($mailable);
            } else {
                Mail::to(config('bug-courier.reporting.email.address'))->send($mailable);
            }
        } catch (\Throwable $exception) {
            \Log::error('Failed to send error report email', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
        }
    }
}
