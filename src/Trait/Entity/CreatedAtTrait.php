<?php

declare(strict_types=1);

namespace App\Trait\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    protected ?\DateTimeImmutable $createdAt = null;

    final public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    final public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
