<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responder\TokenResponder;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTGuard;

/**
 * JWT認証 ログインコントローラクラスの実装例
 *
 * JSONでトークン情報(access_token)を返却
 * リスト 6.3.4.2
 */
final class LoginAction extends Controller
{
    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    public function __invoke(Request $request, TokenResponder $responder): JsonResponse
    {
        /** @var JWTGuard $guard */
        $guard = $this->authManager->guard('jwt');
        $token = $guard->attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);

        return $responder(
            $token,
            $guard->factory()->getTTL() * 60
        );
    }

    /**
     * トークン情報の取得(access_token生成)リクエスト例
     *
     * リスト 6.3.4.3
     */
    /*
    curl -X POST 'http://localhost/api/users/login' \
    -H 'accept: application/json' \
    -H 'content-type: application/json' \
    -d '{
    "email": "mail@example.com",
    "password": "password"
    }'
    */

    /**
     * 返却されるaccess_token例
     *
     * リスト 6.3.4.4
     */
    /*
    {
        "access_token": "XXXXXXXXXXXXXX",
        "token_type": "bearer",
        "expires_in": 3600
    }
    */
}
