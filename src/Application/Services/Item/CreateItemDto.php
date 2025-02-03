<?php

namespace ManuelLuvuvamo\BugCourier\Application\Services\Item;

use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;

class CreateItemDto
{

  public string $title;
  public string $description;
  public array $metadata;
  public string $status;

  
  public function __construct(string $title, string $description, array $metadata = [], string $status = null)
    {
      $this->title = $title;
      $this->description = $description;
      $this->metadata = $metadata;
      $this->status = $status;
    }
}