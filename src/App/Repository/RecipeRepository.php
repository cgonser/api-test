<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Framework\Repository\AbstractRepository;

class RecipeRepository extends AbstractRepository
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Recipe::class);
    }

    public function save(Recipe $recipe)
    {
        $this->getEntityManager()->persist($recipe);
        $this->getEntityManager()->flush();
    }

    public function delete(Recipe $recipe)
    {
        $this->getEntityManager()->remove($recipe);
        $this->getEntityManager()->flush();
    }

    /**
     * @return Recipe[]
     */
    public function search(Query $query, $limit, $offset): array
    {
        $query->setFirstResult($offset);
        $query->setMaxResults($limit);

        return $query->getResult();
    }
}
