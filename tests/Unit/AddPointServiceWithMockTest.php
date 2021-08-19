<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\EloquentCustomerPoint;
use App\Models\EloquentCustomerPointEvent;
use App\Models\PointEvent;
use App\Services\AddPointService;
use Carbon\CarbonImmutable;
use Tests\TestCase;

/**
 * モックによるテスト (サービスクラス)
 *
 * - モックを利用してデータベースへのアクセスを回避したテストの実装
 *
 * このファイルの生成コマンド
 * $ php artisan make:test AddPointServiceWithMockTest --unit
 *
 * テスト実行
 * $ make test path=tests/Unit/AddPointServiceWithMockTest.php
 *
 * リスト 9.2.5.1
 */
class AddPointServiceWithMockTest extends TestCase
{
    private $customerPointEvent;
    private $customerPoint;

    protected function setUp(): void
    {
        parent::setUp();

        // Eloquentクラスのモックを実装
        // * モック生成には、PHPUnitのcreateMockメソッドやgetMockBuilderメソッド、Laravelのmockやspyメソッドを利用する方法がある
        // * 単純なモックであれば、無名クラスで代用できる
        // * Eloquentクラスを継承した無名クラスを作成して、それぞれ必要なメソッドをオーバーライドしている
        // * オーバーライドしたメソッドでは、与えられた引数を後で確認するため、プロパティに格納する
        $this->customerPointEvent = new class extends EloquentCustomerPointEvent {
            public PointEvent $pointEvent;

            public function register(PointEvent $event)
            {
                $this->pointEvent = $event;
            }
        };

        $this->customerPoint = new class extends EloquentCustomerPoint {
            public int $customerId;
            public int $point;

            public function addPoint(int $customerId, int $point): bool
            {
                $this->customerId = $customerId;
                $this->point = $point;
                return true;
            }
        };
    }

    /**
     * @test
     */
    public function add()
    {
        // テストメソッドの実行
        $customerId = 1;
        $event = new PointEvent(
            $customerId,
            '加算イベント',
            10,
            CarbonImmutable::create(2018, 8, 4, 12, 34, 56)
        );

        $service = new AddPointService(
            $this->customerPointEvent,
            $this->customerPoint
        );
        $service->add($event);

        // テスト結果のアサーション
        $this->assertEquals($event, $this->customerPointEvent->pointEvent);
        $this->assertSame($customerId, $this->customerPoint->customerId);
        $this->assertSame(10, $this->customerPoint->point);
    }
}
