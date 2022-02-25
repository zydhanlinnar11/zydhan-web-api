<?php

namespace Tests\Feature;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
    
    public function test_email_password_cant_be_empty()
    {
        $email = $this->faker->email();
        $password = $this->faker->password();

        $response = $this->postJson('/auth/login', ['email' => $email]);
        $response->assertStatus(422);

        $data['name'] = $this->faker->name();
        $response = $this->postJson('/auth/login', ['password' => $password]);
        $response->assertStatus(422);
    }

    public function test_return_401_if_credential_not_match() {
        $email = $this->faker->email();
        $password = $this->faker->password();

        Auth::shouldReceive('attempt')->andReturn(false);

        $response = $this->postJson('/auth/login', [
            'email' => $email,
            'password' => $password
        ]);
        $response->assertStatus(401);
    }

    public function test_can_login() {
        $email = $this->faker->email();
        $password = $this->faker->password();

        Auth::shouldReceive('attempt')->andReturn(true);

        $response = $this->postJson('/auth/login', [
            'email' => $email,
            'password' => $password
        ]);
        $response->assertStatus(200);
    }
}
