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
    private ?EquipmentType $type = null;

    #[ORM\ManyToOne(targetEntity: EquipmentAttribute::class)]
    private ?EquipmentAttribute $attribute = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private ?bool $required = null;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private ?int $sort = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAttribute(): ?EquipmentAttribute
    {
        return $this->attribute;
    }

    public function setAttribute(?EquipmentAttribute $attribute): static
    {
        $this->attribute = $attribute;

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
