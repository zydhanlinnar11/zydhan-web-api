<?php

namespace Modules\Apps\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Modules\Apps\Http\Requests\CreateTokenRequest;
use Modules\Apps\Transformers\AppDetail\AppDetailQueryInterface;
use Modules\Auth\Facade\Auth;

class AuthorizationController extends Controller
{
    static $JWT_EXPIRATION_SECONDS = 300;

    public function __construct(
        private AppDetailQueryInterface $appDetailQuery,
    ) { }

    public function create_token(CreateTokenRequest $request)
    {
        $user = Auth::user($request);
        $appDetail = $this->appDetailQuery->execute($request->appId());
        var_dump($request->appId());
        if (!$appDetail || $appDetail->toArray($request)['redirectURI'] !== $request->redirectURI())
            return response()->json(null, 400);

        $data = [
            'sub' => $user->getUserId()->getId(),
            'name' => $user->getName(),
            'iat' => time(),
            'exp' => time() + self::$JWT_EXPIRATION_SECONDS,
        ];
        $jwt = JWT::encode($data, config('key'), 'HS256');

        return response()->json(['token' => $jwt]);
    }

    public function userinfo(Request $request)
    {
        
    }
}
