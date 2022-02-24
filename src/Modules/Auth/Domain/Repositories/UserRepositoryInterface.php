<?php

namespace Modules\Auth\Domain\Repositories;

use Modules\Auth\Domain\Models\Entity\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function findByUsername(string $username): ?User;
    public function create(User $user): User;
}