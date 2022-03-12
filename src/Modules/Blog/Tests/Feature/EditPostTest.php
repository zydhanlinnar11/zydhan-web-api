<?php

namespace Modules\Blog\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Blog\Domain\Factories\PostFactoryInterface;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Ramsey\Uuid\Uuid;

class EditPostTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private UserFactoryInterface $userFactory;
    private PostRepositoryInterface $postRepository;
    private array $data;
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
        
        /**
         * @var UserFactoryInterface $userFactory
         */
        $userFactory = $this->app->make(UserFactoryInterface::class);
        $this->userAdmin = $userFactory->generateRandom(true);
        /**
         * @var PostFactoryInterface $postFactory
         */
        $postFactory = $this->app->make(PostFactoryInterface::class);
        $post = $postFactory->createNewPost(
            userId: $this->userAdmin->getUserId(),
            title: $data['title'],
            description: $data['description'],
            markdown: $data['markdown'],
            visibility: $data['visibility'],
        );
        
        $this->postRepository = $this->app->make(PostRepositoryInterface::class);
        $this->postRepository->save($post);
        $this->urlWithId = $this->url . $post->getId()->toString();

        $this->data = [
            'title' => $this->faker()->text(64),
            'description' => $this->faker()->text(),
            'visibility' => PostVisibility::UNLISTED,
            'markdown' => $this->faker()->text(),
        ];
    }
    
    public function testCanEditPost()
    {
        $user = $this->userAdmin;
        $this->actingAs($user);

        $data = $this->data;
        $response = $this->patchJson($this->urlWithId, $data);
        $response->assertStatus(200);
        
        /**
         * @var PostRepositoryInterface $postRepository
         */
        $postRepository = $this->app->make(PostRepositoryInterface::class);
        
        $slug = Str::slug($data['title']);
        $post = $postRepository->findBySlug($slug);
        $this->assertNotNull($post);
        $this->assertEquals($data['title'], $post->getTitle());
        $this->assertEquals($data['description'], $post->getDescription());
        $this->assertEquals($data['visibility'], $post->getVisibility());
        $this->assertEquals($data['markdown'], $post->getMarkdown());
        $this->assertTrue($user->getUserId()->equals($post->getUserId()));
        $this->assertNotNull($post->getCreatedAt());
        $this->assertNotNull($post->getUpdatedAt());
    }
    
    public function testForbiddenIfNotAdmin()
    {
        $user = $this->userFactory->generateRandom();
        $this->actingAs($user);
        
        $response = $this->patchJson($this->urlWithId, $this->data);
        $response->assertStatus(403);
    }
    
    public function testTitleCantBeEmpty()
    {
        
        $user = $this->userAdmin;
        $this->actingAs($user);

        $data = $this->data;
        unset($data['title']);
        $response = $this->patchJson($this->urlWithId, $data);
        $response->assertStatus(422);
    }
    
    public function testDescriptionCantBeEmpty()
    {
        
        $user = $this->userAdmin;
        $this->actingAs($user);

        $data = $this->data;
        unset($data['description']);
        $response = $this->patchJson($this->urlWithId, $data);
        $response->assertStatus(422);
    }
    
    public function testVisibilityCantBeEmpty()
    {
        
        $user = $this->userAdmin;
        $this->actingAs($user);

        $data = $this->data;
        unset($data['visibility']);
        $response = $this->patchJson($this->urlWithId, $data);
        $response->assertStatus(422);
    }
    
    public function testMarkdownCantBeEmpty()
    {
        
        $user = $this->userAdmin;
        $this->actingAs($user);

        $data = $this->data;
        unset($data['markdown']);
        $response = $this->patchJson($this->urlWithId, $data);
        $response->assertStatus(422);
    }
    
    public function test404IfNotFound()
    {
        $user = $this->userAdmin;
        $this->actingAs($user);

        $response = $this->patchJson($this->url . Uuid::uuid4(), $this->data);
        $response->assertStatus(404);
    }
}
