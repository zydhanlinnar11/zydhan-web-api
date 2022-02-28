<?php

namespace Tests\Feature;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Tests\TestCase;

class DisplayUserInfoTest extends TestCase
{
    use RefreshDatabase;
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
    
    public function test_return401_if_not_authenticated()
    {
        $response = $this->getJson('/auth/user');
        $response->assertStatus(401);
    }
    
    public function test_return_user_resource()
    {
        /**
         * @var UserFactoryInterface $userFactory
         */
        $userFactory = $this->app->make(UserFactoryInterface::class);
        $user = $userFactory->createNewUser(
            name: $this->faker->name(),
            email: $this->faker->email(),
            password: $this->faker->password()
        );

        $this->actingAs($user);
        $response = $this->getJson('/auth/user');
        $response->assertStatus(200);
    }
}
