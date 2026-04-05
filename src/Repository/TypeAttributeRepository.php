<?php

namespace App\Repository;

use App\Entity\TypeAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeAttribute>
 */
class TypeAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeAttribute::class);
    }
}
