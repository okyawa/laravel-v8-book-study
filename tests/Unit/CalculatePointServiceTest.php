<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * このファイルの生成コマンド
 * $ php artisan make:test CalculatePointServiceTest --unit
 *
 * ユニットテストクラスでは、PHPUnit\Framework\TestCaseを継承し、
 * Laravelのキノを利用しない範囲でのテスト記述
 *
 * フィーチャテストクラスでは、LaravelがPHPUnitを拡張したTests\TestCaseを継承し、
 * Laravelの機能を利用したテストを記述
 *
 * リスト 9.1.2.1, 9.1.2.3
 */
class CalculatePointServiceTest extends TestCase
{
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
