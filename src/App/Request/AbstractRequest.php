<?php

namespace App\Request;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AbstractRequest
{
    /**
     * @throws \InvalidArgumentException
     */
    protected function validateInput(array $input, Constraints\Collection $constraints)
    {
        $validator = Validation::createValidator();

        $violations = $validator->validate($input, $constraints);

        if ($violations->count() > 0) {
            $firstViolation = $violations->offsetGet(0);
            throw new BadRequestHttpException(
                sprintf("%s %s", $firstViolation->getPropertyPath(), $firstViolation->getMessage())
            );
        }
    }
}
