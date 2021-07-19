<?php

declare(strict_types=1);

namespace App\UseCase;

use Carbon\CarbonImmutable;

/**
 * リスト 8.2.4.1
 */
final class ExportOrderUseCase
{
    public function run(CarbonImmutable $targetDate): string
    {
        return $targetDate->toDateString() . 'の購入情報';
    }
}
