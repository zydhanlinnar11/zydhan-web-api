<?php

use Faker\Factory;
use Modules\Auth\App\Services\RegisterUser\RegisterUserRequest;
use Modules\Auth\App\Services\RegisterUser\RegisterUserService;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Domain\Services\CheckUserEmailUniqueService;
use Modules\Auth\Domain\Services\HashServiceInterface;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    private CheckUserEmailUniqueService $checkUserEmailUniqueService;
    private HashServiceInterface $hashService;
    private UserRepositoryInterface $userRepository;
    private RegisterUserService $registerUserService;
    private RegisterUserRequest $registerUserRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->checkUserEmailUniqueService = Mockery::mock(CheckUserEmailUniqueService::class);
        $this->hashService = Mockery::mock(HashServiceInterface::class);
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
        $this->hashService->shouldReceive('generate')
            ->once()->andReturn('test-hasssshhhhhh');

        $this->checkUserEmailUniqueService->shouldReceive('execute')
            ->once();

        $this->userRepository->shouldReceive('create')
            ->once();

        $registerUserService = new RegisterUserService(
            $this->checkUserEmailUniqueService,
            $this->hashService,
            $this->userRepository
        );
        $registerUserService->execute($this->registerUserRequest);
    }
}