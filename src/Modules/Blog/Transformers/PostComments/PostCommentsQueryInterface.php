<?php

namespace Modules\Blog\Transformers\PostComments;

interface PostCommentsQueryInterface
{
    /**
     * @return PostCommentResource[]
     */
    public function execute(string $postId);
}