<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * このファイルの生成コマンド
 * $ php artisan make:test Api/PingTest
 *
 * リスト 9.3.1.11
 */
class PingTest extends TestCase
{
    /**
     * 汎用的にHTTPリクエストを送信するcallメソッドの定義
     *
     * リスト 9.3.1.5
     */
    /*
    public function call(
        $method,            // HTTPメソッド
        $uri,               // URI
        $parameters = [],   // 送信パラメータ
        $cookies = [],      // cookie
        $files = [],        // アップロードファイル
        $server = [],       // サーバパラメータ
        $content = null     // RAWリクエストボディ
    ): \Illuminate\Testing\TestResponse
    */

    /**
     * callメソッドの実行例
     *
     * リスト 9.3.1.6
     */
    public function executeCall()
    {
        // GETリクエスト - クエリストリング
        $response = $this->call('GET', '/api/get?class=motogp&no=99');

        // GETリクエスト - $parameters
        $response = $this->call('GET', '/api/get', [
            'class' => 'motogp',
            'no' => '99'
        ]);

        // POSTリクエスト
        $response = $this->call('POST', '/api/post', [
            'email' => 'a@example.com',
            'password' => 'secret-password'
        ]);
    }
}
