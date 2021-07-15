<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/**
 * クロージャによるHelloコマンドの実装
 *
 * 実行コマンド
 * $ php artisan hello:closure
 *
 * artisanコマンド一覧表示
 * $ php artisan list
 * コマンド名にコロンを含めると、その左側はグループ化される
 * describeで指定したコマンドの説明も表示される
 *
 * リスト 8.1.1.1, 8.1.1.2, 8,1.1.3
 */
Artisan::command('hello:closure', function () { // 第1引数にコマンド名
    $this->comment('Hello closure command'); // 文字列出力 (※出力される文字は黄色)
    return 0; // 正常終了なら0を返す (※戻り値を返さない場合は0を返した場合と同様)
})->describe('サンプルコマンド(クロージャ)'); // コマンド説明
