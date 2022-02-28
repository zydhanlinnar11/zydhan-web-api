<?php

namespace Modules\Blog\App\Services\CreatePostComment;

use Modules\Blog\Domain\Factories\CommentFactoryInterface;
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;

class CreatePostCommentService
{
    public function __construct(
        public CommentFactoryInterface $commentFactory,
        public CommentRepositoryInterface $commentRepository
    ) { }

    public function execute(CreatePostCommentRequest $request)
    {
        $comment = $this->commentFactory->createNewComment(
            userId: $request->userId,
            postId: $request->postId,
            comment: $request->comment,
        );
        
        $this->commentRepository->save($comment);
    }
}