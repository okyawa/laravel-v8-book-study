<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * 全ミドルウェアを無効化にする (WithoutMiddleware トレイト)
 *
 * このファイルの生成コマンド
 * $ php artisan make:test Api/WithoutMiddlewareTest
 */
class WithoutMiddlewareTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function 全てのミドルウェアを無効()
    {
        $response = $this->getJson('/api/live');

        $response->assertStatus(200);
    }
}
