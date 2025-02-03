<?php

namespace ManuelLuvuvamo\BugCourier\Infra\Item;

use ManuelLuvuvamo\BugCourier\Domain\Item\Item;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;

class ItemAzureDevopsRepository implements ItemRepository
{
    public function save(Item $item): void
    { 
    }
    
    public function update(Item $item): void
    { 
    }

    public function delete(Item $item): void
    { 
    }

    public function findById( $id): Item
    { 
    }
  }