<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EquipmentAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EquipmentAttribute>
 */
class EquipmentAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentAttribute::class);
    }
}
