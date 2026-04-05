<?php

declare(strict_types=1);

namespace App\Trait\Entity;

use Doctrine\ORM\Mapping as ORM;

trait CreatedByTrait
{
    #[ORM\ManyToOne(targetEntity: User::class)]
    protected ?User $createdBy = null;

    final public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    final public function setCreatedBy(?User $user): static
    {
        $this->createdBy = $user;

        return $this;
    }
}
