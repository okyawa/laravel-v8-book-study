<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Http\Middleware\TeaPotMiddleware;
use Tests\TestCase;

/**
 * ミドルウェアの無効化
 *
 * このファイルの生成コマンド
 * $ php artisan make:test Api/MiddlewareTest
 */
class MiddlewareTest extends TestCase
{
    /**
     * @test
     */
    public function live()
    {
        $this->getJson('/api/live')
            ->assertStatus(418); // ミドルウェア内で abort(418); が実行されている
    }

    /**
     * ミドルウェアを無効にする
     *
     * HTTPリクエスト送信時にルーティングなどで設定されているミドルウェアを無効にできる
     * withoutMiddlewareメソッドに無効にしたいミドルウェアクラス名を指定すると、
     * そのミドルウェアは実行されない
     *
     * リスト 9.3.4.1
     *
     * @test
     */
    public function TeaPotMiddlewareを無効()
    {
        $response = $this->withoutMiddleware(TeaPotMiddleware::class)
            ->getJson('/api/live');

        $response->assertStatus(200);
    }

    /**
     * 全ミドルウェアを無効にする (withoutMiddlewareメソッドの引数なし実行)
     *
     * リスト 9.3.4.2
     *
     * @test
     */
    public function 全てのミドルウェアを無効()
    {
        $response = $this->withoutMiddleware()
            ->getJson('/api/live');

        $response->assertStatus(200);
    }
}
