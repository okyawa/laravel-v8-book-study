<?php

declare(strict_types=1);

namespace App\Foundation\ViewComposer;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\View\View;

/**
 * 認可を伴うプレゼンテーションロジック実装例
 *
 * ログインユーザーと認可処理を実行し、Bladeテンプレート描画時に差し込まれる内容を操作する
 * リスト 6.5.3.3
 */
final class PolicyComposer
{
    private $gate;

    private $authManger;

    public function __construct(Gate $gate, AuthManager $authManager)
    {
        $this->gate = $gate;
        $this->authManger = $authManager;
    }

    public function compose(View $view)
    {
        // 認可された処理かどうかを判定
        $allow = $this->gate->forUser(
            $this->authManger->guard()->user()
        )->allows('edit');
        if ($allow) {
            // 認可されている場合はBladeテンプレートのyieldディレクティブで指定されているauthorizedにallowedが表示される
            $view->getFactory()->inject('authorized', 'allowed');
        }
        // 認可されていない場合はdeniedと表示される
        $view->getFactory()->inject('authorized', 'denied');

        // テンプレート描画を指定することで表示内容を大きく変更できる
        // $view->getFactory()->make('テンプレート名')->render() などが利用できる
    }
}
