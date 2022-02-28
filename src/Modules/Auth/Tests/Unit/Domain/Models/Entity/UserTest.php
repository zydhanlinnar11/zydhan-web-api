<?php

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Exceptions\AccountAlreadyLinkedException;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\SocialId;
use Modules\Auth\Domain\Models\Value\SocialProvider;
use Modules\Auth\Domain\Models\Value\UserId;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserTest extends TestCase
{
    private UserId $userId;
    private string $name;
    private string $email;
    private string $hashedPassword;
    private bool $isAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userId = new UserId(Uuid::uuid4());
        $faker = \Faker\Factory::create();
        $this->name = $faker->name();
        $this->email = $faker->email();
        $this->hashedPassword = Hash::make($faker->password());
        $this->isAdmin = $faker->boolean();
    }

    public function testBisaDiinstansiasi()
    {
        $user = new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
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
            admin: $this->isAdmin
        );

        $this->assertTrue($user->equals($user));
        
        $faker = \Faker\Factory::create();
        $this->assertNotTrue($user->equals(new User(
            userId: new UserId(Uuid::uuid4()),
            name: $faker->name(),
            email: $faker->email(),
            hashedPassword: Hash::make($faker->password()),
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
            admin: $this->isAdmin
        ))->getEmail() === $this->email);
    }

    public function testBisaGetStatusAdmin()
    {
        $this->assertTrue((new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
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
            admin: $this->isAdmin
        );
        $this->assertTrue($user->isPasswordCorrect($password));
    }

    public function testBisaGantiPassword()
    {
        $user = new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
            admin: $this->isAdmin
        );
        $faker = \Faker\Factory::create();
        $newPassword = $faker->password();
        
        $user->changePassword($newPassword);
        $this->assertTrue(Hash::check($newPassword, $user->getAuthPassword()));
    }

    public function testTidakBisaLinkSocialKalauSudahTerlink()
    {
        $user = new User(
            userId: $this->userId,
            name: $this->name,
            email: $this->email,
            hashedPassword: $this->hashedPassword,
            admin: $this->isAdmin,
            googleId: new SocialId(Uuid::uuid4(), SocialProvider::GOOGLE),
            githubId: new SocialId(Uuid::uuid4(), SocialProvider::GITHUB)
        );

        $this->expectException(AccountAlreadyLinkedException::class);
        $user->linkGoogleAccount(Uuid::uuid4());
        $this->expectException(AccountAlreadyLinkedException::class);
        $user->linkGithubAccount(Uuid::uuid4());
    }
}
