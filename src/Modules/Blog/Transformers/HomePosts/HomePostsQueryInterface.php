<?php

namespace Modules\Blog\Transformers\HomePosts;

interface HomePostsQueryInterface
{
    /**
     * @return HomePostResource[]
     */
    public function execute();
}