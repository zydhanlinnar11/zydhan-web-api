<?php

namespace Tests\Feature;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Entity\User;
use Tests\TestCase;

class ChangeUserPasswordTest extends TestCase
{
    use RefreshDatabase;
    private Generator $faker;
    private User $user;
    private string $current_password;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->current_password = $this->faker->password();
        /**
         * @var UserFactoryInterface $userFactory
         */
        $userFactory = $this->app->make(UserFactoryInterface::class);
        $this->user = $userFactory->createNewUser(
            name: $this->faker->name(),
            email: $this->faker->email(),
            password: $this->current_password
        );
    }
    
    public function test_return401_if_not_authenticated()
    {
        $response = $this->patchJson('/auth/user/change-password');
        $response->assertStatus(401);
    }
    
    public function test_return403_current_password_doesnt_match()
    {
        $this->actingAs($this->user);
        $response = $this->patchJson('/auth/user/change-password', [
            'current_password' => $this->faker->password(),
            'new_password' => $this->faker->password(),
            'new_password_confirmation' => $this->faker->password(),
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('current_password');
    }
    
    public function test_new_password_cant_be_empty()
    {
        $this->actingAs($this->user);
        $response = $this->patchJson('/auth/user/change-password', [
            'current_password' => $this->current_password
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('new_password');
        $response->assertJsonValidationErrorFor('new_password_confirmation');
    }
    
    public function test_confirmed_password_should_match()
    {
        $this->actingAs($this->user);
        $new_password = $this->faker->password();
        $response = $this->patchJson('/auth/user/change-password', [
            'current_password' => $this->current_password,
            'new_password' => $new_password,
            'new_password_confirmation' => $new_password . $this->faker->password(),
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('new_password');
    }
    
    public function test_can_change_password()
    {
        $this->actingAs($this->user);
        $new_password = $this->faker->password();
        $response = $this->patchJson('/auth/user/change-password', [
            'current_password' => $this->current_password,
            'new_password' => $new_password,
            'new_password_confirmation' => $new_password,
        ]);
        $response->assertStatus(200);
    }
}
