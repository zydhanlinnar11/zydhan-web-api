<?php

namespace Modules\Blog\Services;

use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Http\Requests\CreatePostRequest;

class EditPostService
{
    public function __construct(
      private PostRepositoryInterface $postRepository  
    ) { }

    public function execute(CreatePostRequest $request, Post $post)
    {
        $post->changeTitle($request->title());
        $post->changeDescription($request->description());
        $post->changeVisibility($request->visibility());
        $post->changeMarkdown($request->markdown());

        $this->postRepository->save($post);
    }
}