<?php

declare(strict_types=1);

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Socialiteによるリダイレクト処理
 *
 * リスト 6.4.2.2
 */
final class RegisterAction extends Controller
{
    public function __invoke(Factory $factory): RedirectResponse
    {
        // driver()メソッドで外部サービスを指定
        // redirect()メソッドで指定した外部サービスの認証画面へ遷移
        return $factory->driver('github')->redirect();

        // Socialiteファサードで記述する場合
        // return Socialite::driver('github')->redirect();

        // リスト 6.4.4.5: amazonドライバの利用例
        // return $factory->driver('amazon')->redirect();
        // または
        // return Socialite::driver('amazon')->redirect();
    }
}
