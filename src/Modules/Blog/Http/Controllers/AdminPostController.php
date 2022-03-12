<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Blog\Domain\Factories\PostFactoryInterface;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Http\Requests\CreatePostRequest;
use Modules\Blog\Services\CreatePostService;
use Modules\Blog\Transformers\HomePagePostsResource;

class AdminPostController extends Controller
{
    public function __construct(
        private PostFactoryInterface $postFactory,
        private PostRepositoryInterface $postRepository
    ) { }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $posts = $this->postRepository->findByVisibilities([]);
        $data = (new HomePagePostsResource($posts))->toArray($request);

        return response()->json($data);
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
        $service->execute($request);

        return response()->json(null, 201);
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

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
