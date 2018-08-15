<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Entity\RecipeRate;
use App\Exception\RecipeAlreadyExistsException;
use App\Exception\RecipeNotFoundException;
use App\Repository\RecipeRepository;
use App\Request\RecipeCreateRequest;
use App\Request\RecipeRatingRequest;
use App\Request\RecipeSearchRequest;
use App\Request\RecipeUpdateRequest;
use App\Service\RecipeSearch\QueryBuilder;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RecipeManager
{
    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    /**
     * @var QueryBuilder
     */
    private $recipeSearchQueryBuilder;

    public function __construct(RecipeRepository $recipeRepository, QueryBuilder $recipeSearchQueryBuilder)
    {
        $this->recipeRepository = $recipeRepository;
        $this->recipeSearchQueryBuilder = $recipeSearchQueryBuilder;
    }

    public function createFromRequest(RecipeCreateRequest $recipeCreateRequest): Recipe
    {
        $uuid = Uuid::uuid4();

        $this->validateRecipeDuplicity($recipeCreateRequest->name);

        $recipe = Recipe::createWithValues(
            $uuid,
            $recipeCreateRequest->name,
            $recipeCreateRequest->prepTime,
            $recipeCreateRequest->difficulty,
            $recipeCreateRequest->vegetarian
        );

        $this->getRecipeRepository()->save($recipe);

        return $recipe;
    }

    public function updateFromRequest(RecipeUpdateRequest $recipeUpdateRequest): Recipe
    {
        $recipe = $this->get($recipeUpdateRequest->id);

        $this->validateRecipeDuplicity($recipeUpdateRequest->name, $recipe->getId());

        $recipe->update(
            $recipeUpdateRequest->name,
            $recipeUpdateRequest->prepTime,
            $recipeUpdateRequest->difficulty,
            $recipeUpdateRequest->vegetarian
        );

        $this->getRecipeRepository()->save($recipe);

        return $recipe;
    }

    /**
     * @return Recipe[]
     */
    public function list(int $page, int $limit = 20): array
    {
        return $this->getRecipeRepository()->findBy(
            [],
            [],
            $limit,
            ($limit * ($page - 1))
        );
    }

    public function get(UuidInterface $uuid): Recipe
    {
        $recipe = $this->getRecipeRepository()->find($uuid);

        if (!$recipe) {
            throw new RecipeNotFoundException();
        }

        return $recipe;
    }

    public function delete(UuidInterface $uuid)
    {
        $recipe = $this->getRecipeRepository()->find($uuid);

        if (!$recipe) {
            throw new RecipeNotFoundException();
        }

        $this->getRecipeRepository()->delete($recipe);
    }

    public function addRateFromRequest(RecipeRatingRequest $recipeRatingRequest)
    {
        $recipe = $this->get($recipeRatingRequest->id);

        $recipeRateId = Uuid::uuid4();

        $recipe->addRate(RecipeRate::createWithValues(
            $recipeRateId,
            $recipe,
            $recipeRatingRequest->rate
        ));

        $this->getRecipeRepository()->save($recipe);
    }

    protected function validateRecipeDuplicity(string $recipeName, UuidInterface $recipeId = null)
    {
        $existingRecipe = $this->getRecipeRepository()->findOneBy(['name' => $recipeName]);

        if (!$existingRecipe) {
            return;
        }

        if ($recipeId === null || (string) $existingRecipe->getId() != (string) $recipeId) {
            throw new RecipeAlreadyExistsException();
        }
    }

    /**
     * @return Recipe[]
     */
    public function search(RecipeSearchRequest $recipeSearchRequest, int $page, int $limit): array
    {
        return $this->getRecipeRepository()->search(
            $this->getRecipeSearchQueryBuilder()->buildFromRequest($recipeSearchRequest),
            $limit,
            ($limit * ($page - 1))
        );
    }

    protected function getRecipeRepository(): RecipeRepository
    {
        return $this->recipeRepository;
    }

    protected function getRecipeSearchQueryBuilder(): QueryBuilder
    {
        return $this->recipeSearchQueryBuilder;
    }
}
