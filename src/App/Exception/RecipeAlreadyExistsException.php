<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class RecipeAlreadyExistsException extends ConflictHttpException
{
    const MESSAGE = 'Another recipe already exists with the same name';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
