<?php

use Domain\Auth\Models\Value\HashedPassword;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;

class HashedPasswordTest extends TestCase
{
    public function testMelakukanHashing()
    {
        $faker = Factory::create();
        $password = $faker->password();
        $hashedPassword = Hash::make($password);
        
        Hash::shouldReceive('make')
            ->once()
            ->andReturn($hashedPassword);

        $this->assertTrue($hashedPassword === (new HashedPassword($password))->getHashedPassword());
    }
}
