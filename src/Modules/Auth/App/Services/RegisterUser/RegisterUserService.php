<?php

namespace Modules\Auth\App\Services\RegisterUser;

use Modules\Auth\Domain\Factories\UserFactory;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

class RegisterUserService
{
    public function __construct(        
        private UserRepositoryInterface $userRepository
    ) { }

    public function execute(RegisterUserRequest $registerUserRequest): void
    {
        $userFactory = new UserFactory($this->userRepository);

        $user = $userFactory->createNewUser(
            $registerUserRequest->name,
            $registerUserRequest->email,
            $registerUserRequest->username,
            $registerUserRequest->password
        );

        $this->userRepository->create($user);
    }
}