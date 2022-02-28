<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Facade\Auth;
use Modules\Blog\App\Services\CreatePostComment\CreatePostCommentRequest;
use Modules\Blog\App\Services\CreatePostComment\CreatePostCommentService;
use Modules\Blog\Domain\Factories\CommentFactoryInterface;
use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Models\Value\PostId;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Transformers\HomePagePostsResource;
use Modules\Blog\Transformers\PostCommentResource;
use Modules\Blog\Transformers\PostViewResource;

class BlogController extends Controller
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private CommentRepositoryInterface $commentRepository,
        private UserRepositoryInterface $userRepository,
        private CommentFactoryInterface $commentFactory,
    ) { }


    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $posts = $this->postRepository->findByVisibilities([PostVisibility::VISIBLE]);
            $data = (new HomePagePostsResource($posts))->toArray($request);

            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            if(env('APP_DEBUG') == 'true') {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return response()->json(['status' => 'error', 'message' => 'Internal server error']);
        } 
    }

    /**
     * Show the specified resource.
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function show(Request $request, Post $post)
    {
        try {
            $data = (new PostViewResource($post))->toArray($request);

            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            if(env('APP_DEBUG') == 'true') {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return response()->json(['status' => 'error', 'message' => 'Internal server error']);
        } 
    }

    public function getPostComments(Request $request, Post $post)
    {
        try {
            $comments = $this->commentRepository->findAllByPostId($post->getId());
            $data = (new PostCommentResource($comments, $this->userRepository))->toArray($request);

            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            if(env('APP_DEBUG') == 'true') {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return response()->json(['status' => 'error', 'message' => 'Internal server error']);
        }
    }

    public function createPostComment(Request $request, Post $post)
    {
        $user = Auth::user($request);        
        $comment = $request->validate(CreatePostCommentRequest::validationRule)['comment'];
        
        try {
            $createPostCommentRequest = new CreatePostCommentRequest(
                comment: $comment,
                userId: $user->getUserId(),
                postId: $post->getId()
            );

            $service = new CreatePostCommentService($this->commentFactory, $this->commentRepository);
            $service->execute($createPostCommentRequest);

            return response()->json(['status' => 'success', 'data' => null], 201);
        } catch (\Exception $e) {
            if(env('APP_DEBUG') == 'true') {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
        }
    }
}
