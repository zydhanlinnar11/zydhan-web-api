<?php

namespace Modules\Auth\Tests\Unit\Domain\Services;

use Modules\Auth\Domain\Exceptions\UsernameAlreadyExistException;
use Modules\Auth\Domain\Factories\UserFactory;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Domain\Services\CheckUserUsernameUniqueService;
use Tests\TestCase;

class CheckUserEmailUniqueServiceTest extends TestCase
{
    public function testThrowExceptionIfThereIsUser()
    {
        $this->expectException(UsernameAlreadyExistException::class);
        $userRepository = $this->mock(UserRepositoryInterface::class);
        $user = (new UserFactory)->generateRandom();
        $userRepository->shouldReceive('findByUsername')
            ->with($user->getUsername())
            ->andReturn($user);

        $this->app->make(CheckUserUsernameUniqueService::class)->execute($user->getUsername());
    }

    public function testSuccessExecuteIfThereIsNoUser()
    {
        $userRepository = $this->mock(UserRepositoryInterface::class);
        $user = (new UserFactory)->generateRandom();
        $userRepository->shouldReceive('findByUsername')
            ->with($user->getUsername())
            ->andReturn(null);

        $res = $this->app->make(CheckUserUsernameUniqueService::class)->execute($user->getUsername());
        $this->assertNull($res);
    }
}
