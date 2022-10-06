<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Core\User\UserService;
use App\Services\Domain\User\Exceptions\InvalidTokenException;
use App\Services\Domain\User\VerifyUserService;
use Illuminate\Support\Facades\Log;
use Throwable;

class VerifyController extends Controller
{
    private UserService $userService;
    private VerifyUserService $verifyUserService;

    public function __construct(UserService $userService, VerifyUserService $verifyUserService)
    {
        $this->userService = $userService;
        $this->verifyUserService = $verifyUserService;
    }

    public function __invoke(int $id, string $token)
    {
        try {
            $user = $this->userService->findById($id);
            if (!$user instanceof User) {
                return redirect('/login')
                    ->with('error', 'User not found.');
            }

            $this->verifyUserService->verify($user, $token);

            return redirect('/')
                ->with('success', 'Account has been verified successfully.');
        } catch (InvalidTokenException $e) {
            return redirect('/login')
                ->with('error', 'Token mismatch!');
        } catch (Throwable $e) {
            Log::error('failed to verify user email', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'user_id' => $id,
                'token' => $token,
            ]);

            return redirect('/login')
                ->with('error', 'Failed to verify your email, our team is notified please retry later!');
        }
    }
}
