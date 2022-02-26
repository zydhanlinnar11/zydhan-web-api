<?php

namespace Modules\Auth\App\Services\RegisterUser;

use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

class RegisterUserService
{
    public function __construct(        
        private UserFactoryInterface $userFactory,
        private UserRepositoryInterface $userRepository,
    ) { }

    public function execute(RegisterUserRequest $registerUserRequest): void
    {
        $user = $this->userFactory->createNewUser(
            $registerUserRequest->name,
            $registerUserRequest->email,
            $registerUserRequest->password
        );

        $this->userRepository->create($user);
    }
}