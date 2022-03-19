<?php

namespace Modules\Blog\Transformers\AdminEditPost;

interface AdminEditPostQueryInterface
{
    public function execute(string $id): AdminEditPostResource;
}