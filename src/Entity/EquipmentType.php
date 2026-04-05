<?php

namespace App\Entity;

use App\Repository\EquipmentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentTypeRepository::class)]
class EquipmentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, TypeAttribute>
     */
    #[ORM\OneToMany(targetEntity: TypeAttribute::class, mappedBy: 'type')]
    private Collection $typeAttributes;

    /**
     * @var Collection<int, Equipment>
     */
    #[ORM\OneToMany(targetEntity: Equipment::class, mappedBy: 'type')]
    private Collection $equipment;

    public function __construct()
    {
        $this->typeAttributes = new ArrayCollection();
        $this->equipment = new ArrayCollection();
    }

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
     * @return Collection<int, TypeAttribute>
     */
    public function getTypeAttributes(): Collection
    {
        return $this->typeAttributes;
    }

    public function addTypeAttribute(TypeAttribute $typeAttribute): static
    {
        if (!$this->typeAttributes->contains($typeAttribute)) {
            $this->typeAttributes->add($typeAttribute);
            $typeAttribute->setType($this);
        }

        return $this;
    }

    public function removeTypeAttribute(TypeAttribute $typeAttribute): static
    {
        if ($this->typeAttributes->removeElement($typeAttribute)) {
            // set the owning side to null (unless already changed)
            if ($typeAttribute->getType() === $this) {
                $typeAttribute->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(Equipment $equipment): static
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment->add($equipment);
            $equipment->setType($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): static
    {
        if ($this->equipment->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getType() === $this) {
                $equipment->setType(null);
            }
        }

        return $this;
    }
}
