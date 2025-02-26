<?php

namespace ManuelLuvuvamo\BugCourier\Infra\Item;

use GuzzleHttp\Client;
use ManuelLuvuvamo\BugCourier\Domain\Item\Item;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;

class ItemTrelloRepository implements ItemRepository
{
    private $client;
    private $baseUrl;
    private $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'https://api.trello.com/1/';
        $this->headers = [
            'Accept' => 'application/json',
        ];
    }

    public function save(Item $item): void
    {
        $url = "{$this->baseUrl}cards";

        $query = [
            'key' => config('bug-courier.reporting.trello.key'),
            'token' => config('bug-courier.reporting.trello.token'),
            'name' => $item->title(),
            'desc' => $item->description(),
            'idList' => config('bug-courier.reporting.trello.list_id'),
        ];

        $response = $this->client->post($url, [
            'headers' => $this->headers,
            'form_params' => $query,
        ]);
    }

    public function update(Item $item): void
    {
    }

    public function delete(Item $item): void
    {
    }

    public function findById($id): Item
    {
    }
}
