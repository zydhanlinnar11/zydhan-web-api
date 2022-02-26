<?php

namespace Modules\Auth\Domain\Models\Value;

enum SocialProvider: string
{
    case GOOGLE;
    case GITHUB;

    public function name(): string
    {
        return match($this) 
        {
            self::GOOGLE => 'google',   
            self::GITHUB => 'github',   
        };
    }
}