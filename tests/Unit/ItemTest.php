<?php

use ManuelLuvuvamo\BugCourier\Domain\Item\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
  public function testItemCreation()
  {
    $title = 'Test Title';
    $description = 'Test Description';
    $metadata = ['key' => 'value'];
    $status = 'active';

    $item = new Item($title, $description, $metadata, $status);

    $this->assertEquals($title, $item->title());
    $this->assertEquals($description, $item->description());
    $this->assertEquals($metadata, $item->metadata());
    $this->assertEquals($status, $item->status());
    $this->assertInstanceOf(\DateTime::class, $item->createdAt());
    $this->assertInstanceOf(\DateTime::class, $item->updatedAt());
  }

  public function testToArray()
  {
    $title = 'Test Title';
    $description = 'Test Description';
    $metadata = ['key' => 'value'];
    $status = 'active';

    $item = new Item($title, $description, $metadata, $status);
    $array = $item->toArray();

    $this->assertArrayHasKey('id', $array);
    $this->assertArrayHasKey('title', $array);
    $this->assertArrayHasKey('description', $array);
    $this->assertArrayHasKey('metadata', $array);
    $this->assertArrayHasKey('status', $array);
    $this->assertArrayHasKey('createdAt', $array);
    $this->assertArrayHasKey('updatedAt', $array);
  }

  public function testFromArray()
  {
    $data = [
      'id' => 1,
      'title' => 'Test Title',
      'description' => 'Test Description',
      'metadata' => ['key' => 'value'],
      'status' => 'active',
      'createdAt' => '01-01-2023 00:00:00',
      'updatedAt' => '01-01-2023 00:00:00',
    ];

    $item = new Item('Title', 'Description', [], 'status');
    $item->fromArray($data);

    $this->assertEquals($data['id'], $item->id());
    $this->assertEquals($data['title'], $item->title());
    $this->assertEquals($data['description'], $item->description());
    $this->assertEquals($data['metadata'], $item->metadata());
    $this->assertEquals($data['status'], $item->status());
    $this->assertEquals($data['createdAt'], $item->createdAt()->format('d-m-Y H:i:s'));
    $this->assertEquals($data['updatedAt'], $item->updatedAt()->format('d-m-Y H:i:s'));
  }

  public function testToString()
  {
    $title = 'Test Title';
    $description = 'Test Description';
    $metadata = ['key' => 'value'];
    $status = 'active';

    $item = new Item($title, $description, $metadata, $status);
    $json = (string) $item;

    $this->assertJson($json);
    $array = json_decode($json, true);
    $this->assertEquals($item->toArray(), $array);
  }
}