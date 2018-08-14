<?php

namespace App\Request;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\HttpFoundation\ParameterBag;

class RecipeUpdateRequest extends AbstractRequest
{
    /**
     * @var Uuid
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $prepTime;

    /**
     * @var integer
     */
    public $difficulty;

    /**
     * @var bool
     */
    public $vegetarian;

    public static function fromRequest(string $id, ParameterBag $parameterBag): self
    {
        $parameterBag->set('id', $id);

        $request = new self();
        $request->validateInput((array) $parameterBag->all(), $request->getConstraints());
        $request->id = Uuid::fromString($parameterBag->get('id'));
        $request->name = $parameterBag->get('name');
        $request->prepTime = $parameterBag->get('prep_time');
        $request->difficulty = $parameterBag->get('difficulty');
        $request->vegetarian = $parameterBag->get('vegetarian');

        return $request;
    }

    protected function getConstraints()
    {
        return new Constraints\Collection([
            'id' => new Constraints\Uuid(),
            'name' => new Constraints\Type(['type' => 'string']),
            'difficulty' => [
                new Constraints\Type(['type' => 'integer']),
                new Constraints\Choice([1, 2, 3]),
            ],
            'prep_time' => new Constraints\Type(['type' => 'integer']),
            'vegetarian' => new Constraints\Type(['type' => 'boolean']),
        ]);
    }
}
