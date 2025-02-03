<?php

namespace ManuelLuvuvamo\BugCourier\Application\Services\Item;

use ManuelLuvuvamo\BugCourier\Domain\Item\Item;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;

class CreateItemService
{

  private ItemRepository $itemRepository;

  public function __construct(ItemRepository $itemRepository)
  {
    $this->itemRepository = $itemRepository;
  }

  public function execute(CreateItemDto $data): void
  {
    $item = new Item($data->title, $data->description, $data->metadata, $data->status);
    $this->itemRepository->save($item);
  }
  
}