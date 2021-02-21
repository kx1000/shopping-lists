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
    private $shoppingListFilter;

    public function __construct(ManagerRegistry $registry, ShoppingListFilter $shoppingListFilter)
    {
        parent::__construct($registry, ShoppingList::class);
        $this->shoppingListFilter = $shoppingListFilter;
    }

     /**
      * @return ShoppingList[] Returns an array of ShoppingList objects
      */
    public function loadByFilters(array $filters = []): array
    {
        $qb = $this->createQueryBuilder('sl')
            ->orderBy('sl.id', 'DESC');

        $this->shoppingListFilter->applyFilters($qb, $filters, 'sl');

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function getSummary(array $filters = []): array
    {
        $qb = $this->createQueryBuilder('sl')
            ->select('SUM(sl.price) as sumPrice, o.email')
            ->leftJoin('sl.owner', 'o')
            ->addGroupBy('o.id');

        $this->shoppingListFilter->applyFilters($qb, $filters, 'sl');

        return $qb
            ->getQuery()
            ->getResult();
    }
}
