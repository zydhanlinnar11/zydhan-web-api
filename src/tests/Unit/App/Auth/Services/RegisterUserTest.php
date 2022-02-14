<?php

use App\Auth\Services\RegisterUser\RegisterUserRequest;
use App\Auth\Services\RegisterUser\RegisterUserService;
use Domain\Auth\Factories\UserFactory;
use Domain\Auth\Models\Entity\User;
use Domain\Auth\Models\Value\UserId;
use Domain\Auth\Repositories\UserRepositoryInterface;
use Domain\Auth\Services\CheckUserEmailUniqueService;
use Domain\Auth\Services\HashServiceInterface;
use Faker\Factory;
use Mockery\MockInterface;

class RegisterUserTest extends TestCase
{
    private MockInterface $checkUserEmailUniqueService;
    private MockInterface $hashService;
    private MockInterface $userRepository;
    private RegisterUserService $registerUserService;
    private RegisterUserRequest $registerUserRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkUserEmailUniqueService = Mockery::mock(CheckUserEmailUniqueService::class);
        $this->hashService = Mockery::mock(HashServiceInterface::class);
        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);

        $this->registerUserService = new RegisterUserService(
            $this->checkUserEmailUniqueService,
            $this->hashService,
            $this->userRepository
        );

        $faker = Factory::create();
        $this->registerUserRequest = new RegisterUserRequest(
            name: $faker->name(),
            email: $faker->email(),
            username: $faker->userName(),
            password: $faker->password()
        );
    }

    public function testSuccessExecute() {
        $this->hashService->shouldReceive('generate')
            ->once()->andReturn('test-hasssshhhhhh');

        $this->checkUserEmailUniqueService->shouldReceive('execute')
            ->once();

        $this->userRepository->shouldReceive('create')
            ->once();

        $this->registerUserService->execute($this->registerUserRequest);
    }
}