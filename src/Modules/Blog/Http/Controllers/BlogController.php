<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Domain\Models\Value\PostVisibility\PostVisibility;
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Transformers\HomePagePostsResource;
class BlogController extends Controller
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private CommentRepositoryInterface $commentRepository,
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
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }
}
