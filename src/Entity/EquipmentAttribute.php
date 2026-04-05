<?php

namespace App\Entity;

use App\Repository\EquipmentAttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentAttributeRepository::class)]
class EquipmentAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 50)]
    private ?string $dataType = null;

    #[ORM\Column]
    private ?bool $isMultiple = null;

    /**
     * @var Collection<int, TypeAttribute>
     */
    #[ORM\OneToMany(targetEntity: TypeAttribute::class, mappedBy: 'attribute')]
    private Collection $typeAttributes;

    /**
     * @var Collection<int, AttributeOption>
     */
    #[ORM\OneToMany(targetEntity: AttributeOption::class, mappedBy: 'attribute')]
    private Collection $attributeOptions;

    public function __construct()
    {
        $this->typeAttributes = new ArrayCollection();
        $this->attributeOptions = new ArrayCollection();
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

    public function setIsMultiple(bool $isMultiple): static
    {
        $this->isMultiple = $isMultiple;

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
            $typeAttribute->setAttribute($this);
        }

        return $this;
    }

    public function removeTypeAttribute(TypeAttribute $typeAttribute): static
    {
        if ($this->typeAttributes->removeElement($typeAttribute)) {
            // set the owning side to null (unless already changed)
            if ($typeAttribute->getAttribute() === $this) {
                $typeAttribute->setAttribute(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttributeOption>
     */
    public function getAttributeOptions(): Collection
    {
        return $this->attributeOptions;
    }

    public function addAttributeOption(AttributeOption $attributeOption): static
    {
        if (!$this->attributeOptions->contains($attributeOption)) {
            $this->attributeOptions->add($attributeOption);
            $attributeOption->setAttribute($this);
        }

        return $this;
    }

    public function removeAttributeOption(AttributeOption $attributeOption): static
    {
        if ($this->attributeOptions->removeElement($attributeOption)) {
            // set the owning side to null (unless already changed)
            if ($attributeOption->getAttribute() === $this) {
                $attributeOption->setAttribute(null);
            }
        }

        return $this;
    }
}
