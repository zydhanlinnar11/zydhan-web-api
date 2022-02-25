<?php

use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;
use Modules\Auth\App\Services\RegisterUser\RegisterUserRequest;
use Modules\Auth\App\Services\RegisterUser\RegisterUserService;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Tests\TestCase;

class RegisterUserServiceTest extends TestCase
{
    private MockInterface $userFactory;
    private MockInterface $userRepository;
    private RegisterUserRequest $registerUserRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = Mockery::mock(UserFactoryInterface::class);
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
        $user = new User(
            userId: new UserId(),
            name: $this->registerUserRequest->name,
            email: $this->registerUserRequest->email,
            username: $this->registerUserRequest->username,
            hashedPassword: Hash::make($this->registerUserRequest->password),
            admin: false
        );
        $this->userFactory->shouldReceive('createNewUser')
            ->andReturn($user);
        $this->userRepository->shouldReceive('create')->with($user);

        $registerUserService = new RegisterUserService(
            $this->userFactory,
            $this->userRepository
        );
        $registerUserService->execute($this->registerUserRequest);
    }
}