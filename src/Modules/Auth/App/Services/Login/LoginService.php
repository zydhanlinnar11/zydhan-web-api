<?php

namespace Modules\Auth\App\Services\Login;

use Modules\Auth\App\Exceptions\UserNotFoundException;
use Modules\Auth\App\Exceptions\WrongPasswordException;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

class LoginService
{
    public function __construct(        
        private UserRepositoryInterface $userRepository
    ) { }

    public function execute(LoginRequest $loginRequest): User
    {
        $user = $this->userRepository->findByEmail($loginRequest->email);
        if(!$user) {
            throw new UserNotFoundException();
        }

        $isPasswordCorrect = $user->isPasswordCorrect($loginRequest->password);

        if (!$isPasswordCorrect) {
            throw new WrongPasswordException();
        }

        return $user;
    }
}