<?php

namespace App\Controller;

use Framework\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RecipeController extends AbstractController
{
    public function __construct()
    {
    }

    public function listAction(Request $request): JsonResponse
    {
        return $this->handleSuccess([]);
    }

    public function createAction(Request $request): JsonResponse
    {
        return $this->handleSuccess([], 201);
    }

    public function getAction(Request $request, string $id): JsonResponse
    {
        return $this->handleSuccess();
    }

    public function updateAction(Request $request, string $id): JsonResponse
    {
        return $this->handleSuccess();
    }

    public function deleteAction(Request $request, string $id): JsonResponse
    {
        return $this->handleSuccess();
    }

    public function rateAction(Request $request, string $id): JsonResponse
    {
        return $this->handleSuccess();
    }

    public function searchAction(Request $request): JsonResponse
    {
        return $this->handleSuccess([]);
    }
}