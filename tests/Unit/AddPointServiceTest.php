<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\EloquentCustomer;
use App\Models\EloquentCustomerPoint;
use App\Models\PointEvent;
use App\Services\AddPointService;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * サービスクラスのテスト
 *
 * このファイルの生成コマンド
 * $ php artisan make:test AddPointServiceTest --unit
 *
 * テスト実行
 * $ make test path=tests/Unit/AddPointServiceTest.php
 *
 * リスト 9.2.4.1
 */
class AddPointServiceTest extends TestCase
{
    use RefreshDatabase;

    const CUSTOMER_ID = 1;

    protected function setUp(): void
    {
        parent::setUp();

        // テストに必要なレコードを登録
        EloquentCustomer::factory()->create(
            [
                'id' => self::CUSTOMER_ID,
            ]
        );

        EloquentCustomerPoint::unguard(); // セキュリティー解除 (※Laravelではセキュリティの観点から、ある程度固まったデータをDBに挿入することができないため)
        EloquentCustomerPoint::create(
            [
                'customer_id' => self::CUSTOMER_ID,
                'point' => 100,
            ]
        );
        EloquentCustomerPoint::reguard(); // セキュリティーを再設定
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function add()
    {
        // テスト対象メソッドの実行
        $event = new PointEvent(
            self::CUSTOMER_ID,
            '加算イベント',
            10,
            CarbonImmutable::create(2018, 8, 4, 12, 34, 56)
        );
        // サービスコンテナを利用してサービスクラスのインスタンス化
        /** @var AddPointService $service */
        $service = app()->make(AddPointService::class);
        $service->add($event);

        // テスト結果のアサーション
        $this->assertDatabaseHas(
            'customer_point_events',
            [
                'customer_id' => self::CUSTOMER_ID,
                'event' => $event->getEvent(),
                'point' => $event->getPoint(),
                'created_at' => $event->getCreatedAt(),
            ]
        );
        $this->assertDatabaseHas(
            'customer_points',
            [
                'customer_id' => self::CUSTOMER_ID,
                'point' => 110,
            ]
        );
    }
}
