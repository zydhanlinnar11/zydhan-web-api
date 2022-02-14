<?php

namespace App\Auth\Repositories;

use App\Auth\Exceptions\EmailAlreadyExistException;
use Domain\Auth\Models\Entity\User;
use Domain\Auth\Models\Value\UserId;
use Domain\Auth\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        $result = DB::table('users')->where('email', $email)->first();
        
        if (!$result) {
            return null;
        }

        return new User(
            userId: new UserId($result->id),
            name: $result->name,
            email: $result->email,
            username: $result->username,
            admin: $result->is_admin,
        );
    }

    public function create(User $user): User
    {
        $existingUser = $this->findByEmail($user->getEmail());

        if ($existingUser) {
            throw new EmailAlreadyExistException('user_with_that_email_is_already_exists');
        }

        DB::table('users')->insert($this->userDataToArray($user));

        // Return without new password
        return new User(
            userId: $user->getUserId(),
            name: $user->getName(),
            email: $user->getEmail(),
            username: $user->getUsername(),
            admin: $user->isAdmin(),
        );
    }

    private function userDataToArray(User $user) {
        $data = [
            'id' => $user->getUserId()->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'is_admin' => $user->isAdmin(),
        ];

        $newPassword = $user->getNewPassword();

        if ($newPassword) {
            $data = array_merge($data, ['password' => $newPassword->getHashedPassword()]);
        }

        return $data;
    }
}