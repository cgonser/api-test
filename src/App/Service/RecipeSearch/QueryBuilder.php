<?php

namespace App\Service\RecipeSearch;

use App\Entity\Recipe;
use App\Request\RecipeSearchRequest;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;

class QueryBuilder
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildFromRequest(RecipeSearchRequest $recipeSearchRequest): Query
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('r')
            ->from('App\Entity\Recipe', 'r');

        if ($recipeSearchRequest->name) {
            $queryBuilder->andWhere("r.name LIKE '%".$recipeSearchRequest->name."%'");
        }

        if ($recipeSearchRequest->prepTimeMin) {
            $queryBuilder->andWhere("r.prepTime >= :prep_time_min")
                ->setParameter('prep_time_min', $recipeSearchRequest->prepTimeMin);
        }

        if ($recipeSearchRequest->prepTimeMax) {
            $queryBuilder->andWhere("r.prepTime <= :prep_time_max")
                ->setParameter('prep_time_max', $recipeSearchRequest->prepTimeMax);
        }

        if ($recipeSearchRequest->difficultyMin) {
            $queryBuilder->andWhere("r.difficulty >= :difficulty_min")
                ->setParameter('difficulty_min', $recipeSearchRequest->difficultyMin);
        }

        if ($recipeSearchRequest->difficultyMax) {
            $queryBuilder->andWhere("r.difficulty <= :difficulty_max")
                ->setParameter('difficulty_max', $recipeSearchRequest->difficultyMax);
        }

        if ($recipeSearchRequest->rateMin) {
            $queryBuilder->andWhere("r.rateAverage >= :rate_min")
                ->setParameter('rate_min', $recipeSearchRequest->rateMin);
        }

        if ($recipeSearchRequest->rateMax) {
            $queryBuilder->andWhere("r.rateAverage <= :rate_max")
                ->setParameter('rate_max', $recipeSearchRequest->rateMax);
        }

        if ($recipeSearchRequest->vegetarian === false) {
            $queryBuilder->andWhere("r.vegetarian = false");
        }

        if ($recipeSearchRequest->vegetarian === true) {
            $queryBuilder->andWhere("r.vegetarian = true");
        }

        return $queryBuilder->getQuery();
    }
}
