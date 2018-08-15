<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipeNotFoundException extends NotFoundHttpException
{
    const MESSAGE = 'Recipe not found';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
