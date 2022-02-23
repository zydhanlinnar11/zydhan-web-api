<?php

namespace Modules\Auth\Domain\Services;

use Modules\Auth\Domain\Exceptions\EmailAlreadyExistException;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

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