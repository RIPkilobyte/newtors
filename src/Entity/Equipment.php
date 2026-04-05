<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $inventory = null;

    #[ORM\Column(length: 50)]
    private ?string $serial = null;

    #[ORM\ManyToOne(inversedBy: 'equipment')]
    private ?EquipmentType $type = null;

    #[ORM\Column(type: Types::JSONB, nullable: true)]
    private mixed $attributes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInventory(): ?string
    {
        return $this->inventory;
    }

    public function setInventory(string $inventory): static
    {
        $this->inventory = $inventory;

        return $this;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(string $serial): static
    {
        $this->serial = $serial;

        return $this;
    }

    public function getType(): ?EquipmentType
    {
        return $this->type;
    }

    public function setType(?EquipmentType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAttributes(): mixed
    {
        return $this->attributes;
    }

    public function setAttributes(mixed $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }
}
