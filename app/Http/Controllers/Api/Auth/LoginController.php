<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\Core\User\UserService;
use App\Services\Domain\Auth\Exceptions\IncorrectCredentialsException;
use App\Services\Domain\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LoginController extends BaseController
{
    private UserService $userService;
    private LoginService $loginService;

    public function __construct(UserService $userService, LoginService $loginService)
    {
        $this->userService = $userService;
        $this->loginService = $loginService;
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            $user = $this->userService->findByEmail($email);
            if (!$user instanceof User) {
                return $this->withError('User not found!', Response::HTTP_NOT_FOUND);
            }

            $token = $this->loginService->tokenLogin($email, $password);

            return $this->withSuccess([
                'message' => 'Logged in successfully.',
                'token'   => $token
            ]);
        } catch (IncorrectCredentialsException $e) {
            return $this->withError('Incorrect credentials!', Response::HTTP_UNAUTHORIZED);
        } catch (Throwable $e) {
            Log::error('failed to login', [
                'error_message' => $e->getMessage(),
            ]);

            return $this->withError('Error occurred, please retry later!');
        }
    }
}
