<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Transformers\HomePagePostsResource;
use Modules\Blog\Transformers\PostViewResource;

class BlogController extends Controller
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
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
     * @param string $slug
     * @return Response
     */
    public function show(Request $request, string $slug)
    {
        try {
            $post = $this->postRepository->findBySlug($slug);
            $data = (new PostViewResource($post))->toArray($request);

            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            if(env('APP_DEBUG') == 'true') {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return response()->json(['status' => 'error', 'message' => 'Internal server error']);
        } 
    }
}
