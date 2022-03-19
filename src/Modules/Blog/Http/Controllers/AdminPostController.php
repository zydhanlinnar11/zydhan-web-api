<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Facade\Auth;
use Modules\Blog\Domain\Factories\PostFactoryInterface;
use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Http\Requests\CreatePostRequest;
use Modules\Blog\Services\CreatePostService;
use Modules\Blog\Services\EditPostService;
use Modules\Blog\Transformers\AdminEditPost\AdminEditPostQueryInterface;
use Modules\Blog\Transformers\AdminPosts\AdminPostResource;
use Modules\Blog\Transformers\AdminPosts\AdminPostsQueryInterface;

class AdminPostController extends Controller
{
    public function __construct(
        private PostFactoryInterface $postFactory,
        private PostRepositoryInterface $postRepository,
        private AdminPostsQueryInterface $adminPostsQuery,
        private AdminEditPostQueryInterface $adminEditPostQuery,
    ) { }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user($request);
        if (!$user->isAdmin()) abort(403);
        $data = $this->adminPostsQuery->execute();

        return response()->json(AdminPostResource::collection($data));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreatePostRequest $request
     * @return Response
     */
    public function store(CreatePostRequest $request)
    {
        $service = new CreatePostService(
            postFactory: $this->postFactory,
            postRepository: $this->postRepository
        );
        $id = $service->execute($request);

        return response()->json([ 'id' => $id ], 201);
    }

    /**
     * Show the specified resource.
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function show(Request $request, string $id)
    {
        $user = Auth::user($request);
        if (!$user->isAdmin()) abort(403);

        $postResource = $this->adminEditPostQuery->execute($id);

        return response()->json($postResource);
    }

    /**
     * Update the specified resource in storage.
     * @param CreatePostRequest $request
     * @param Post $post
     * @return Response
     */
    public function update(CreatePostRequest $request, Post $post)
    {
        $service = new EditPostService($this->postRepository);
        $service->execute($request, $post);
        return response()->json(null);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function destroy(Request $request, Post $post)
    {
        $user = Auth::user($request);
        if (!$user->isAdmin()) abort(403);

        $this->postRepository->delete($post);
        return response()->json(null);
    }
}
