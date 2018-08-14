<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$container = include __DIR__ . '/../config/container.php';

$container->get('kernel')
    ->handle(Request::createFromGlobals())
    ->send();
