<?php

namespace Infrastructure\Auth\Repositories;

use DateTime;
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
            hashedPassword: $result->password,
        );
    }

    public function create(User $user): User
    {
        $data = $this->userDataToArray($user);
        $data = array_merge($data, ['created_at' => $data['updated_at']]);

        DB::table('users')->insert($data);

        return $user;
    }

    private function userDataToArray(User $user) {
        $data = [
            'id' => $user->getUserId()->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'is_admin' => $user->isAdmin(),
            'password' => $user->getHashedPassword(),
            'updated_at' => new DateTime()
        ];

        return $data;
    }
}