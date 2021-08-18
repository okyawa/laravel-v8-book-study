<?php

namespace Tests\Unit;

use App\Models\EloquentCustomer;
use App\Models\EloquentCustomerPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * このファイルの生成コマンド
 * $ php artisan make:test EloquentCustomerPointTest --unit
 *
 * リスト9.2.3.2
 */
class EloquentCustomerPointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function addPoint()
    {
        // テストに必要なレコードを登録
        $customerId = 1;
        EloquentCustomer::factory()->create(
            [
                'id' => $customerId,
            ]
        );

        // Eloquentでレコード追加
        // * Factoryを利用せずにテストに必要なレコードを登録する方法もある
        EloquentCustomerPoint::unguard();
        EloquentCustomerPoint::create(
            [
                'customer_id' => $customerId,
                'point' => 100,
            ]
        );
        EloquentCustomerPoint::reguard();

        // テスト対象メソッドの実行
        $eloquent = new EloquentCustomerPoint();
        $result = $eloquent->addPoint($customerId, 10);

        // テスト結果のアサーション
        $this->assertTrue($result);
        $this->assertDatabaseHas(
            'customer_points',
            [
                'customer_id' => $customerId,
                'point' => 110,
            ]
        );
    }
}
