<?php

namespace App\Services\Domain\Auth;

use App\Models\User;
use App\Services\Domain\Auth\Exceptions\IncorrectCredentialsException;

use function auth;

class LoginService
{
    /**
     * @throws IncorrectCredentialsException
     */
    public function tokenLogin(string $email, string $password): string
    {
        $token = auth()->guard('api')->attempt([
            'email'    => $email,
            'password' => $password,
        ]);

        if ($token === false) {
            throw new IncorrectCredentialsException();
        }

        return $token;
    }

    public function login(string $email, string $password): bool
    {
        return auth()->attempt(
            [
                User::EMAIL_COLUMN    => $email,
                User::PASSWORD_COLUMN => $password,
                User::ROLE_COLUMN     => User::ADMIN_ROLE,
            ],
            true
        );
    }
}
