<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

/**
 * ユーザー情報を返却するコントローラクラス
 *
 * jwtドライバを介したユーザー情報アクセス例
 * リスト 6.3.4.5
 */
final class RetrieveAction extends Controller
{
    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    public function __invoke(Request $request)
    {
        return $this->authManager->guard('jwt')->user();

        /**
         * Illuminate\Http\RequestクラスのbearerTokenメソッドを利用すると、
         * Authorization: Bearerヘッダで送信された値を取得できるため、
         * 下記の方法でもOK
         *
         * リスト 6.3.4.6
         */
        // $this->authManager->setToken($request->bearerToken()->user());
    }

    /**
     * ユーザー情報返却例
     *
     * リスト 6.3.4.7
     */
    /*
    {
        "id": 1,
        "name": "laravel user",
        "email": "mail@example.com",
        "created_at": "2018-08-05: 20:44:05",
        "updated_at": null
    }
    */
}
