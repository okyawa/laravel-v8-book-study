<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * コントローラにおけるトークン認証によるユーザー情報取得例
 *
 * リスト 6.2.4.1
 */
class UserAction extends Controller
{
    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    public function __invoke(Request $request)
    {
        // 認証したユーザー情報へアクセス
        // Authファサードを利用してもOK
        $user = $this->authManager->guard('api')->user();

        return new JsonResponse([
            'id' => $user->getAuthIdentifier(),
            'name' => $user->getAuthIdentifierName()
        ]);
    }
}
