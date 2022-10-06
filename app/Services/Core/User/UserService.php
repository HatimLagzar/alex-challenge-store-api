<?php

namespace App\Services\Core\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Arr;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findById(string $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function update(User $user, array $attributes): bool
    {
        return $this->userRepository->update($user->getId(), $attributes);
    }

    public function create(array $attributes): User
    {
        $attributes = Arr::only($attributes, [
            User::NAME_COLUMN,
            User::EMAIL_COLUMN,
            User::PASSWORD_COLUMN,
            User::VERIFICATION_TOKEN_COLUMN,
        ]);

        return $this->userRepository->create($attributes);
    }
}