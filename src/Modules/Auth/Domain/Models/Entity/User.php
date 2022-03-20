<?php

namespace Modules\Auth\Domain\Models\Entity;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Modules\Auth\Domain\Exceptions\AccountAlreadyLinkedException;
use Modules\Auth\Domain\Exceptions\AccountNotLinkedException;
use Modules\Auth\Domain\Models\Value\SocialId;
use Modules\Auth\Domain\Models\Value\SocialProvider;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Notifications\ResetPasswordNotification;

class User implements Authenticatable, CanResetPassword
{
    use Notifiable;

    public function __construct(
        private UserId $userId,
        private string $name,
        private string $email,
        private string $hashedPassword,
        private bool $admin = false,
        private ?string $rememberToken = NULL,
        private ?SocialId $googleId = NULL,
        private ?SocialId $githubId = NULL,
        private ?string $avatarUrl = NULL,
    ) {
        if (($googleId && ($googleId->getSocialProvider() !== SocialProvider::GOOGLE))
            || ($githubId && $githubId->getSocialProvider() !== SocialProvider::GITHUB)) {
            throw new InvalidArgumentException("social_provider_doesn't_match");
        }
    }

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
        $isGoogleIdEqual = $user->getGoogleId()?->getId() === $this->getGoogleId()?->getId();
        $isGithubIdEqual = $user->getGithubId()?->getId() === $this->getGithubId()?->getId();

        return ($userIdEqual && $nameEqual && $emailEqual && $isAdminEqual && $isGithubIdEqual && $isGoogleIdEqual);
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

    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    public function changeEmail(string $email): void
    {
        $this->email = $email;
    }

    public function changePassword(string $password): void
    {
        $this->hashedPassword = Hash::make($password);
    }

    public function linkGoogleAccount(string $googleId): void
    {
        if($this->googleId) {
            throw new AccountAlreadyLinkedException();
        }
        $this->googleId = new SocialId($googleId, SocialProvider::GOOGLE);
    }

    public function linkGithubAccount(string $githubId): void
    {
        if($this->githubId) {
            throw new AccountAlreadyLinkedException();
        }
        $this->githubId = new SocialId($githubId, SocialProvider::GITHUB);
    }

    public function unlinkGoogleAccount(): void
    {
        if(!$this->googleId) {
            throw new AccountNotLinkedException();
        }
        $this->googleId = null;
    }

    public function unlinkGithubAccount(): void
    {
        if(!$this->githubId) {
            throw new AccountNotLinkedException();
        }
        $this->githubId = null;        
    }

    public function getEmailForPasswordReset()
    {
        return $this->getEmail();
    }

    public function sendPasswordResetNotification($token)
    {
        $url = 'https://'. env('APP_NAME', 'zydhan.xyz')
            .'/auth/reset-password?token='.urlencode($token)
            .'&email='.urlencode($this->getEmailForPasswordReset());
 
        $this->notify(new ResetPasswordNotification($url));
    }

    public function getAvatar(): ?string
    {
        return $this->avatarUrl;
    }
}
