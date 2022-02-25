<?php

namespace Modules\Auth\Domain\Services;

use Modules\Auth\Domain\Exceptions\UsernameAlreadyExistException;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

class CheckUserUsernameUniqueService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) { }

    public function execute(string $username) : void
    {
        $existingUser = $this->userRepository->findByUsername($username);

        if ($existingUser) {
            throw new UsernameAlreadyExistException();
        }
    }
}