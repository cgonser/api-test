<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\Request;

$container = include __DIR__ . '/../config/container.php';

$container->get(HttpKernel::class)
    ->handle(Request::createFromGlobals())
    ->send();
