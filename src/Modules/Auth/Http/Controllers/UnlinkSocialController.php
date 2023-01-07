<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UnlinkSocialController extends Controller
{
    public function unlink(SocialMedia $socialMedia, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        if($user->socialMedia()->count() == 1) {
            abort(400, 'unable_to_unlink_primary_social_account');
        }

        $socialMedia->unlinkUser($user->getId());

        return response()->json([], 204);
    }
}