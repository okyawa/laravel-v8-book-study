<?php

declare(strict_types=1);

namespace App\Foundation\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

use function GuzzleHttp\json_decode;
use function strval;

/**
 * Amazon OAuth認証ドライバ実装例
 *
 * リスト 6.4.4.3
 */
final class AmazonProvider extends AbstractProvider implements ProviderInterface
{
    protected $scopes = [
        'profile'
    ];

    /**
     * OAuth認証を提供していサービスを提供しているURLを文字列で記述
     *
     * @param string $state
     * @return string
     */
    protected function getAuthUrl($state): string
    {
        // Auth認証を行うURLを記述
        // 記述したURLにパラメータが付与され、Amazonのユーザー認証ページへ遷移する
        return $this->buildAuthUrlFromBase('https://www.amazon.com/ap/oa', $state);
    }

    /**
     * OAuth認証を提供しているサービスのトークンを取得するURLを文字列で記述
     *
     * @return string
     */
    protected function getTokenUrl(): string
    {
        // トークンを取得するURL
        // ユーザー情報アクセス時に内部で利用される
        return 'https://api.amazon.con/auth/o2/token';
    }

    /**
     * 取得したトークンを利用して、ユーザー情報を取得するメソッド
     * 取得したユーザー情報を配列で返却
     *
     * @param [type] $token
     * @return array
     */
    protected function getUserByToken($token): array
    {
        // getTokenUrl() で取得したトークンを用いてユーザー情報を取得
        // トークンを使うリクエスト送信方法
        // ・リクエストパラメータにaccess_tokenを利用する
        // ・Authorization Bearerヘッダを利用する
        // ・x-amz-access-tokenヘッダを利用する
        $response = $this->getHttpClient()
            ->get('https://api.amazon.com/user/profile', [
                'headers' => [
                    'x-amz-access-token' => $token,
                ]
            ]);
        return json_decode(strval($response->getBody()), true);
    }

    /**
     * getUserByTokenで取得した配列をLaravel\Socialite\Two\Userインスタンス変換して返却
     *
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user): User
    {
        // getUserByToken() で問い合わせた結果を
        // Laravel\Socialite\Two\Userインスタンスに渡して返却
        return (new User())->setRaw($user)->map([
            'id' => $user['user_id'],
            'nickname' => $user['name'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar' => '',
        ]);
    }

    protected function getTokenFields($code): array
    {
        return parent::getTokenFields($code) + [
            'grant_type' => 'authorization_code'
        ];
    }
}
