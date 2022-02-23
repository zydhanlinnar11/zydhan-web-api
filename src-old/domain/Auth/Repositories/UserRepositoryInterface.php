<?php

namespace Domain\Auth\Repositories;

use Domain\Auth\Models\Entity\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function create(User $user): User;
}