<?php

namespace Modules\Blog\Domain\Models\Value\PostVisibility;

enum PostVisibility: int
{
    case VISIBLE = 1;
    case UNLISTED = 2;
    case PRIVATE = 3;
}