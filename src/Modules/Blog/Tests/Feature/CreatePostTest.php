<?php

namespace Modules\Blog\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;

class CreatePostTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private UserFactoryInterface $userFactory;
    private array $data;
    private string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = '/blog/admin/posts';
        $this->userFactory = $this->app->make(UserFactoryInterface::class);
        $this->data = [
            'title' => $this->faker()->text(64),
            'description' => $this->faker()->text(),
            'visibility' => PostVisibility::VISIBLE,
            'markdown' => $this->faker()->text(),
        ];
    }
    
    public function testCanSavePost()
    {
        
        $user = $this->userFactory->generateRandom(true);
        $this->actingAs($user);

        $data = $this->data;
        $response = $this->postJson($this->url, $data);
        $response->assertStatus(201);
        
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
        
        $response = $this->postJson($this->url, $this->data);
        $response->assertStatus(403);
    }
    
    public function testTitleCantBeEmpty()
    {
        
        $user = $this->userFactory->generateRandom(true);
        $this->actingAs($user);

        $data = $this->data;
        unset($data['title']);
        $response = $this->postJson($this->url, $data);
        $response->assertStatus(422);
    }
    
    public function testDescriptionCantBeEmpty()
    {
        
        $user = $this->userFactory->generateRandom(true);
        $this->actingAs($user);

        $data = $this->data;
        unset($data['description']);
        $response = $this->postJson($this->url, $data);
        $response->assertStatus(422);
    }
    
    public function testVisibilityCantBeEmpty()
    {
        
        $user = $this->userFactory->generateRandom(true);
        $this->actingAs($user);

        $data = $this->data;
        unset($data['visibility']);
        $response = $this->postJson($this->url, $data);
        $response->assertStatus(422);
    }
    
    public function testMarkdownCantBeEmpty()
    {
        
        $user = $this->userFactory->generateRandom(true);
        $this->actingAs($user);

        $data = $this->data;
        unset($data['markdown']);
        $response = $this->postJson($this->url, $data);
        $response->assertStatus(422);
    }
}
