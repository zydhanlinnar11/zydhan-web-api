<?php

namespace Domain\Auth\Models\Entity;

use Domain\Auth\Models\Value\UserId;

class User
{
    public function __construct(
        private UserId $userId,
        private string $name,
        private string $email,
        private string $password,
        private string $username,
        private bool $admin,
    ) { }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function equals(User $user): bool
    {
        $userIdEqual = $user->getUserId()->equals($this->getUserId());
        $nameEqual = $user->getName() === $this->getName();
        $emailEqual = $user->getEmail() === $this->getEmail();
        $passwordEqual = $user->getPassword() === $this->getPassword();
        $usernameEqual = $user->getUsername() === $this->getUsername();
        $isAdminEqual = $user->isAdmin() === $this->isAdmin();

        return ($userIdEqual && $nameEqual && $emailEqual
            && $passwordEqual && $usernameEqual && $isAdminEqual);
    }
}
