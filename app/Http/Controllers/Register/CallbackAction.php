<?php

declare(strict_types=1);

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Facades\Socialite;

/**
 * Socialiteを利用したユーザー作成とログイン
 *
 * リスト 6.4.2.3
 */
final class CallbackAction extends Controller
{
    public function __invoke(
        Factory $factory,
        AuthManager $authManager
    ) {
        // コールバック時にSocialiteのメソッドを介してユーザー情報を取得
        // ここで返却されるメソッドは、抽象クラスのLaravel\Socialite\AbstractUserクラスを継承している
        $user = $factory->driver('github')->user();

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
