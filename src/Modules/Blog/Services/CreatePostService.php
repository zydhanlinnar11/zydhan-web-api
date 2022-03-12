<?php

namespace Modules\Blog\Services;

use Modules\Auth\Facade\Auth;
use Modules\Blog\Domain\Factories\PostFactoryInterface;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Http\Requests\CreatePostRequest;

class CreatePostService
{
    public function __construct(
      private PostFactoryInterface $postFactory,  
      private PostRepositoryInterface $postRepository  
    ) { }

    public function execute(CreatePostRequest $request)
    {
        $user = Auth::user($request);

        $post = $this->postFactory->createNewPost(
            userId: $user->getUserId(),
            title: $request->title(),
            description: $request->description(),
            markdown: $request->markdown(),
            visibility: $request->visibility()
        );

        $this->postRepository->save($post);
    }
}