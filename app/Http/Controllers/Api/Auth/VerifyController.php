<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Core\User\UserService;
use App\Services\Domain\User\Exceptions\InvalidTokenException;
use App\Services\Domain\User\VerifyUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class VerifyController extends BaseController
{
    private UserService $userService;
    private VerifyUserService $verifyUserService;

    public function __construct(UserService $userService, VerifyUserService $verifyUserService)
    {
        $this->userService = $userService;
        $this->verifyUserService = $verifyUserService;
    }

    public function __invoke(int $id, string $token): JsonResponse
    {
        try {
            $user = $this->userService->findById($id);
            if (!$user instanceof User) {
                return $this->withError('User not found!', Response::HTTP_NOT_FOUND);
            }

            $this->verifyUserService->verify($user, $token);

            return $this->withSuccess([
                'message' => 'Account has been verified successfully.'
            ]);
        } catch (InvalidTokenException $e) {
            return $this->withError('Token mismatch!', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $e) {
            Log::error('failed to verify user email', [
                'error_message' => $e->getMessage(),
                'user_id'       => $id,
                'token'         => $token,
            ]);

            return $this->withError('Error occurred, please retry later!');
        }
    }
}
