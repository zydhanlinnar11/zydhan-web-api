<?php

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Infrastructure\Repositories\DBFacadeUserRepository;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    private MockInterface $queryBuilderMock;
    private User $user;
    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBuilderMock = Mockery::mock(Builder::class);

        $faker = \Faker\Factory::create();
        $this->user = new User(
            userId: new UserId(Uuid::uuid4()),
            name: $faker->name(),
            email: $faker->email(),
            hashedPassword: Hash::make($faker->password()),
            admin: $faker->boolean()
        );

        $this->userRepository = new DBFacadeUserRepository();
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
        $result->is_admin = $this->user->isAdmin();
        $result->password = $this->user->getAuthPassword();

        $queryBuilder->shouldReceive('first')
            ->once()
            ->andReturn($result);

        $user = $this->userRepository->findByEmail($this->user->getEmail());

        $this->assertTrue($this->user->equals($user));
    }

    public function testFindByIdMengembalikanUserYangBenar()
    {
        $queryBuilder = $this->queryBuilderMock;

        DB::shouldReceive('table')
            ->once()
            ->with('users')
            ->andReturn($queryBuilder);

        $queryBuilder->shouldReceive('where')
            ->once()
            ->with('id', $this->user->getUserId()->getId())
            ->andReturn($queryBuilder);

        $result = new stdClass();
        $result->id = $this->user->getUserId()->getId();
        $result->name = $this->user->getName();
        $result->email = $this->user->getEmail();
        $result->is_admin = $this->user->isAdmin();
        $result->password = $this->user->getAuthPassword();

        $queryBuilder->shouldReceive('first')
            ->once()
            ->andReturn($result);

        $user = $this->userRepository->findById($this->user->getUserId());

        $this->assertTrue($this->user->equals($user));
    }

    public function testBisaUpdateUserJikaSudahAda() {
        $queryBuilder = $this->queryBuilderMock;

        DB::shouldReceive('table')
            ->with('users')
            ->andReturn($queryBuilder);

        $user = $this->user;

        $result = new stdClass();
        $result->id = $this->user->getUserId()->getId();
        $result->name = $this->user->getName();
        $result->email = $this->user->getEmail();
        $result->is_admin = $this->user->isAdmin();
        $result->password = $this->user->getAuthPassword();

        $queryBuilder->shouldReceive('where')->once()->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('first')->once()->andReturn($result);

        $queryBuilder->shouldReceive('updateOrInsert')
            ->once()
            ->with(Mockery::on(function(array $data) use($user) {
                $this->assertEquals($data['id'], $user->getUserId()->getId()); 
                $this->assertEquals($data['name'], $user->getName()); 
                $this->assertEquals($data['email'], $user->getEmail()); 
                $this->assertEquals($data['password'], $user->getAuthPassword()); 
                $this->assertEquals($data['is_admin'], $user->isAdmin()); 
                $this->assertArrayHasKey('updated_at', $data);
                $this->assertNotNull($data['updated_at']);
                return true;
            }));

        $this->assertTrue($this->user->equals($this->userRepository->save($this->user)));
    }

    public function testBisaCreateUserJikaBelumAda() {
        $queryBuilder = $this->queryBuilderMock;

        DB::shouldReceive('table')
            ->with('users')
            ->andReturn($queryBuilder);

        $user = $this->user;

        $queryBuilder->shouldReceive('where')->once()->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('first')->once()->andReturn(null);

        $queryBuilder->shouldReceive('updateOrInsert')
            ->once()
            ->with(Mockery::on(function(array $data) use($user) {
                $this->assertEquals($data['id'], $user->getUserId()->getId()); 
                $this->assertEquals($data['name'], $user->getName()); 
                $this->assertEquals($data['email'], $user->getEmail()); 
                $this->assertEquals($data['password'], $user->getAuthPassword()); 
                $this->assertEquals($data['is_admin'], $user->isAdmin()); 
                $this->assertArrayHasKey('created_at', $data);
                $this->assertArrayHasKey('updated_at', $data);
                $this->assertNotNull($data['created_at']);
                $this->assertNotNull($data['updated_at']);
                return true;
            }));

        $this->assertTrue($this->user->equals($this->userRepository->save($this->user)));
    }
}