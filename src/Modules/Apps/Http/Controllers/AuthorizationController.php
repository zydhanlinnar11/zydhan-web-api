<?php

namespace Modules\Apps\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Modules\Apps\Http\Requests\CreateTokenRequest;
use Modules\Apps\Transformers\AppDetail\AppDetailQueryInterface;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Facade\Auth;

class AuthorizationController extends Controller
{
    static $JWT_EXPIRATION_SECONDS = 300;

    public function __construct(
        private AppDetailQueryInterface $appDetailQuery,
        private UserRepositoryInterface $userRepository,
    ) { }

    public function create_token(CreateTokenRequest $request)
    {
        $user = Auth::user($request);
        $appDetail = $this->appDetailQuery->execute($request->appId());
        if (!$appDetail || $appDetail->toArray($request)['redirectURI'] !== $request->redirectURI())
            return response()->json(null, 400);

        $data = [
            'sub' => $user->getUserId()->getId(),
            'name' => $user->getName(),
            'iat' => time(),
            'exp' => time() + self::$JWT_EXPIRATION_SECONDS,
        ];
        $jwt = JWT::encode($data, config('app.key'), 'HS256');

        return response()->json(['token' => $jwt]);
    }

    public function userinfo(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'additionalScope' => 'string'
        ]);

        $jwt = $validated['token'];

        $decoded = JWT::decode($jwt, new Key(config('app.key'), 'HS256'));

        $user = $this->userRepository->findById(new UserId($decoded->sub));

        $data = [
            'id' => $user->getUserId()->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'avatar_url' => $user->getAvatar(),
        ];

        if ($validated['additionalScope']) $data['social'] = [
            'google' => $user->getGoogleId()?->getId(),
            'github' => $user->getGithubId()?->getId(),
            'discord' => null
        ];

        return response()->json($data);
    }
}
