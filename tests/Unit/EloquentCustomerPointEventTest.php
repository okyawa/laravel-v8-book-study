<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

/**
 * EloquentCustomerPointEventTestクラス
 *
 * ユニットテスト用のデータベース追加
 * CREATE DATABASE app_test;
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
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
}
