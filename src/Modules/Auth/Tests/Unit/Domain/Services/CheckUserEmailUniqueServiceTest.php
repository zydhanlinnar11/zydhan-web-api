<?php

namespace Modules\Auth\Tests\Unit\Domain\Services;

use Modules\Auth\Domain\Exceptions\EmailAlreadyExistException;
use Modules\Auth\Domain\Factories\UserFactory;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Domain\Services\CheckUserEmailUniqueService;
use Tests\TestCase;

class CheckUserEmailUniqueServiceTest extends TestCase
{
    public function testThrowExceptionIfThereIsUser()
    {
        $this->expectException(EmailAlreadyExistException::class);
        $userRepository = $this->mock(UserRepositoryInterface::class);
        $user = (new UserFactory)->generateRandom();
        $userRepository->shouldReceive('findByEmail')
            ->with($user->getUsername())
            ->andReturn($user);

        $this->app->make(CheckUserEmailUniqueService::class)->execute($user->getUsername());
    }

    public function testSuccessExecuteIfThereIsNoUser()
    {
        $userRepository = $this->mock(UserRepositoryInterface::class);
        $user = (new UserFactory)->generateRandom();
        $userRepository->shouldReceive('findByEmail')
            ->with($user->getUsername())
            ->andReturn(null);

        $res = $this->app->make(CheckUserEmailUniqueService::class)->execute($user->getUsername());
        $this->assertNull($res);
    }
}
