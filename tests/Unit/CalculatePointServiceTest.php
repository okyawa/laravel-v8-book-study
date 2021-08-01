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

    /**
     * データプロバイダを利用したテストメソッド
     *
     * リスト 9.1.4.2
     *
     * @test
     * @dataProvider dataProvider_for_calcPoint
     */
    public function calcPoint(int $expected, int $amount)
    {
        $result = CalculatePointService::calcPoint($amount);
        $this->assertSame($expected, $result);
    }

    /**
     * データプロバイダメソッド例
     *
     * リスト 9.1.4.1 - 9.1.4.6
     */
    public function dataProvider_for_calcPoint(): array
    {
        return [
            '購入金額が0なら0ポイント      ' => [0, 0],
            '購入金額が999なら0ポイント    ' => [0, 999],
            '購入金額が1000なら0ポイント   ' => [10, 1000],
            '購入金額が9999なら99ポイント  ' => [99, 9999],
            '購入金額が10000なら200ポイント' => [200, 10000],
        ];
    }
}
