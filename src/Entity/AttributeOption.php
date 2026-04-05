<?php

namespace App\Entity;

use App\Repository\AttributeOptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributeOptionRepository::class)]
class AttributeOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'attributeOptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EquipmentAttribute $attribute = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(nullable: true)]
    private ?int $sortOrder = null;

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

    public function setValue(string $value): static
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

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(?int $sortOrder): static
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }
}
