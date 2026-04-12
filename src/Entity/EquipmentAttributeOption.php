<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EquipmentAttributeOptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentAttributeOptionRepository::class)]
class EquipmentAttributeOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne( targetEntity: EquipmentAttribute::class)]
    private ?EquipmentAttribute $attribute = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $value = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::STRING, options: ['default' => 0])]
    private ?int $sort = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

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
