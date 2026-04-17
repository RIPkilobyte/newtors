<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EquipmentTypeAttributeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentTypeAttributeRepository::class)]
class EquipmentTypeAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: EquipmentType::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?EquipmentType $equipmentType = null;

    #[ORM\ManyToOne(targetEntity: EquipmentAttribute::class)]
    private ?EquipmentAttribute $equipmentAttribute = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private ?bool $required = null;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private ?int $sort = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEquipmentAttribute(): ?EquipmentAttribute
    {
        return $this->equipmentAttribute;
    }

    public function setEquipmentAttribute(?EquipmentAttribute $equipmentAttribute): static
    {
        $this->equipmentAttribute = $equipmentAttribute;

        return $this;
    }

    public function isRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): static
    {
        $this->required = $required;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(?int $sort): static
    {
        $this->sort = $sort;

        return $this;
    }
}
