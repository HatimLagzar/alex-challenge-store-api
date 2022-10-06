<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Domain\Auth\Exceptions\EmailAlreadyInUseException;
use App\Services\Domain\Auth\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RegisterController extends BaseController
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {
            $this->registerService->register(
                $request->input('name'),
                $request->input('email'),
                $request->input('password'),
            );

            return $this->withSuccess([
                'message' => 'Account created successfully.'
            ], Response::HTTP_CREATED);
        } catch (EmailAlreadyInUseException $e) {
            return $this->withError(
                'Email already used, choose another email or recover your account!',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $e) {
            Log::error('failed to register', [
                'error_message' => $e->getMessage(),
                'error_trace'   => $e->getTraceAsString(),
                'email'         => $request->input('email'),
            ]);

            return $this->withError('Internal error occurred while registering, please retry later!');
        }
    }
}
