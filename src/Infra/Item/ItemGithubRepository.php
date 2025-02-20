<?php

namespace ManuelLuvuvamo\BugCourier\Infra\Item;

use GuzzleHttp\Client;
use ManuelLuvuvamo\BugCourier\Domain\Item\Item;
use ManuelLuvuvamo\BugCourier\Domain\Item\ItemRepository;

class ItemGithubRepository implements ItemRepository
{
  private $client;
  private $baseUrl;
  private $headers;

  public function __construct()
  {
    $this->client = new Client();
    $this->baseUrl = "https://api.github.com/repos/";

    $this->headers = [
      'Accept' => 'application/vnd.github+json',
      'Authorization' => 'Bearer '.config('bug-courier.reporting.github.token'),
      'X-GitHub-Api-Version' => '2022-11-28'
    ];
  }

  public function save(Item $item): void
  {
    $url = "{$this->baseUrl}" . config('bug-courier.reporting.github.owner') . "/" . config('bug-courier.reporting.github.repo') . "/issues";

    $query = [
      'title' => $item->title(),
      'body' => $item->description(),
      'assignees' => config('bug-courier.reporting.github.assignees'),
      'milestone' => config('bug-courier.reporting.github.milestone') ? config('bug-courier.reporting.github.milestone') : null,
      'labels' => config('bug-courier.reporting.github.labels')
    ];

    $response = $this->client->post($url, [
      'headers' => $this->headers,
      'json' => $query
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