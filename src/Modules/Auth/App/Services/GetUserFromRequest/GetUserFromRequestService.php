<?php

namespace Modules\Auth\App\Services\GetUserFromRequest;

use Illuminate\Http\Request;
use Modules\Auth\Domain\Models\Entity\User;

class GetUserFromRequestService
{
    public function user(Request $request): User
    {
        return $request->user();
    }
}