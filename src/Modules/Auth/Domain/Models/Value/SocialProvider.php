<?php

namespace Modules\Auth\Domain\Models\Value;

enum SocialProvider: string
{
    case GOOGLE = 'google';
    case GITHUB = 'github';

    public function name(): string
    {
        return match($this) 
        {
            self::GOOGLE => 'google',   
            self::GITHUB => 'github',   
        };
    }
}