<?php

namespace App\Controller;

use App\Request\RecipeCreateRequest;
use App\Request\RecipeRatingRequest;
use App\Request\RecipeSearchRequest;
use App\Request\RecipeUpdateRequest;
use App\Service\RecipeManager;
use Framework\Controller\AbstractController;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RecipeController extends AbstractController
{
    const LIMIT_PER_PAGE = 20;

    /**
     * @var RecipeManager
     */
    private $recipeManager;

    public function __construct(RecipeManager $recipeManager)
    {
        $this->recipeManager = $recipeManager;
    }

    public function listAction(Request $request): JsonResponse
    {
        return $this->handleSuccess(
            $this->getRecipeManager()->list(
                $request->get('page', 1),
                $request->get('limit', self::LIMIT_PER_PAGE)
            )
        );
    }

    public function searchAction(Request $request): JsonResponse
    {
        return $this->handleSuccess(
            $this->getRecipeManager()->search(
                RecipeSearchRequest::fromRequest($request->request),
                $request->get('page', 1),
                $request->get('limit', self::LIMIT_PER_PAGE)
            )
        );
    }

    public function createAction(Request $request): JsonResponse
    {
        return $this->handleSuccess(
            $this->getRecipeManager()->createFromRequest(
                RecipeCreateRequest::fromRequest($request->request)
            ),
            201
        );
    }

    public function getAction(string $id): JsonResponse
    {
        return $this->handleSuccess(
            $this->getRecipeManager()->get(Uuid::fromString($id))
        );
    }

    public function updateAction(Request $request, string $id): JsonResponse
    {
        $this->getRecipeManager()->updateFromRequest(
            RecipeUpdateRequest::fromRequest($id, $request->request)
        );

        return $this->handleSuccess(null, 204);
    }

    public function deleteAction(string $id): JsonResponse
    {
        $this->getRecipeManager()->delete(Uuid::fromString($id));

        return $this->handleSuccess(null, 204);
    }

    public function rateAction(Request $request, string $id): JsonResponse
    {
        $this->getRecipeManager()->addRateFromRequest(
            RecipeRatingRequest::fromRequest($id, $request->request)
        );

        return $this->handleSuccess(null, 204);
    }

    protected function getRecipeManager(): RecipeManager
    {
        return $this->recipeManager;
    }
}
