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

    public function toArray()
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

    public function fromArray(array $data)
    {
      $this->id = $data['id'];
      $this->title = $data['title'];
      $this->description = $data['description'];
      $this->metadata = $data['metadata'];
      $this->status = $data['status'];
      $this->createdAt = new \DateTime($data['createdAt']);
      $this->updatedAt = new \DateTime($data['updatedAt']);
    }


    public function __tostring()
    {
      return json_encode($this->toArray());
    }


    public function getId()
    {
      return $this->id;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function getTitle()
    {
      return $this->title;
    }

    public function setTitle($title)
    {
      $this->title = $title;
    }

    public function getDescription()
    {
      return $this->description;
    }

    public function setDescription($description)
    {
      $this->description = $description;
    }

    public function getMetadata()
    {
      return $this->metadata;
    }

    public function setMetadata($metadata)
    {
      $this->metadata = $metadata;
    } 


}