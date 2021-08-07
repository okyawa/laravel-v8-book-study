<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\EloquentCustomerPoint;
use App\Models\EloquentCustomerPointEvent;
use App\Models\PointEvent;
use Illuminate\Database\ConnectionInterface;
use Throwable;

/**
 * リスト 9.2.1.6
 */
final class AddPointService
{
    private EloquentCustomerPointEvent $eloquentCustomerPointEvent;
    private EloquentCustomerPoint $eloquentCustomerPoint;
    private ConnectionInterface $db;

    /**
     * @param EloquentCustomerPointEvent $eloquentCustomerPointEvent
     * @param EloquentCustomerPoint $eloquentCustomerPoint
     */
    public function __construct(
        EloquentCustomerPointEvent $eloquentCustomerPointEvent,
        EloquentCustomerPoint $eloquentCustomerPoint
    )
    {
        $this->eloquentCustomerPointEvent = $eloquentCustomerPointEvent;
        $this->eloquentCustomerPoint = $eloquentCustomerPoint;
        $this->db = $eloquentCustomerPointEvent->getConnection();
    }

    /**
     * ポイント加算を行う
     *
     * @param PointEvent $event
     * @return void
     * @throws Throwable
     */
    public function add(PointEvent $event)
    {
        $this->db->transaction(
            function () use ($event) {
                // ポイントイベント保存
                $this->eloquentCustomerPointEvent->register($event);
                // 保存ポイント更新
                $this->eloquentCustomerPoint->addPoint(
                    $event->getCustomerId(),
                    $event->getPoint()
                );
            }
        );
    }
}
