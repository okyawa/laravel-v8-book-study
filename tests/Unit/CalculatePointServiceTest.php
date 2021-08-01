<?php

namespace Tests\Unit;

use App\Exceptions\PreconditionException;
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

    /**
     * try/catchの利用
     *
     * リスト 9.1.5.1
     *
     * @test
     */
    public function exception_try_catch()
    {
        try {
            throw new \InvalidArgumentException('message', 200);
            $this->fail(); // 例外がスローされない場合はテストを失敗させる
        } catch (\Throwable $e) {
            // 指定した例外クラスがスローされているか
            $this->assertInstanceOf(\InvalidArgumentException::class, $e);
            // スローされた例外のコードを検証
            $this->assertSame(200, $e->getCode());
            // スローされた例外のメッセージを検証
            $this->assertSame('message', $e->getMessage());
        }
    }

    /**
     * expectExceptionメソッドを使った例外のテスト
     *
     * try/catchを使う形式よりも、専用メソッドのexpectExceptionメソッドを使う形式の方が、
     * 例外を期待するテストであるという意図が明確で分かりやすい
     * リスト 9.1.5.2
     *
     * @test
     */
    public function exception_expectException_method()
    {
        // 指定した例外クラスがスローされているか
        $this->expectException(\InvalidArgumentException::class);
        // スローされた例外のコードを検証
        $this->expectExceptionCode(200);
        // スローされた例外のメッセージを検証
        $this->expectExceptionMessage('message');

        throw new \InvalidArgumentException('message', 200);
    }

    /**
     * expectExceptionメソッドを使って購入金額が負数の場合のテスト
     *
     * リスト 9.1.5.3
     *
     * @test
     */
    public function calcPoint_購入金額が負の数なら例外をスロー()
    {
        $this->expectException(PreconditionException::class);
        $this->expectExceptionMessage('購入金額が負の数');

        CalculatePointService::calcPoint(-1);
    }
}
