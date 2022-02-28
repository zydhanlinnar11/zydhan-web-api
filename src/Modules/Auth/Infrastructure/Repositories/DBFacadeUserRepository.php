<?php

namespace Modules\Auth\Infrastructure\Repositories;

use DateTime;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Models\Value\SocialId;
use Modules\Auth\Domain\Models\Value\SocialProvider;

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

    public function save(User $user): ?User
    {
        $data = $this->userDataToArray($user);

        if (!$this->findById($user->getUserId())) {
            $data = array_merge($data, ['created_at' => $data['updated_at']]);
        }

        DB::table('users')->updateOrInsert(
            ['id' => $user->getUserId()->getId()],
            $data
        );

        return $user;
    }

    private function userDataToArray(User $user) {
        $data = [
            'id' => $user->getUserId()->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'is_admin' => $user->isAdmin(),
            'password' => $user->getAuthPassword(),
            'remember_token' => $user->getRememberToken(),
            'google_id' => $user->getGoogleId()?->getId(),
            'github_id' => $user->getGithubId()?->getId(),
            'updated_at' => new DateTime()
        ];

        return $data;
    }

    private function mapDBResultToModel(object $result): User {
        return new User(
            userId: new UserId($result->id),
            name: $result->name,
            email: $result->email,
            admin: $result->is_admin,
            hashedPassword: $result->password,
            rememberToken: $result->remember_token,
            googleId: !$result->google_id ? null : new SocialId($result->google_id, SocialProvider::GOOGLE),
            githubId: !$result->github_id ? null : new SocialId($result->github_id, SocialProvider::GITHUB),
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

    public function findBySocialId(SocialId $socialId): ?User
    {
        $result = DB::table('users')->where($socialId->getSocialProvider()->name() . '_id', '=', $socialId->getId())->first();
        
        if (!$result) {
            return null;
        }

        return $this->mapDBResultToModel($result);
    }
}