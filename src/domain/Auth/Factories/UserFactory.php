<?php

namespace Domain\Auth\Factories;

use Domain\Auth\Models\Entity\User;
use Domain\Auth\Models\Value\UserId;
use Domain\Auth\Services\GenerateHashServiceInterface;
use Faker\Factory;

class UserFactory
{
    public function __construct(
        private GenerateHashServiceInterface $generateHashService
    ) { }

    public function generateRandom() : User
    {
        $faker = Factory::create();

        return new User(
            userId: new UserId(),
            name: $faker->name(),
            email: $faker->email(),
            username: $faker->userName(),
            admin: $faker->boolean(),
            hashedPassword: $this->generateHashService->generate($faker->password()),
        );
    }
}
