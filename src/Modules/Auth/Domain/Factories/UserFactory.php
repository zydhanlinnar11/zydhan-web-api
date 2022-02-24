<?php

namespace Modules\Auth\Domain\Factories;

use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;

class UserFactory
{

    public function generateRandom() : User
    {
        $faker = Factory::create();

        return new User(
            userId: new UserId(),
            name: $faker->name(),
            email: $faker->email(),
            username: $faker->userName(),
            admin: $faker->boolean(),
            hashedPassword: Hash::make($faker->password()),
        );
    }
}
