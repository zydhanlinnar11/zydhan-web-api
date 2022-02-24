<?php

namespace Modules\Auth\Infrastructure\Repositories;

use DateTime;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DBFacadeUserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        $result = DB::table('users')->where('email', $email)->first();
        
        if (!$result) {
            return null;
        }

        return $this->mapDBResultToModel($result);
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

    public function findByUsername(string $username): ?User
    {
        $result = DB::table('users')->where('username', $username)->first();
        
        if (!$result) {
            return null;
        }

        return $this->mapDBResultToModel($result);
    }

    private function mapDBResultToModel(object $result): User {
        return new User(
            userId: new UserId($result->id),
            name: $result->name,
            email: $result->email,
            username: $result->username,
            admin: $result->is_admin,
            hashedPassword: $result->password,
        );
    }

    public function findById(UserId $userId): ?User
    {
        $result = DB::table('users')->where('id', $userId->getId())->first();
        
        if (!$result) {
            return null;
        }

        return $this->mapDBResultToModel($result);
    }
}