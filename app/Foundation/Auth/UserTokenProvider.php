<?php

declare(strict_types=1);

namespace App\Foundation\Auth;

use App\DataProvider\UserTokenProviderInterface;
use App\Entity\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

use function is_null;

/**
 * UserProviderインターフェースの実装
 *
 * リスト6.2.3.4
 */
final class UserTokenProvider implements UserProvider
{
    private $provider;

    public function __construct(UserTokenProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function retrieveById($identifier)
    {
        return null;
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // APIアプリケーションで自動ログイン機能は利用できないため、処理を記述しない
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (!isset($credentials['api_token'])) {
            return null;
        }
        // ユーザー情報を取得
        $result = $this->provider->retrieveUserByToken($credentials['api_token']);
        if (is_null($result)) {
            return null;
        }
        // Authenticatableインターフェース実測クラスのApp\Entity\Userクラスのインスタンスを返却
        return new User(
            $result->user_id,
            $result->api_token,
            $result->name,
            $result->email
        );
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // APIアプリケーションではパスワード認証は利用しないため、
        // 利用された場合にログインできないことを示すためfalseを記述
        return false;
    }
}
