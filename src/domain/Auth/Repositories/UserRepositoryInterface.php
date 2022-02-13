<?php

namespace Domain\Auth\Repositories;

use Domain\Auth\Models\Entity\User;
use Domain\Auth\Models\Value\UserId;

interface UserRepositoryInterface
{
    public function findById(UserId $userId): ?User;
    public function create(User $user): User;
}