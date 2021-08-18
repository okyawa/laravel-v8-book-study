<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\EloquentCustomer;
use App\Models\EloquentCustomerPointEvent;
use App\Models\PointEvent;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * EloquentCustomerPointEventTestクラス
 *
 * ユニットテスト用のデータベース追加
 * CREATE DATABASE app_test;
 *
 * このファイルの生成コマンド
 * $ php artisan make:test EloquentCustomerPointEventTest --unit
 *
 * データベーステストにLaravelの機能を利用するので、Tests\TestCaseクラスを継承
 *
 * リスト 9.2.3.1
 */
class EloquentCustomerPointEventTest extends TestCase
{
    /**
     * RefreshDatabase トレイトをuseした例
     *
     * RefreshDatabaseトレイトをuseするだけでフレームワークが自動で処理するため、トレイトのメソッドを実行する必要はない
     * 内部的にartisan migrate:refreshを、テスト実行時に一度だけ自動的に実行される
     * phpunitコマンドで複数テストクラスを実行しても、この処理は一度のみ実行される
     *
     * RefreshDatabaseトレイトには自動でトランザクションを実行する機能がある
     * テスト実行中の全SQLクエリを同一トランザクション内で実行するようになる
     * このトランザクションは、テスト終了時に自動でロールバックされるので、テスト中に変更したコードは全て元に戻る
     *
     * Illuminate\Foundation\Testing\DatabaseMigration トレイト
     * テストメソッド実行ごとにマイグレーションのリセット・実行・ロールバックを繰り返すトレイト
     *
     * Illuminate\Foundation\Testing\DatabaseTransaction トレイト
     * RefreshDatabaseトレイトと同様、テストメソッド実行時にトランザクションを実行するトレイト
     *
     * リスト 9.2.2.3
     */
    use RefreshDatabase; // 自動でマイグレーション実行

    /**
     * @test
     */
    public function register()
    {
        // テストに必要なレコードを登録
        $customerId = 1;
        EloquentCustomer::factory()->create(
            [
                'id' => $customerId,
            ]
        );

        // テスト対象メソッドの実行
        $event = new PointEvent(
            $customerId,
            '加算イベント',
            100,
            CarbonImmutable::create(2018, 8, 4, 12, 34, 56)
        );
        $sut = new EloquentCustomerPointEvent();
        $sut->register($event);

        // テスト結果のアサーション
        // * assertDatabaseHasメソッドでは、第1引数で指定したテーブルに第2引数で指定したレコードが存在するかを検証
        $this->assertDatabaseHas(
            'customer_point_events',
            [
                'customer_id' => $customerId,
                'event' => $event->getEvent(),
                'point' => $event->getPoint(),
                'created_at' => $event->getCreatedAt(),
            ]
        );
    }
}
