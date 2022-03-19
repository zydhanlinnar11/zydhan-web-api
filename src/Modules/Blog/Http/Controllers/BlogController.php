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
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Transformers\HomePosts\HomePostResource;
use Modules\Blog\Transformers\HomePosts\HomePostsQueryInterface;
use Modules\Blog\Transformers\PortfolioPosts\PortfolioPostResource;
use Modules\Blog\Transformers\PortfolioPosts\PortfolioPostsQueryInterface;
use Modules\Blog\Transformers\PostComments\PostCommentResource;
use Modules\Blog\Transformers\PostComments\PostCommentsQueryInterface;
use Modules\Blog\Transformers\ViewPost\ViewPostQueryInterface;

class BlogController extends Controller
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private CommentRepositoryInterface $commentRepository,
        private UserRepositoryInterface $userRepository,
        private CommentFactoryInterface $commentFactory,
        private HomePostsQueryInterface $homePostsQuery,
        private PostCommentsQueryInterface $postCommentsQuery,
        private PortfolioPostsQueryInterface $portfolioPostsQuery,
        private ViewPostQueryInterface $viewPostQuery,
    ) { }


    /**
     * Display a listing of the resource.
     * 
     * @return Response
     */
    public function index()
    {
        $data = $this->homePostsQuery->execute();

        return response()->json(HomePostResource::collection($data));
    }

    /**
     * Show the specified resource.
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function show(Request $request, Post $post)
    {
        $data = $this->viewPostQuery->execute($post->getId()->toString());

        return response()->json($data);
    }

    public function getPostComments(Post $post)
    {
        $data = $this->postCommentsQuery->execute($post->getId()->toString());

        return response()->json(PostCommentResource::collection($data));
    }

    public function createPostComment(Request $request, Post $post)
    {
        $user = Auth::user($request);        
        $comment = $request->validate(CreatePostCommentRequest::validationRule)['comment'];
        
        $createPostCommentRequest = new CreatePostCommentRequest(
            comment: $comment,
            userId: $user->getUserId(),
            postId: $post->getId()
        );

        $service = new CreatePostCommentService($this->commentFactory, $this->commentRepository);
        $service->execute($createPostCommentRequest);

        return response()->json(null, 201);
    }
    
    /**
     * Display a listing of the resource for portfolio.
     * @param Request $request
     * @return Response
     */
    public function portfolio(Request $request)
    {
        $data = $this->portfolioPostsQuery->execute();

        return response()->json(PortfolioPostResource::collection($data));
    }
}
