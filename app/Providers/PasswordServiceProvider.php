<?php

declare(strict_types=1);

namespace App\Providers;

use App\Auth\Passwords\PasswordManager;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Contracts\Foundation\Application;

/**
 * 独自パスワードリセットクラスの登録方法
 *
 * リスト 6.1.6.2
 */
class PasswordServiceProvider extends PasswordResetServiceProvider
{
    protected function registerPasswordBroker(): void
    {
        // パスワードリセット機能はフレームワーク内でauth.passwordとしてアクセスされるため、
        // 利用するクラスを継承したクラスに変更
        $this->app->singleton(
            'auth.password',
            function (Application $app) {
                return new PasswordManager($app);
            }
        );

        // パスワードリセットを実行する機能はauth.password.brokerとしてフレームワークで利用されているので、
        // 標準で用意されている登録方法をそのまま利用
        $this->app->bind(
            'auth.password.broker',
            function (Application $app) {
                return $app->make('auth.password')->broker();
            }
        );
    }
}
