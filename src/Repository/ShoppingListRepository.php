<?php

namespace App\Repository;

use App\Entity\ShoppingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShoppingList|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingList|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingList[]    findAll()
 * @method ShoppingList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingList::class);
    }

     /**
      * @return ShoppingList[] Returns an array of ShoppingList objects
      */
    public function loadAll(array $filters = []): array
    {
        $qb = $this->createQueryBuilder('s')
            ->orderBy('s.id', 'DESC');

        if (!empty($filters['fromAt'])) {
            $qb
                ->andWhere('s.createdAt >= :fromAt')
                ->setParameter('fromAt', $filters['fromAt']);
        }

        if (!empty($filters['toAt'])) {
            $qb
                ->andWhere('s.createdAt <= :toAt')
                ->setParameter('toAt', $filters['toAt']);
        }

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
