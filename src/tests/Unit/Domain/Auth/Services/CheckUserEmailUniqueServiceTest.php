<?php

use Domain\Auth\Exceptions\EmailAlreadyExistException;
use Domain\Auth\Factories\UserFactory;
use Domain\Auth\Repositories\UserRepositoryInterface;
use Domain\Auth\Services\CheckUserEmailUniqueService;

class CheckUserEmailUniqueServiceTest extends TestCase
{
    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
    }

    public function testThrowEmailAlreadyExistExceptionIfUserEmailIsNotUnique()
    {
        $userFactory = new UserFactory();
        $user = $userFactory->generateRandom();

        $this->userRepository->shouldReceive('findByEmail')
            ->once()
            ->andReturn($user);

        $this->expectException(EmailAlreadyExistException::class);

        $service = new CheckUserEmailUniqueService($this->userRepository);
        $service->execute($user);
    }
}