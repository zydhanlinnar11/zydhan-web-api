<?php

namespace Modules\Blog\Transformers\ViewPost;

interface ViewPostQueryInterface
{
    public function execute(string $slug): ViewPostResource;
}