<?php

namespace Tests\Feature;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
    
    public function test_name_email_username_password_passconfirm_cant_be_empty()
    {
        $password = $this->faker->password();
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'username' => $this->faker->username(),
            'password' => $password,
            'password_confirmation' => $password
        ];

        unset($data['name']);
        $response = $this->postJson('/api/auth/register', $data);
        $response->assertStatus(422);

        unset($data['email']);
        $data['name'] = $this->faker->name();
        $response = $this->postJson('/api/auth/register', $data);
        $response->assertStatus(422);

        unset($data['username']);
        $data['email'] = $this->faker->email();
        $response = $this->postJson('/api/auth/register', $data);
        $response->assertStatus(422);

        unset($data['password']);
        $data['username'] = $this->faker->username();
        $response = $this->postJson('/api/auth/register', $data);
        $response->assertStatus(422);

        unset($data['password_confirmation']);
        $data['password'] = $this->faker->password();
        $response = $this->postJson('/api/auth/register', $data);
        $response->assertStatus(422);
    }

    public function test_password_confirmation_must_match() {
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'username' => $this->faker->username(),
            'password' => 'pass',
            'password_confirmation' => 'pass_different'
        ];

        $response = $this->postJson('/api/auth/register', $data);
        $response->assertStatus(422);
    }

    public function test_can_create_user() {
        $password = $this->faker->password();
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'username' => $this->faker->username(),
            'password' => $password,
            'password_confirmation' => $password
        ];

        $response = $this->postJson('/api/auth/register', $data);
        var_dump($response->decodeResponseJson());
        $response->assertStatus(201);
    }
}