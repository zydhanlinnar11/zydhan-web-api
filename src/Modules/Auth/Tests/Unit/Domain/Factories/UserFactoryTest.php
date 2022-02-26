<?php

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Database\factories\UserFactory;
use Modules\Auth\Domain\Exceptions\EmailAlreadyExistException;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    private string $name;
    private string $email;
    private string $password;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $faker = \Faker\Factory::create();
        $this->name = $faker->name();
        $this->email = $faker->email();
        $this->password = $faker->password();
        $this->user = new User(
            userId: new UserId(),
            name: $this->name,
            email: $this->email,
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
            password: $this->password,
        );
    }

    public function testCanCreateNewUser() {
        $userRepository = Mockery::mock(UserRepositoryInterface::class);

        $userRepository->shouldReceive('findByEmail')
                    ->andReturn(null);

        $userFactory = new UserFactory($userRepository);

        $user = $userFactory->createNewUser(
            name: $this->name,
            email: $this->email,
            password: $this->password,
        );

        $this->assertInstanceOf(User::class, $user);
    }
}
