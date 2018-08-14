<?php

namespace App\Request;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\HttpFoundation\ParameterBag;

class RecipeRatingRequest extends AbstractRequest
{
    /**
     * @var Uuid
     */
    public $id;

    /**
     * @var integer
     */
    public $rate;

    public static function fromRequest(string $id, ParameterBag $parameterBag): self
    {
        $parameterBag->set('id', $id);

        $request = new self();
        $request->validateInput((array) $parameterBag->all(), $request->getConstraints());
        $request->id = Uuid::fromString($parameterBag->get('id'));
        $request->rate = $parameterBag->get('rate');

        return $request;
    }

    protected function getConstraints()
    {
        return new Constraints\Collection([
            'id' => new Constraints\Uuid(),
            'rate' => [
                new Constraints\Type(['type' => 'integer']),
                new Constraints\Range(['min' => 1, 'max' => 5]),
            ],
        ]);
    }
}
