<?php
namespace Modules\Auth\Database\factories;

use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Exceptions\EmailAlreadyExistException;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) { }

    public function createNewUser(
        string $name,
        string $email,
        string $password,
    ) : User
    {
        $userWithSameEmail = $this->userRepository->findByEmail($email);
        if ($userWithSameEmail) {
            throw new EmailAlreadyExistException();
        }

        $userId = new UserId();
        $user = new User(
            userId: $userId,
            name: $name,
            email: $email,
            hashedPassword: Hash::make($password),
            admin: false
        );

        return $user;
    }

    public function generateRandom() : User
    {
        $faker = Factory::create();

        return new User(
            userId: new UserId(),
            name: $faker->name(),
            email: $faker->email(),
            admin: $faker->boolean(),
            hashedPassword: Hash::make($faker->password()),
        );
    }
}

