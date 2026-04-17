<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $inventory = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $serial = null;

    #[ORM\ManyToOne(targetEntity: Raion::class)]
    private ?Raion $raion = null;

    #[ORM\ManyToOne(targetEntity: EquipmentType::class)]
    private ?EquipmentType $equipmentType = null;

    #[ORM\Column(type: Types::JSONB, nullable: true)]
    private mixed $equipmentAttributes = null;

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

    public function getRaion(): ?Raion
    {
        return $this->raion;
    }

    public function setRaion(?Raion $raion): static
    {
        $this->raion = $raion;

        return $this;
    }

    public function getEquipmentType(): ?EquipmentType
    {
        return $this->equipmentType;
    }

    public function setEquipmentType(?EquipmentType $equipmentType): static
    {
        $this->equipmentType = $equipmentType;

        return $this;
    }

    public function getEquipmentAttributes(): mixed
    {
        return $this->equipmentAttributes;
    }

    public function setEquipmentAttributes(mixed $equipmentAttributes): static
    {
        $this->equipmentAttributes = $equipmentAttributes;

        return $this;
    }
}
