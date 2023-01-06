<?php

namespace Modules\OAuth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserInfoController extends Controller
{
    /**
     * The UserInfo Endpoint is an OAuth 2.0 Protected Resource that returns Claims about the authenticated End-User.
     * To obtain the requested Claims about the End-User, the Client makes a request to the UserInfo Endpoint
     * using an Access Token obtained through OpenID Connect Authentication.
     * These Claims are normally represented by a JSON object that contains
     * a collection of name and value pairs for the Claims.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $data = [
            'sub' => strval($user->getId()),
        ];

        if ($user->tokenCan('profile')) {
            $data['name'] = $user->getName();
        }

        if ($user->tokenCan('email')) {
            $data['email'] = $user->getEmail();
            $data['email_verified'] = $user->isEmailVerified();
        }

        return response()->json($data);
    }
}
