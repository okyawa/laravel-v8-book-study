<?php

namespace Tests\Unit;

use App\Services\CalculatePointService;
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
     * リスト 9.1.3.1　購入金額が0のときのテスト
     *
     * @test
     */
    public function calcPoint_購入金額が0ならポイントは0()
    {
        $result = CalculatePointService::calcPoint(0);
        $this->assertSame(0, $result);
    }

    /**
     * リスト 9.1.3.4 購入金額が1000のときのテスト
     *
     * @test
     */
    public function calcPoint_購入金額が1000ならポイントは0()
    {
        $result = CalculatePointService::calcPoint(1000);
        $this->assertSame(10, $result);
    }
}
