<?php

namespace Domain\Auth\Repositories;

use Domain\Auth\Models\Entity\User;
use Domain\Auth\Models\Value\UserId;

interface UserRepository
{
    public function findById(UserId $user): ?User;
    public function create(User $user): User;
}