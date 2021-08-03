<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * テンプレートメソッドの動きを見るテスト
 *
 * 各テストの前処理を担うのがsetUpメソッド、後処理を担うのがtearDownメソッド
 *
 * テストクラスごとに呼ばれるsetUpBeforeClassメソッドとtearDownAfterClassメソッド
 * テストメソッドが属するテストクラスごとに1回だけ呼ばれる
 * テストクラスで初回だけ必要な前処理や後処理に利用
 *
 * リスト 9.1.6.1
 */
class TemplateMethodTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        echo __METHOD__, PHP_EOL;
    }

    protected function setUp(): void
    {
        parent::setup();
        echo __METHOD__, PHP_EOL;
    }

    /**
     * @test
     */
    public function テストメソッド1()
    {
        echo __METHOD__, PHP_EOL;
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function テストメソッド2()
    {
        echo __METHOD__, PHP_EOL;
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        echo __METHOD__, PHP_EOL;
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        echo __METHOD__, PHP_EOL;
    }
}
