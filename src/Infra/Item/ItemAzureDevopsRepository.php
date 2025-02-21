<?php

namespace ManuelLuvuvamo\BugCourier\Infra\Item;

use GuzzleHttp\Client;
use ManuelLuvuvamo\BugCourier\Domain\Item\Item;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;

class ItemAzureDevopsRepository implements ItemRepository
{
    private $client;
    private $baseUrl;
    private $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'https://dev.azure.com/';

        $this->headers = [
            'Authorization' => 'Basic '.base64_encode(':'.config('bug-courier.reporting.azure_devops.token')),
            'Content-Type' => 'application/json-patch+json',
        ];
    }

    public function save(Item $item): void
    {
        $url = "{$this->baseUrl}".config('bug-courier.reporting.azure_devops.organization').'/'.config('bug-courier.reporting.azure_devops.project').'/_apis/wit/workitems/$issue?api-version='.config('bug-courier.reporting.azure_devops.api_version');

        $query = [
            [
                'op' => 'add',
                'path' => '/fields/System.Title',
                'value' => $item->title(),
            ],
            [
                'op' => 'add',
                'path' => '/fields/System.Description',
                'value' => $item->description(),
            ],
            [
                'op' => 'add',
                'path' => '/fields/System.AreaPath',
                'value' => config('bug-courier.reporting.azure_devops.area_path'),
            ],
        ];

        $item->setMetadata(['System.Tags' => env('APP_NAME')] + $item->metadata());

        foreach ($item->metadata() as $key => $value) {
            $query[] = [
                'op' => 'add',
                'path' => "/fields/{$key}",
                'value' => $value,
            ];
        }

        $response = $this->client->post($url, [
            'headers' => $this->headers,
            'json' => $query,
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
