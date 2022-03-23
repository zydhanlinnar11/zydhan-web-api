<?php

namespace Modules\Apps\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Apps\Domain\Models\Entity\App;
use Modules\Apps\Domain\Models\Value\AppId;
use Modules\Apps\Domain\Repositories\AppRepositoryInterface;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Entity\User;

class CreateTokenTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private App $application;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $appRepository = $this->app->make(AppRepositoryInterface::class);
        $app = new App(
            id: new AppId(\Ramsey\Uuid\Uuid::uuid4()),
            name: $this->faker->name(),
            redirectURI: $this->faker->text()
        );

        $appRepository->save($app);
        $this->application = $app;

        $userFactory = $this->app->make(UserFactoryInterface::class);
        $user = $userFactory->generateRandom();
        $this->user = $user;
    }

    public function testSuccessReturnJWT()
    {
        $queryString = 'app_id=' . $this->application->getId()->getId() . '&redirect_uri=' . $this->application->getRedirectURI();
        $this->actingAs($this->user);

        $response = $this->getJson('/apps/create-token?' . $queryString);

        $response->assertStatus(200);
    }

    public function test401IfUnauthenticated()
    {
        $queryString = 'app_id=' . $this->application->getId()->getId() . '&redirect_uri=' . $this->application->getRedirectURI();

        $response = $this->getJson('/apps/create-token?' . $queryString);

        $response->assertUnauthorized();
    }

    public function test400IfAppIdOrRedirectUriWrong()
    {
        $this->actingAs($this->user);
        $queryString = 'app_id=' . \Ramsey\Uuid\Uuid::uuid4() . '&redirect_uri=' . $this->application->getRedirectURI();

        $response = $this->getJson('/apps/create-token?' . $queryString);

        $response->assertStatus(400);

        $queryString = 'app_id=' . $this->application->getId()->getId() . '&redirect_uri=' . $this->faker->text();

        $response = $this->getJson('/apps/create-token?' . $queryString);

        $response->assertStatus(400);
    }
}
