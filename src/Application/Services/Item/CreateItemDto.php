<?php

namespace ManuelLuvuvamo\BugCourier\Application\Services\Item;

class CreateItemDto
{
    public string $title;
    public string $description;
    public array $metadata;
    public string $status;

    public function __construct(string $title, string $description, array $metadata = [], string $status = '')
    {
        $this->title = $title;
        $this->description = $description;
        $this->metadata = $metadata;
        $this->status = $status;
    }
}
