<?php

namespace App\Entity;

use App\Repository\TypeAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeAttributeRepository::class)]
class TypeAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'typeAttributes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EquipmentType $type = null;

    #[ORM\ManyToOne(inversedBy: 'typeAttributes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EquipmentAttribute $attribute = null;

    #[ORM\Column(nullable: true)]
    private ?bool $required = null;

    #[ORM\Column(nullable: true)]
    private ?int $sortOrder = null;

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
