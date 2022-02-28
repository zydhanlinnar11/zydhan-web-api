<?php

namespace Modules\Blog\App\Services\CreatePostComment;

use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Models\Value\PostId;

class CreatePostCommentRequest
{
    const validationRule = [
        'comment' => 'required',
    ];

    public function __construct(
        public string $comment,
        public UserId $userId,
        public PostId $postId
    ) { }
}