<?php

namespace Tests\Feature;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;
    private Generator $faker;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        /**
         * @var UserFactoryInterface $userFactory
         */
        $userFactory = $this->app->make(UserFactoryInterface::class);
        $this->user = $userFactory->createNewUser(
            name: $this->faker->name(),
            email: $this->faker->email(),
            password: $this->faker->password()
        );
        /**
         * @var UserRepositoryInterface $userRepository
         */
        $userRepository = $this->app->make(UserRepositoryInterface::class);
        $userRepository->save($this->user);
    }
    
    public function test_email_cant_be_empty()
    {
        $this->actingAs($this->user);
        $response = $this->postJson('/auth/user/forgot-password');
        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('email');
    }

    public function test_can_reset_password()
    {
        $this->actingAs($this->user);
        $response = $this->postJson('/auth/user/forgot-password', [
            'email' => $this->user->getEmail()
        ]);
        var_dump(DB::table('password_resets')->get());
        $response->assertStatus(200);
    }
}
