<?php

namespace Framework;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Cache\DefaultCacheFactory;
use Doctrine\ORM\Configuration;
use Ramsey\Uuid\Doctrine\UuidType;
use Symfony\Component\HttpKernel\HttpKernel;

class Kernel extends HttpKernel
{
    public function registerDoctrineTypes()
    {
        if (!Type::hasType(UuidType::NAME)) {
            Type::addType(UuidType::NAME, UuidType::class);
        }
    }

    public function enableDoctrineCache(DefaultCacheFactory $factory, Configuration $config)
    {
        $config->setSecondLevelCacheEnabled();
        $config->getSecondLevelCacheConfiguration()
            ->setCacheFactory($factory);
    }
}
