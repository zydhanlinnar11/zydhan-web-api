<?php

namespace App\Auth\Services\RegisterUser;

use Domain\Auth\Models\Entity\User;
use Domain\Auth\Models\Value\UserId;
use Domain\Auth\Repositories\UserRepositoryInterface;
use Domain\Auth\Services\CheckUserEmailUniqueService;
use Domain\Auth\Services\HashServiceInterface;

class RegisterUserService
{
    public function __construct(        
        private CheckUserEmailUniqueService $checkUserEmailUniqueService,
        private HashServiceInterface $hashService,
        private UserRepositoryInterface $userRepository
    ) { }

    public function execute(RegisterUserRequest $registerUserRequest): void
    {
        $hashedPassword = $this->hashService->generate($registerUserRequest->password);

        $user = new User(
            userId: new UserId(),
            name: $registerUserRequest->name,
            email: $registerUserRequest->email,
            username: $registerUserRequest->username,
            hashedPassword: $hashedPassword
        );

        $this->checkUserEmailUniqueService->execute($user);

        $this->userRepository->create($user);
    }
}