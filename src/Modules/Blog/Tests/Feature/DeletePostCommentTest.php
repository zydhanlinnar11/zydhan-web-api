<?php

namespace Module\Blog\Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Blog\Domain\Factories\CommentFactoryInterface;
use Modules\Blog\Domain\Models\Entity\Comment;
use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Models\Value\PostId;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class DeletePostCommentTest extends TestCase
{
    use RefreshDatabase;
    private Comment $comment;
    private User $user;
    private User $anotherUser;
    private User $anotherUserAdmin;
    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();
        $faker = Factory::create();
        
        /**
        * @var UserFactoryInterface $userFactory
        */
        $userFactory = $this->app->make(UserFactoryInterface::class);
        $this->user = $userFactory->createNewUser(
            name: $faker->name(),
            email: $faker->email(),
            password: $faker->password()
        );
        $this->anotherUser = $userFactory->createNewUser(
            name: $faker->name(),
            email: $faker->email(),
            password: $faker->password()
        );
        $this->anotherUserAdmin = new User(
            userId: new UserId(),
            name: $faker->name(),
            email: $faker->email(),
            hashedPassword: Hash::make($faker->password()),
            admin: true
        );

        /**
        * @var UserRepositoryInterface $userRepository
        */
        $userRepository = $this->app->make(UserRepositoryInterface::class);
        $userRepository->save($this->user);
        $userRepository->save($this->anotherUser);
        $userRepository->save($this->anotherUserAdmin);
        
        $this->post = new Post(
            id: new PostId(),
            userId: $this->user->getUserId(),
            title: $faker->text(),
            description: $faker->text(),
            markdown: $faker->text(),
            slug: $faker->text(),
            visibility: PostVisibility::VISIBLE,
            createdAt: now(),
            updatedAt: now()
        );
        /**
        * @var PostRepositoryInterface $postRepository
        */
        $postRepository = $this->app->make(PostRepositoryInterface::class);
        $postRepository->save($this->post);

        /**
        * @var CommentFactoryInterface $commentFactory
        */
        $commentFactory = $this->app->make(CommentFactoryInterface::class);
        $this->comment = $commentFactory->createNewComment(
            userId: $this->user->getUserId(),
            postId: $this->post->getId(),
            comment: $faker->text()
        );

        /**
        * @var CommentRepositoryInterface $commentRepository
        */
        $commentRepository = $this->app->make(CommentRepositoryInterface::class);
        $commentRepository->save($this->comment);
    }

    public function test_cant_delete_comment_without_login()
    {
        $response = $this->deleteJson('/blog/comments/'. $this->comment->getId()->toString());
        $response->assertStatus(401);
    }

    public function test_cant_delete_other_people_comment_except_admin()
    {
        $this->actingAs($this->anotherUser);
        $response = $this->deleteJson('/blog/comments/'. $this->comment->getId()->toString());
        $response->assertStatus(403);

        $this->actingAs($this->anotherUserAdmin);
        $response = $this->deleteJson('/blog/comments/'. $this->comment->getId()->toString());
        $response->assertStatus(200);
    }

    public function test_error_if_comment_not_found()
    {
        $this->actingAs($this->user);
        $response = $this->deleteJson('/blog/comments/'. Uuid::uuid4());
        $response->assertStatus(404);
    }

    public function test_can_delete_comment()
    {
        $this->actingAs($this->user);
        $response = $this->deleteJson('/blog/comments/'. $this->comment->getId()->toString());
        $response->assertStatus(200);
    }
}