<?php

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Database\factories\UserFactory;
use Modules\Auth\Domain\Exceptions\EmailAlreadyExistException;
use Modules\Auth\Domain\Exceptions\UsernameAlreadyExistException;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    private string $name;
    private string $email;
    private string $username;
    private string $password;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $faker = \Faker\Factory::create();
        $this->name = $faker->name();
        $this->email = $faker->email();
        $this->username = $faker->username();
        $this->password = $faker->password();
        $this->user = new User(
            userId: new UserId(),
            name: $this->name,
            email: $this->email,
            username: $this->username,
            hashedPassword: Hash::make($this->password),
            admin: false
        );
    }

    public function testBisaGenerateRandom()
    {
        $userFactory = $this->app->make(UserFactory::class);

        $this->assertInstanceOf(User::class, $userFactory->generateRandom());
    }

    public function testThrowExceptionIfNewUserWithSameEmailExists() {
        $userRepository = Mockery::mock(UserRepositoryInterface::class);

        $userRepository->shouldReceive('findByEmail')
                    ->andReturn($this->user);

        $userFactory = new UserFactory($userRepository);

        $this->expectException(EmailAlreadyExistException::class);
        $userFactory->createNewUser(
            name: $this->name,
            email: $this->email,
            username: $this->username,
            password: $this->password,
        );
    }

    public function testThrowExceptionIfNewUserWithSameUsernameExists() {
        $userRepository = Mockery::mock(UserRepositoryInterface::class);

        $userRepository->shouldReceive('findByEmail')
                    ->andReturn(null);

        $userRepository->shouldReceive('findByUsername')
                    ->andReturn($this->user);

        $userFactory = new UserFactory($userRepository);

        $this->expectException(UsernameAlreadyExistException::class);
        $userFactory->createNewUser(
            name: $this->name,
            email: $this->email,
            username: $this->username,
            password: $this->password,
        );
    }

    public function testCanCreateNewUser() {
        $userRepository = Mockery::mock(UserRepositoryInterface::class);

        $userRepository->shouldReceive('findByEmail')
                    ->andReturn(null);

        $userRepository->shouldReceive('findByUsername')
                    ->andReturn(null);

        $userFactory = new UserFactory($userRepository);

        $user = $userFactory->createNewUser(
            name: $this->name,
            email: $this->email,
            username: $this->username,
            password: $this->password,
        );

        $this->assertInstanceOf(User::class, $user);
    }
}
