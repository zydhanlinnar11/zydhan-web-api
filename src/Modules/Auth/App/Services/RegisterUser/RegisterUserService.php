<?php

namespace Modules\Auth\App\Services\RegisterUser;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Domain\Services\CheckUserEmailUniqueService;

class RegisterUserService
{
    public function __construct(        
        private CheckUserEmailUniqueService $checkUserEmailUniqueService,
        private UserRepositoryInterface $userRepository
    ) { }

    public function execute(RegisterUserRequest $registerUserRequest): void
    {
        $hashedPassword = Hash::make($registerUserRequest->password);

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