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

        if (!empty($filters['category'])) {
            $queryBuilder
                ->andWhere($shoppingListAlias . '.category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (!empty($filters['search'])) {
            $queryBuilder
                ->leftJoin($shoppingListAlias . '.shoppingListItems', 'sli')
                ->andWhere('MATCH_AGAINST(sli.name, :searchterm) > 0')
                ->setParameter('searchterm', $filters['search']);
        }

        return $queryBuilder;
    }
}