<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Equipment;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Equipment>
 */
class EquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }

    public function findByFilters(?User $user, array $filters, int $page, int $limit): array
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.type', 't')
            ->addSelect('t')
            ->leftJoin('e.raion', 'r')
            ->addSelect('r');

        // роли
        if ($user && in_array('ROLE_RAION_ADMIN', $user->getRoles()) && $user->getRaion()) {
            $qb->andWhere('e.raion = :raion')->setParameter('raion', $user->getRaion());
        } elseif ($user && in_array('ROLE_RAION_VIEWER', $user->getRoles()) && $user->getRaion()) {
            $qb->andWhere('e.raion = :raion')->setParameter('raion', $user->getRaion());
        }

        // Фильтры Tabulator
        foreach ($filters as $filter) {
            $field = $filter['field'] ?? null;
            $value = $filter['value'] ?? null;
            $type = $filter['type'] ?? '=';
            if (!$field || $value === null) continue;

            if ($field === 'inventory') {
                $qb->andWhere('e.inventory LIKE :inventory')->setParameter('inventory', "%$value%");
            } elseif ($field === 'serial') {
                $qb->andWhere('e.serial LIKE :serial')->setParameter('serial', "%$value%");
            } elseif ($field === 'typeName') {
                $qb->andWhere('t.name LIKE :type')->setParameter('type', "%$value%");
            } elseif ($field === 'raionName') {
                $qb->andWhere('r.name LIKE :raion')->setParameter('raion', "%$value%");
            } else {
                // типа attributes->>'ram_gb' = '16'
                $qb->andWhere("e.attributes->>:field = :val")
                   ->setParameter('field', $field)
                   ->setParameter('val', $value);
            }
        }

        // Пагинация
        $total = (clone $qb)->select('COUNT(e.id)')->getQuery()->getSingleScalarResult();
        $qb->setFirstResult(($page - 1) * $limit)->setMaxResults($limit);
        $data = $qb->getQuery()->getResult();

        // Tabulator
        $items = [];
        foreach ($data as $eq) {
            $items[] = [
                'id' => $eq->getId(),
                'inventory' => $eq->getInventory(),
                'serial' => $eq->getSerial(),
                'typeName' => $eq->getType()->getName(),
                'raionName' => $eq->getRaion() ? $eq->getRaion()->getName() : '',
                'attributes' => json_encode($eq->getAttributes(), JSON_UNESCAPED_UNICODE),
            ];
        }

        return ['data' => $items, 'total' => $total];
    }
}
