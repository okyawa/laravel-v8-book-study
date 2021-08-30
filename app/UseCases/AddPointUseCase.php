<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Exceptions\PreconditionException;
use App\Models\EloquentCustomer;
use App\Models\EloquentCustomerPoint;
use App\Models\PointEvent;
use App\Services\AddPointService;
use Carbon\CarbonImmutable;
use Throwable;

/**
 * リスト 9.3.2.6
 */
final class AddPointUseCase
{
    private AddPointService $service;
    private EloquentCustomer $eloquentCustomer;
    private EloquentCustomerPoint $eloquentCustomerPoint;

    public function __construct(
        AddPointService $service,
        EloquentCustomer $eloquentCustomer,
        EloquentCustomerPoint $eloquentCustomerPoint
    ) {
        $this->service = $service;
        $this->eloquentCustomer = $eloquentCustomer;
        $this->eloquentCustomerPoint = $eloquentCustomerPoint;
    }

    /**
     * @param integer $customerId
     * @param integer $addPoint
     * @param string $pointEvent
     * @param CarbonImmutable $now
     * @return integer
     * @throws Throwable
     */
    public function run(
        int $customerId,
        int $addPoint,
        string $pointEvent,
        CarbonImmutable $now
    ): int {
        // 事前処理検証
        if ($addPoint <= 0) {
            throw new PreconditionException(
                'add_point should be equals or grater than 1'
            );
        }

        if (!$this->eloquentCustomer->where('id', $customerId)->exists()) {
            $message = sprintf('customers.id:%d does not exists', $customerId);
            throw new PreconditionException($message);
        }

        if (!$this->eloquentCustomerPoint->where('customer_id', $customerId)->exists()) {
            $message = sprintf('customer_point.customer_id:%d does not exists', $customerId);
            throw new PreconditionException($message);
        }

        // ポイント加算処理
        $event = new PointEvent($customerId, $pointEvent, $addPoint, $now);
        $this->service->add($event);

        // 保有ポイント取得
        return $this->eloquentCustomerPoint->findPoint($customerId);
    }
}
