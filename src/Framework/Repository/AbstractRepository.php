<?php

namespace Framework\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AbstractRepository extends EntityRepository
{
    public function __construct(EntityManager $entityManager, string $entityClass)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata($entityClass));
    }
}
