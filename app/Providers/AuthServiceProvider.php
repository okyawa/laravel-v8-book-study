<?php

namespace App\Providers;

use App\DataProvider\UserToken;
use App\Foundation\Auth\CacheUserProvider;
use App\Foundation\Auth\UserTokenProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * 独自認証ドライバの登録
         *
         * リスト 6.1.5.2
         */
        $this->app->make('auth')->provider(
            'cache_eloquent',
            function (Application $app, array $config) {
                return new CacheUserProvider(
                    $app->make('hash'),
                    $config['model'],
                    $app->make('cache')->driver()
                );
            }
        );

        /**
         * 実装した認証プロバイダの登録
         *
         * リスト6.2.3.5
         */
        // 実装した独自認証ドライバ名をuser_tokenとして登録
        $this->app->make('auth')->provider(
            'user_token',
            function (Application $app, array $config) {
                // UserTokenProviderクラスのコンストラクタに型宣言されているインタフェースを実装した具象クラスを記述
                // 実装したクラスではDBファサードの実クラスであるIlluminate\Database\DatabaseManagerクラスを利用
                // DatabaseManagerクラスは、サービスコンテナにdbの名前で登録されているため、そのインスタンスを利用するように記述
                return new UserTokenProvider(new UserToken($app->make('db')));
            }
        );
    }
}
