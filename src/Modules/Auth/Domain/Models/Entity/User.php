<?php

namespace Modules\Auth\Domain\Models\Entity;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Models\Value\UserId;

class User implements Authenticatable
{
    public function __construct(
        private UserId $userId,
        private string $name,
        private string $email,
        private string $hashedPassword,
        private bool $admin = false,
        private ?string $rememberToken = NULL,
    ) { }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function equals(User $user): bool
    {
        $userIdEqual = $user->getUserId()->equals($this->getUserId());
        $nameEqual = $user->getName() === $this->getName();
        $emailEqual = $user->getEmail() === $this->getEmail();
        $isAdminEqual = $user->isAdmin() === $this->isAdmin();

        return ($userIdEqual && $nameEqual && $emailEqual && $isAdminEqual);
    }

    public function isPasswordCorrect(string $password): bool
    {
        return Hash::check($password, $this->hashedPassword);
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): string
    {
        return $this->getUserId()->getId();
    }

    public function getAuthPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function getRememberTokenName(): string
    {
        return '';
    }

    public function setRememberToken($value)
    {
        $this->rememberToken = $value;
    }

    public function getGoogleId(): ?SocialId
    {
        return $this->googleId;
    }

    public function getGithubId(): ?SocialId
    {
        return $this->githubId;
    }
}
