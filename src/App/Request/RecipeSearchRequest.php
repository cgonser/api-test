<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\HttpFoundation\ParameterBag;

class RecipeSearchRequest extends AbstractRequest
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $prepTimeMin;

    /**
     * @var integer
     */
    public $prepTimeMax;

    /**
     * @var integer
     */
    public $difficultyMin;

    /**
     * @var integer
     */
    public $difficultyMax;

    /**
     * @var integer
     */
    public $rateMin;

    /**
     * @var integer
     */
    public $rateMax;

    /**
     * @var bool
     */
    public $vegetarian;

    public static function fromRequest(ParameterBag $parameterBag): self
    {
        $request = new self();
        $request->validateInput((array) $parameterBag->all(), $request->getConstraints());
        $request->name = $parameterBag->get('name');
        $request->prepTimeMin = $parameterBag->get('prep_time_min');
        $request->prepTimeMax = $parameterBag->get('prep_time_max');
        $request->difficultyMin = $parameterBag->get('difficulty_min');
        $request->difficultyMax = $parameterBag->get('difficulty_max');
        $request->rateMin = $parameterBag->get('rate_min');
        $request->rateMax = $parameterBag->get('rate_max');
        $request->vegetarian = $parameterBag->get('vegetarian');

        return $request;
    }

    protected function getConstraints(): Constraints\Collection
    {
        return new Constraints\Collection([
            'name' => new Constraints\Optional(new Constraints\Type(['type' => 'string'])),
            'difficulty_min' => new Constraints\Optional(new Constraints\Type(['type' => 'integer'])),
            'difficulty_max' => new Constraints\Optional(new Constraints\Type(['type' => 'integer'])),
            'prep_time_min' => new Constraints\Optional(new Constraints\Type(['type' => 'integer'])),
            'prep_time_max' => new Constraints\Optional(new Constraints\Type(['type' => 'integer'])),
            'rate_min' => new Constraints\Optional(new Constraints\Type(['type' => 'integer'])),
            'rate_max' => new Constraints\Optional(new Constraints\Type(['type' => 'integer'])),
            'vegetarian' =>  new Constraints\Optional(new Constraints\Type(['type' => 'boolean'])),
        ]);
    }
}
