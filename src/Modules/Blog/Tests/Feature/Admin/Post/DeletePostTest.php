<?php

namespace Modules\Blog\Tests\Feature\Admin\Post;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Blog\Domain\Factories\PostFactoryInterface;
use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Ramsey\Uuid\Uuid;

class DeletePostTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private UserFactoryInterface $userFactory;
    private PostRepositoryInterface $postRepository;
    private Post $post;
    private string $url;
    private string $urlWithId;
    private User $userAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = $this->app->make(UserFactoryInterface::class);
        $data = [
            'title' => $this->faker()->text(64),
            'description' => $this->faker()->text(),
            'visibility' => PostVisibility::VISIBLE,
            'markdown' => $this->faker()->text(),
        ];
        $this->url = '/blog/admin/posts/';
    
        $this->userAdmin = $this->userFactory->generateRandom(true);
        /**
         * @var PostFactoryInterface $postFactory
         */
        $postFactory = $this->app->make(PostFactoryInterface::class);
        $this->post = $postFactory->createNewPost(
            userId: $this->userAdmin->getUserId(),
            title: $data['title'],
            description: $data['description'],
            markdown: $data['markdown'],
            visibility: $data['visibility'],
        );
        
        $this->postRepository = $this->app->make(PostRepositoryInterface::class);
        $this->postRepository->save($this->post);
        $this->urlWithId = $this->url . $this->post->getId()->toString();
    }
    
    public function testCanDeletePost()
    {
        $user = $this->userAdmin;
        $this->actingAs($user);

        $response = $this->deleteJson($this->urlWithId);
        $response->assertStatus(200);
        
        /**
         * @var PostRepositoryInterface $postRepository
         */
        $postRepository = $this->app->make(PostRepositoryInterface::class);
        
        $post = $postRepository->findById($this->post->getId());
        $this->assertNull($post);
    }
    
    public function testForbiddenIfNotAdmin()
    {
        $user = $this->userFactory->generateRandom();
        $this->actingAs($user);
        
        $response = $this->deleteJson($this->urlWithId);
        $response->assertStatus(403);
    }
    
    public function test404IfNotFound()
    {
        $user = $this->userAdmin;
        $this->actingAs($user);

        $response = $this->deleteJson($this->url . Uuid::uuid4());
        $response->assertStatus(404);
    }
}
