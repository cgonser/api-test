<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$containerBuilder = new ContainerBuilder();
$containerBuilder->setParameter('config_dir', __DIR__);

$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__));
$loader->load('framework.yaml');

$containerBuilder->compile(true);

return $containerBuilder;
