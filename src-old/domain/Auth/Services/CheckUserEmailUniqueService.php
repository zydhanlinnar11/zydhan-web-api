<?php

namespace Domain\Auth\Services;

use Domain\Auth\Exceptions\EmailAlreadyExistException;
use Domain\Auth\Models\Entity\User;
use Domain\Auth\Repositories\UserRepositoryInterface;

class CheckUserEmailUniqueService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) { }

    public function execute(User $user) : void
    {
        $existingUser = $this->userRepository->findByEmail($user->getEmail());

        if ($existingUser) {
            throw new EmailAlreadyExistException();
        }
    }
}