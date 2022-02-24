<?php

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserTest extends TestCase
{
    private UserId $userId;
    private string $name;
    private string $email;
    private string $hashedPassword;
    private string $username;
    private bool $isAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userId = new UserId(Uuid::uuid4());
        $faker = \Faker\Factory::create();
        $this->name = $faker->name();
        $this->email = $faker->email();
        $this->hashedPassword = Hash::make($faker->password());
        $this->username = $faker->userName();
        $this->isAdmin = $faker->boolean();
    }

    public function testBisaDiinstansiasi()
    {
        $user = new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
            username: $this->username,
            admin: $this->isAdmin
        );

        $this->assertInstanceOf(User::class, $user);
    }

    public function testBisaFungsiEqualsBekerja() {
        $user = new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
            username: $this->username,
            admin: $this->isAdmin
        );

        $this->assertTrue($user->equals($user));
        
        $faker = \Faker\Factory::create();
        $this->assertNotTrue($user->equals(new User(
            userId: new UserId(Uuid::uuid4()),
            name: $faker->name(),
            email: $faker->email(),
            hashedPassword: Hash::make($faker->password()),
            username: $faker->userName(),
            admin: $faker->boolean()
        )));
    }

    public function testBisaGetUserId()
    {
        $this->assertTrue((new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
            username: $this->username,
            admin: $this->isAdmin
        ))->getUserId()->equals($this->userId));
    }

    public function testBisaGetName()
    {
        $this->assertTrue((new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
            username: $this->username,
            admin: $this->isAdmin
        ))->getName() === $this->name);
    }

    public function testBisaGetEmail()
    {
        $this->assertTrue((new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
            username: $this->username,
            admin: $this->isAdmin
        ))->getEmail() === $this->email);
    }

    public function testBisaGetUsername()
    {
        $this->assertTrue((new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
            username: $this->username,
            admin: $this->isAdmin
        ))->getUsername() === $this->username);
    }

    public function testBisaGetStatusAdmin()
    {
        $this->assertTrue((new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
            username: $this->username,
            admin: $this->isAdmin
        ))->isAdmin() === $this->isAdmin);
    }

    public function testPasswordSalahReturnFalse()
    {
        $faker = \Faker\Factory::create();
        $password = $faker->password();
        $user = new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: Hash::make($password),
            username: $this->username,
            admin: $this->isAdmin
        );
        $this->assertFalse($user->isPasswordCorrect($password . $faker->password()));
    }

    public function testPasswordBenarReturnTrue()
    {
        $faker = \Faker\Factory::create();
        $password = $faker->password();
        $user = new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: Hash::make($password),
            username: $this->username,
            admin: $this->isAdmin
        );
        $this->assertTrue($user->isPasswordCorrect($password));
    }
}
