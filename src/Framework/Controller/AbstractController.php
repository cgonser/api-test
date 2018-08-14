<?php

namespace Framework\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractController
{
    /**
     * @param array|\JsonSerializable $responseData
     * @param int $httpCode
     *
     * @return JsonResponse
     */
    protected function handleSuccess($responseData = [], int $httpCode = 200): JsonResponse
    {
        return new JsonResponse($responseData, $httpCode);
    }

    protected function handleError(string $errorMessage, int $httpCode): JsonResponse
    {
        return new JsonResponse(
            [
                "error" => $errorMessage,
            ],
            $httpCode
        );
    }
}
