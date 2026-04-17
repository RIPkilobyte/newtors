<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EquipmentTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentTypeRepository::class)]
class EquipmentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: EquipmentTypeAttribute::class, mappedBy: 'equipmentType', fetch: 'EAGER')]
    private Collection $equipmentTypeAttributes;

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

    /**
     * @return Collection<int, EquipmentTypeAttribute>
     */
    public function getEquipmentTypeAttributes(): Collection
    {
        return $this->equipmentTypeAttributes;
    }

    public function addEquipmentTypeAttribute(EquipmentTypeAttribute $equipmentTypeAttributes): static
    {
        if (!$this->equipmentTypeAttributes->contains($equipmentTypeAttributes)) {
            $this->equipmentTypeAttributes->add($equipmentTypeAttributes);
            $equipmentTypeAttributes->setEquipmentType($this);
        }
        return $this;
    }

    public function removeEquipmentTypeAttribute(EquipmentTypeAttribute $equipmentTypeAttributes): static
    {
        if ($this->equipmentTypeAttributes->removeElement($equipmentTypeAttributes)) {
            if ($equipmentTypeAttributes->getEquipmentType() === $this) {
                $equipmentTypeAttributes->setEquipmentType(null);
            }
        }
        return $this;
    }
}
