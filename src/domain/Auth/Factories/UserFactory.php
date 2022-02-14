<?php

namespace Domain\Auth\Factories;

use Domain\Auth\Models\Entity\User;
use Domain\Auth\Models\Value\HashedPassword;
use Domain\Auth\Models\Value\UserId;
use Faker\Factory;

class UserFactory
{
    public static function generateRandom() : User
    {
        $faker = Factory::create();

        return new User(
            userId: new UserId(),
            name: $faker->name(),
            email: $faker->email(),
            username: $faker->userName(),
            admin: $faker->boolean(),
            newPassword: new HashedPassword($faker->password()),
        );
    }
}
