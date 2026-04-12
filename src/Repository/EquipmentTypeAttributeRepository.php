<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EquipmentTypeAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EquipmentTypeAttribute>
 */
class EquipmentTypeAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentTypeAttribute::class);
    }
}
