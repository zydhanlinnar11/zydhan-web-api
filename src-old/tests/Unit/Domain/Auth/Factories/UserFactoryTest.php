<?php

use Domain\Auth\Factories\UserFactory;
use Domain\Auth\Models\Entity\User;

class UserFactoryTest extends TestCase
{
    public function testBisaGenerateRandom()
    {
        $userFactory = $this->app->make(UserFactory::class);

        $this->assertInstanceOf(User::class, $userFactory->generateRandom());
    }
}
