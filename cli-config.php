<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

$container = include __DIR__ . '/config/container.php';

$container->get('kernel')->registerDoctrineTypes();

$connection = DriverManager::getConnection([
    'host' => $container->getParameter('database.hostname'),
    'user' => $container->getParameter('database.username'),
    'dbname' => $container->getParameter('database.dbname'),
    'password' => $container->getParameter('database.password'),
    'port' => $container->getParameter('database.port'),
    'driver' => $container->getParameter('database.driver'),
], new Configuration());

$entityManagerConfiguration = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $paths = [__DIR__ . '/src/App/Entity'],
    $isDevMode = true
);

$entityManager = Doctrine\ORM\EntityManager::create($connection, $entityManagerConfiguration);

return new HelperSet([
    'db' => new ConnectionHelper($connection),
    'em' => new EntityManagerHelper($entityManager),
]);
