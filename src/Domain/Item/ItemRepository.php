<?php

namespace ManuelLuvuvamo\BugCourier\Domain\Item;

interface ItemRepository
{
    protected $client;
    private $baseUrl;
    public function save(Item $item): void;
    public function update(Item $item): void;
    public function delete(Item $item): void;
    public function findById($id): Item;

}