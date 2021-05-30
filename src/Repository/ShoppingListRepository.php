<?php

namespace App\Repository;

use App\Entity\ShoppingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

    public function loadByFiltersQB(array $filters = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('sl')
            ->addSelect('CASE WHEN sl.price IS NULL THEN 1 ELSE 0 END AS HIDDEN isNullPrice')
            ->orderBy('isNullPrice','DESC')
            ->addOrderBy('sl.createdAt', 'DESC');

        $this->shoppingListFilter->applyFilters($qb, $filters, 'sl');

        return $qb;
    }

    public function getSummaries(array $filters = []): array
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

    public function getMonthReportLabels(): array
    {
        return $this->createQueryBuilder('sl')
            ->select('SUBSTRING(sl.createdAt, 1, 7) as YearMonth')
            ->groupBy('YearMonth')
            ->orderBy('YearMonth', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getMonthReportDataByEmail(?string $email): array
    {
        $query = $this->createQueryBuilder('sl')
            ->select('SUM(sl.price) as monthSum, SUBSTRING(sl.createdAt, 1, 7) as YearMonth')
            ->groupBy('YearMonth')
            ->orderBy('YearMonth', 'ASC');

        if (null !== $email) {
            $query
                ->addSelect('o.email')
                ->leftJoin('sl.owner', 'o')
                ->andWhere('o.email = :email')
                ->addGroupBy('sl.owner')
                ->setParameter('email', $email);
        }

        return $query
            ->getQuery()
            ->getResult();
    }
}
