<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserInfoController extends Controller
{
    public function show(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        return response()->json([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'admin' => $user->isAdmin(),
            'social_media' => $user
                                ->getSocialMedia()
                                ->map(function(SocialMedia $item) {
                                    return $item->getId();
                                })
        ]);
    }
}