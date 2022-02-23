<?php

use Modules\Auth\Domain\Factories\UserFactory;
use Modules\Auth\Domain\Models\Entity\User;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    public function testBisaGenerateRandom()
    {
        $userFactory = $this->app->make(UserFactory::class);

        $this->assertInstanceOf(User::class, $userFactory->generateRandom());
    }
}
