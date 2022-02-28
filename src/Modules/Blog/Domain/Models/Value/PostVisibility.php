<?php

namespace Modules\Blog\Domain\Models\Value;

enum PostVisibility: int
{
    case VISIBLE = 1;
    case UNLISTED = 2;
    case PRIVATE = 3;
}