<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EquipmentAttributeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentAttributeRepository::class)]
class EquipmentAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private ?string $dataType = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private ?bool $isMultiple = null;

    #[ORM\OneToMany(targetEntity: EquipmentAttributeOption::class, mappedBy: 'equipmentAttribute')]
    private Collection $equipmentAttributeOption;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): static
    {
        $this->dataType = $dataType;

        return $this;
    }

    public function isMultiple(): ?bool
    {
        return $this->isMultiple;
    }

    public function setIsMultiple(?bool $isMultiple): static
    {
        $this->isMultiple = $isMultiple;

        return $this;
    }

    /**
     * @return Collection<int, EquipmentAttributeOption>
     */
    public function getEquipmentAttributeOption(): Collection
    {
        return $this->equipmentAttributeOption;
    }

    public function addEquipmentAttributeOption(EquipmentAttributeOption $equipmentAttributeOption): static
    {
        if (!$this->equipmentAttributeOption->contains($equipmentAttributeOption)) {
            $this->equipmentAttributeOption->add($equipmentAttributeOption);
            $equipmentAttributeOption->setEquipmentAttribute($this);
        }
        return $this;
    }

    public function removeEquipmentAttributeOption(EquipmentAttributeOption $equipmentAttributeOption): static
    {
        if ($this->equipmentAttributeOption->removeElement($equipmentAttributeOption)) {
            if ($equipmentAttributeOption->getEquipmentAttribute() === $this) {
                $equipmentAttributeOption->setEquipmentAttribute(null);
            }
        }
        return $this;
    }
}
