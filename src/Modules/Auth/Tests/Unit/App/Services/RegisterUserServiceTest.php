<?php

use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Services\RegisterUser\RegisterUserRequest;
use Modules\Auth\App\Services\RegisterUser\RegisterUserService;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Tests\TestCase;

class RegisterUserServiceTest extends TestCase
{
    private UserRepositoryInterface $userRepository;
    private RegisterUserRequest $registerUserRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);

        $faker = Factory::create();
        $this->registerUserRequest = new RegisterUserRequest(
            name: $faker->name(),
            email: $faker->email(),
            username: $faker->userName(),
            password: $faker->password()
        );
    }

    public function testSuccessExecute() {
        $registerUserService = new RegisterUserService(
            $this->userRepository
        );
        $registerUserService->execute($this->registerUserRequest);
    }
}