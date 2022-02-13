<?php

namespace Domain\Auth\Repositories;

use Domain\Auth\Models\Entity\User;

interface UserRepository
{
    public function create(User $user): User;
}