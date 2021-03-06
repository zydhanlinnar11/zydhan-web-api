<?php

namespace Modules\Auth\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

class UserProvider implements \Illuminate\Contracts\Auth\UserProvider
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) { }

    public function retrieveById($identifier)
    {
        try {
            $user = $this->userRepository->findById(new UserId($identifier));
            return $user;
        } catch(\Exception $e) {
            return null;
        }
    }

    public function retrieveByToken($identifier, $token)
    {
        try {
            $user = $this->userRepository->findById(new UserId($identifier));

            if (!$user) {
                return null;
            }

            $rememberToken = $user->getRememberToken();

            return $rememberToken && hash_equals($rememberToken, $token)
                        ? $user : null;
        } catch(\Exception $e) {
            return null;
        }
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);

        $this->userRepository->save($user);

        return null;
    }

    public function retrieveByCredentials(array $credentials)
    {
        try {
            $email = $credentials['email'];
            $user = $this->userRepository->findByEmail($email);
            return $user;
        } catch(\Exception $e) {
            return null;
        }
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return Hash::check($credentials['password'], $user->getAuthPassword());
    }
}
