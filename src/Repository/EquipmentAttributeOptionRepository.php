<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EquipmentAttributeOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EquipmentAttributeOption>
 */
class EquipmentAttributeOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentAttributeOption::class);
    }
}
