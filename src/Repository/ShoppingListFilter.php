<?php


namespace App\Repository;


use Doctrine\ORM\QueryBuilder;

class ShoppingListFilter
{
    public function applyFilters(QueryBuilder $queryBuilder, array $filters, $shoppingListAlias = 'sl'): QueryBuilder
    {
        if (!empty($filters['fromAt'])) {
            $queryBuilder
                ->andWhere($shoppingListAlias . '.createdAt >= :fromAt')
                ->setParameter('fromAt', $filters['fromAt']);
        }

        if (!empty($filters['toAt'])) {
            $queryBuilder
                ->andWhere($shoppingListAlias . '.createdAt <= :toAt')
                ->setParameter('toAt', $filters['toAt']);
        }

        return $queryBuilder;
    }
}