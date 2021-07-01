<?php

declare(strict_types=1);

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GithubProvider;
use Psr\Log\LoggerInterface;

/**
 * Socialiteを利用したユーザー作成とログイン
 *
 * リスト 6.4.2.3
 */
final class CallbackAction extends Controller
{
    public function __invoke(
        Factory $factory,
        AuthManager $authManager,
        LoggerInterface $log
    ) {
        // コールバック時にSocialiteのメソッドを介してユーザー情報を取得
        // ここで返却されるメソッドは、抽象クラスのLaravel\Socialite\AbstractUserクラスを継承している
        // $user = $factory->driver('github')->user();

        /**
         * 外部サービスとの通信内容をログとして出力する例
         *
         * GuzzleのMiddlewareを使ってフレームワークのログ出力に追加
         * Socialiteで任意のGuzzleインスタンスを利用するには、
         * setHttpClientメソッドが利用できる
         * リスト 6.4.3.1
         */
        /** @var GithubProvider */
        $driver = $factory->driver('github');
        // リスト 6.4.3.2: GETリスエスト送信時のパラメータ追加例
        $driver->with(['allow_signup' => 'false']);
        // リスト 6.4.3.3: セッションを利用する例 (アプリケーション側で状態保持が必要な場合)
        $driver->stateless()->user();
        $user = $driver->setHttpClient(
            new Client([
                'handler' => tap(
                    HandlerStack::create(),
                    function (HandlerStack $stack) use ($log) {
                        $stack->push(Middleware::log($log, new MessageFormatter()));
                    }
                )
            ])
        )->user();

        // 外部サービスから取得したユーザー情報をデータベースに登録し、ログイン処理を実行
        // login()メソッドの第2引数にtrueを指定し、自動ログインのクッキーを発行
        // ログイン後は任意のページへ遷移することで、通常のログインユーザーと同じ扱いになる
        $authManager->guard()->login(
            User::firstOrCreate([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password'
            ]),
            true
        );

        /*
         * Facadeを使って記述する場合
        $user = Socialite::driver('github')->user();
        Auth::login(
            User::firstOrCreate([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ]),
            true
        );
        */

        return redirect('/home');
    }
}
