<?php

use Domain\Auth\Models\Entity\User;
use Domain\Auth\Models\Value\UserId;
use Domain\Auth\Repositories\UserRepositoryInterface;
use Domain\Auth\Services\HashServiceInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Infrastructure\Auth\Repositories\UserRepository;
use Mockery\MockInterface;
use Ramsey\Uuid\Uuid;

class UserRepositoryTest extends TestCase
{
    private MockInterface $queryBuilderMock;
    private User $user;
    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBuilderMock = Mockery::mock(Builder::class);
        $generateHashService = $this->app->make(HashServiceInterface::class);

        $faker = \Faker\Factory::create();
        $this->user = new User(
            userId: new UserId(Uuid::uuid4()),
            name: $faker->name(),
            email: $faker->email(),
            hashedPassword: $generateHashService->generate($faker->password()),
            username: $faker->userName(),
            admin: $faker->boolean()
        );

        $this->userRepository = new UserRepository();
    }

    public function testBisaDiinstansiasi()
    {
        $this->assertInstanceOf(UserRepositoryInterface::class, $this->userRepository);
    }

    public function testFindByEmailMengembalikanUserYangBenar()
    {
        $queryBuilder = $this->queryBuilderMock;

        DB::shouldReceive('table')
            ->once()
            ->with('users')
            ->andReturn($queryBuilder);

        $queryBuilder->shouldReceive('where')
            ->once()
            ->with('email', $this->user->getEmail())
            ->andReturn($queryBuilder);

        $result = new stdClass();
        $result->id = $this->user->getUserId()->getId();
        $result->name = $this->user->getName();
        $result->email = $this->user->getEmail();
        $result->username = $this->user->getUsername();
        $result->is_admin = $this->user->isAdmin();
        $result->password = $this->user->getHashedPassword();

        $queryBuilder->shouldReceive('first')
            ->once()
            ->andReturn($result);

        $user = $this->userRepository->findByEmail($this->user->getEmail());

        $this->assertTrue($this->user->equals($user));
    }

    public function testBisaBuatUser() {
        $queryBuilder = $this->queryBuilderMock;

        DB::shouldReceive('table')
            ->once()
            ->with('users')
            ->andReturn($queryBuilder);

        $user = $this->user;

        $queryBuilder->shouldReceive('insert')
            ->once()
            ->with(Mockery::on(function(array $data) use($user) {
                $this->assertEquals($data['id'], $user->getUserId()->getId()); 
                $this->assertEquals($data['name'], $user->getName()); 
                $this->assertEquals($data['email'], $user->getEmail()); 
                $this->assertEquals($data['password'], $user->getHashedPassword()); 
                $this->assertEquals($data['username'], $user->getUsername()); 
                $this->assertEquals($data['is_admin'], $user->isAdmin()); 
                $this->assertArrayHasKey('created_at', $data);
                $this->assertArrayHasKey('updated_at', $data);
                $this->assertNotNull($data['created_at']);
                $this->assertNotNull($data['updated_at']);
                return true;
            }));

        $this->assertTrue($this->user->equals($this->userRepository->create($this->user)));
    }
}