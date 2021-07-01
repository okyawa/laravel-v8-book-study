<?php

declare(strict_types=1);

namespace App\Providers;

use App\Foundation\Socialite\AmazonProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\SocialiteManager;

/**
 * Socialiteを拡張してドライバを追加
 *
 * リスト 6.4.4.4
 */
class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * @param Factory|SocialiteManager $factory
     * @return void
     */
    public function boot(Factory $factory)
    {
        // Socialiteのサービスプロバイダは遅延登録されるため、bootメソッドを利用して登録
        // 認証ドライバの追加にはextendメソッドを利用
        // 第1引数には認証ドライバ名を記述
        // 第2引数にクロージャを利用して、作成したApp\Foundation\Socialite\AmazonProviderのインスタン生成を行う
        // SocialiteのbuildProviderメソッドが便利
        // 下記では、Laravel\Socialite\Contracts\Factoryインターフェースを指定し、
        // メソッドインジェクションでSocialiteManagerインスタンすへアクセス
        // Socialiteファサードでextendメソッドを利用しても大丈夫
        // 認証ドライバ登録後は、Socialiteでamazonドライバとして利用できる
        $factory->extend(
            'amazon',
            function (Application $app) use ($factory) {
                return $factory->buildProvider(
                    AmazonProvider::class,
                    $app['config']['services.amazon']
                );
            }
        );
    }
}
