<?php

namespace Modules\Auth\Domain\Repositories;

use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\SocialId;
use Modules\Auth\Domain\Models\Value\UserId;

interface UserRepositoryInterface
{
    public function findById(UserId $userId): ?User;
    public function findByEmail(string $email): ?User;
    public function findBySocialId(SocialId $socialId): ?User;
    public function save(User $user): ?User;
}