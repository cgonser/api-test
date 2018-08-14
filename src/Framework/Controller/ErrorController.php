<?php

namespace Framework\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Debug\Exception\FlattenException;

class ErrorController extends AbstractController
{
    public function handleException(FlattenException $exception): JsonResponse
    {
        return $this->handleError($exception->getMessage(), $exception->getStatusCode());
    }
}
