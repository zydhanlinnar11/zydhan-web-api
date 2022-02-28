<?php

namespace Module\Blog\Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Models\Value\PostId;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Tests\TestCase;

class CreatePostCommentTest extends TestCase
{
    use RefreshDatabase;
    private Post $post;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $faker = Factory::create();
        
        /**
        * @var UserFactoryInterface $userFactory
        */
        $userFactory = $this->app->make(UserFactoryInterface::class);
        $user = $userFactory->createNewUser(
            name: $faker->name(),
            email: $faker->email(),
            password: $faker->password()
        );

        /**
        * @var UserRepositoryInterface $userRepository
        */
        $userRepository = $this->app->make(UserRepositoryInterface::class);
        $userRepository->save($user);
        $this->user = $user;
        
        $this->post = new Post(
            id: new PostId(),
            userId: $user->getUserId(),
            title: $faker->text(),
            description: $faker->text(),
            markdown: $faker->text(),
            visibility: PostVisibility::VISIBLE,
            createdAt: now(),
            updatedAt: now()
        );
        /**
        * @var PostRepositoryInterface $postRepository
        */
        $postRepository = $this->app->make(PostRepositoryInterface::class);
        $postRepository->save($this->post);
    }

    public function test_comment_cant_be_empty()
    {
        $this->actingAs($this->user);
        $response = $this->postJson('/blog/posts/'. $this->post->getSlug() .'/comments', []);
        $response->assertStatus(422);
    }

    public function test_cant_create_comment_without_login()
    {
        $response = $this->postJson('/blog/posts/'. $this->post->getSlug() .'/comments', []);
        $response->assertStatus(401);
    }

    public function test_error_if_post_not_found()
    {
        $this->actingAs($this->user);
        $response = $this->postJson('/blog/posts/'. $this->post->getSlug() . 'a' .'/comments', []);
        $response->assertStatus(404);
    }

    public function test_can_create_comment()
    {
        $this->actingAs($this->user);
        $response = $this->postJson('/blog/posts/'. $this->post->getSlug() .'/comments', [
            'comment' => 'test-comment'
        ]);
        $response->assertStatus(201);
    }
}