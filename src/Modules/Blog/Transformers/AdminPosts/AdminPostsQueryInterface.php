<?php

namespace Modules\Blog\Transformers\AdminPosts;

interface AdminPostsQueryInterface
{
    /**
     * @return AdminPostResource[]
     */
    public function execute();
}