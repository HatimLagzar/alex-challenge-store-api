<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    public function withSuccess(array $payload, int $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($payload, $status);
    }

    public function withError(string $errorMessage, int $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return new JsonResponse([
            'message' => $errorMessage
        ], $status);
    }
}