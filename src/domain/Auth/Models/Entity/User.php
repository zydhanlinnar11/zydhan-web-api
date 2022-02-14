<?php

namespace Domain\Auth\Models\Entity;

use Domain\Auth\Models\Value\UserId;

class User
{
    public function __construct(
        private UserId $userId,
        private string $name,
        private string $email,
        private string $username,
        private bool $admin,
        private string $hashedPassword,
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

    public function getHashedPassword(): ?string
    {
        return $this->hashedPassword;
    }

    public function getUsername(): string
    {
        return $this->username;
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
        $usernameEqual = $user->getUsername() === $this->getUsername();
        $isAdminEqual = $user->isAdmin() === $this->isAdmin();

        return ($userIdEqual && $nameEqual && $emailEqual && $usernameEqual && $isAdminEqual);
    }
}
