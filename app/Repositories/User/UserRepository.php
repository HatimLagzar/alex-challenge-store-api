<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    public function findById(string $id): ?User
    {
        return User::query()
            ->where(User::ID_COLUMN, $id)
            ->first();
    }

    public function findByEmail(string $email): ?User
    {
        return User::query()
            ->where(User::EMAIL_COLUMN, $email)
            ->first();
    }

    public function update(string $id, array $attributes): bool
    {
        return User::query()
            ->where(User::ID_COLUMN, $id)
            ->update($attributes) > 0;
    }

    public function create(array $attributes): User
    {
        return User::query()
            ->create($attributes);
    }
}