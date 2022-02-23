<?php

namespace Modules\Auth\Domain\Factories;

use Faker\Factory;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Services\HashServiceInterface;

class UserFactory
{
    public function __construct(
        private HashServiceInterface $generateHashService
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
