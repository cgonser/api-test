<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Request\RecipeCreateRequest;
use App\Request\RecipeRatingRequest;
use App\Request\RecipeUpdateRequest;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RecipeManager
{
//    /**
//     * @var RecipeRepository
//     */
//    private $recipeRepository;
//
//    public function __construct(RecipeRepository $recipeRepository)
//    {
//        $this->recipeRepository = $recipeRepository;
//    }

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

        // TODO: implement persistence

        return $recipe;
    }

    public function updateFromRequest(RecipeUpdateRequest $recipeUpdateRequest)
    {
        $recipe = $this->get($recipeUpdateRequest->id);

        $this->validateRecipeDuplicity($recipeUpdateRequest->name, $recipe->getId());

        $recipe->update(
            $recipeUpdateRequest->name,
            $recipeUpdateRequest->prepTime,
            $recipeUpdateRequest->difficulty,
            $recipeUpdateRequest->vegetarian
        );

        // TODO: implement persistence

        return $recipe;
    }

    public function get(UuidInterface $uuid): Recipe
    {
        // TODO: implement get logic / throw exception if not found

        return Recipe::createWithValues($uuid, '', 0, 1, false);
    }

    public function delete(UuidInterface $uuid)
    {
        // TODO: implement delete logic
    }

    public function addRateFromRequest(RecipeRatingRequest $recipeRatingRequest)
    {
        // TODO: implement rating logic
    }

    protected function validateRecipeDuplicity(string $recipeName, UuidInterface $recipeId = null)
    {
        // TODO: implement logic for checking duplicity and throw exception if needed
    }
}
