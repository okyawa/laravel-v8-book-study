<?php

namespace App\Providers;

use App\DataProvider\UserToken;
use App\Models\User;
use App\Foundation\Auth\CacheUserProvider;
use App\Foundation\Auth\UserTokenProvider;
use App\Gate\UserAccess;
use App\Policies\ContentPolicy;
use App\Policies\ContentPolicyWithScaffold;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Psr\Log\LoggerInterface;
use stdClass;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        /**
         * ポリシークラスの登録例
         *
         * ここで登録したポリシークラスは、Illuminate\Contracts\Auth\Authenticatableインターフェースを実装したクラスのインスタンス経由で利用できる
         * リスト 6.5.2.9
         */
        'App\Models\Model' => ContentPolicyWithScaffold::class,

        /**
         * PHPのビルトインクラスを利用したポリシークラス登録例
         *
         * Eloquentモデルを利用しないポリシー場合、PHPのビルトインクラスstdClassをキーにポリシークラスを記述
         * リスト 6.5.2.11
         */
        stdClass::class => ContentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate, LoggerInterface $logger)
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

        /**
         * ログインしているユーザーのみアクセス許可する認可処理例
         *
         * Gateに実装されているdefineメソッドは認可処理に名前をつけて、紐付く処理をクロージャで記述
         * クロージャで記述した処理の戻り値は、booleanで返却する必要あり
         * クロージャの第1引数にはIlluminate\Contract\Auth\Authenticatableインターフェースを実装したクラスのインスタンスを利用
         * 第2引数に渡される$idは、Gateで提供されているallowsメソッドまたはcheckメソッドで指定する値
         * 第1引数には認証済みユーザーのインスタンスが渡されるので、Eloquentモデルを利用した認証処理以外でも全く同じ動作となるため、特別なドライバを用意する必要はなし
         * リスト 6.5.2.1
         */
        $gate->define('user-access', function (User $user, $id) {
            return intval($user->getAuthIdentifier()) === intval($id);
        });
        // または
        // Gate::define('user-access', function (User $user, $id) {
        //     return intval($user->getAuthIdentifier()) === intval($id);
        // });

        /**
         * __invokeを実装したメソッドを認可処理で利用する例
         *
         * リスト 6.5.2.4
         */
        $gate->define('user-access', new UserAccess());

        /**
         * beforeメソッドを利用した認可ロギング
         *
         * 認可処理を実行する前位に動作させたい処理があれば、beforeメソッドを実装
         * 例えば、認可処理が必要なルーティングにアクセスした場合に、アクセスログの保管、コンテンツに対する権限別でのアクセス解析など、
         * アプリケーションで実装するケースが多い機能を実現できる
         * beforeメソッドで利用するクロージャの第1引数にはIlluminate\Contract\Auth\Authenticatableインターフェースを実装したクラスのインスタンスが渡される
         * 第2引数にはallowsメソッドやdeniesメソッドの第2引数で渡された値が配列で取得できる
         * 下記コード例では、この後に実行される処理で、どのユーザーがアクセスしたかログに残す処理となる
         * リスト 6.5.2.5
         */
        $gate->before(function (User $user, $ability) use ($logger) {
            $logger->info($ability, [
                'user_id' => $user->getAuthIdentifier()
            ]);
        });
    }
}
