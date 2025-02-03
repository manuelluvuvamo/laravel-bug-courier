<?php

namespace ManuelLuvuvamo\BugCourier\Domain\Item;

class Item
{
    private $id;
    private string $title;
    private string $description;
    private array $metadata;
    private string $status;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;


    public function __construct(string $title, string $description, array $metadata, string $status)
    {
      $this->title = $title;
      $this->description = $description;
      $this->metadata = $metadata;
      $this->status = $status;
      $this->createdAt = new \DateTime();
      $this->updatedAt = new \DateTime();
    }

    public function toArray(): array
    {
      return [
        'id' => $this->id,
        'title' => $this->title,
        'description' => $this->description,
        'metadata' => $this->metadata,
        'status' => $this->status,
        'createdAt' => $this->createdAt->format('d-m-Y H:i:s'),
        'updatedAt' => $this->updatedAt->format('d-m-Y H:i:s'),
      ];
    }

    public function fromArray(array $data): void
    {
      $this->id = $data['id'];
      $this->title = $data['title'];
      $this->description = $data['description'];
      $this->metadata = $data['metadata'];
      $this->status = $data['status'];
      $this->createdAt = new \DateTime($data['createdAt']);
      $this->updatedAt = new \DateTime($data['updatedAt']);
    }


    public function __tostring(): string 
    {
      return json_encode($this->toArray());
    }


    public function id()
    {
      return $this->id;
    }

    public function setId($id): void
    {
      $this->id = $id;
    }

    public function title(): string
    {
      return $this->title;
    }

    public function setTitle($title): void
    {
      $this->title = $title;
    }

    public function  description(): string
    {
      return $this->description;
    }

    public function setDescription($description): void
    {
      $this->description = $description;
    }

    public function metadata(): array
    {
      return $this->metadata;
    }

    public function setMetadata($metadata): void
    {
      $this->metadata = $metadata;
    } 


}