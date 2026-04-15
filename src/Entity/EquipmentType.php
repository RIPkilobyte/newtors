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

    #[ORM\OneToMany(targetEntity: EquipmentTypeAttribute::class, mappedBy: 'type', fetch: 'EAGER')]
    private Collection $typeAttributes;

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
    public function getTypeAttributes(): Collection
    {
        return $this->typeAttributes;
    }

    public function addTypeAttribute(EquipmentTypeAttribute $typeAttribute): static
    {
        if (!$this->typeAttributes->contains($typeAttribute)) {
            $this->typeAttributes->add($typeAttribute);
            $typeAttribute->setType($this);
        }
        return $this;
    }

    public function removeTypeAttribute(EquipmentTypeAttribute $typeAttribute): static
    {
        if ($this->typeAttributes->removeElement($typeAttribute)) {
            if ($typeAttribute->getType() === $this) {
                $typeAttribute->setType(null);
            }
        }
        return $this;
    }
}
