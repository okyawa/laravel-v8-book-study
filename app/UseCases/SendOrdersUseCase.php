<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Services\ExportOrdersService;
use Carbon\CarbonImmutable;
use GuzzleHttp\Client;

/**
 * リスト 8.3.3.2
 */
final class SendOrdersUseCase
{
    private ExportOrdersService $service;
    private Client $guzzle;

    public function __construct(ExportOrdersService $service, Client $guzzle)
    {
        $this->service = $service;
        $this->guzzle = $guzzle;
    }

    /**
     * @param CarbonImmutable $targetDate 購入情報の対象日
     * @return integer
     * @throws GuzzleException
     */
    public function run(CarbonImmutable $targetDate): int
    {
        // データベースから購入情報を取得
        $orders = $this->service->findOrders($targetDate);

        // 送信データ作成
        $json = collect();
        $order = null;
        foreach ($orders as $detail) {
            if ($detail->detail_no === 1) {
                if (is_array($order)) {
                    $json->push($order);
                }
                $order = [
                    'order_code' => $detail->order_code,
                    'order_date' => $detail->order_date,
                    'total_quantity' => $detail->total_quantity,
                    'total_price' => $detail->total_price,
                    'customer_name' => $detail->customer_name,
                    'customer_email' => $detail->customer_email,
                    'destination_name' => $detail->destination_name,
                    'destination_zip' => $detail->destination_zip,
                    'destination_prefecture' => $detail->destination_prefecture,
                    'destination_address' => $detail->destination_address,
                    'destination_tel' => $detail->destination_tel,
                    'order_details' => [],
                ];
            }
            $order['order_details'][] = [
                'detail_no' => $detail->detail_no,
                'item_name' => $detail->item_name,
                'item_price' => $detail->item_price,
                'quantity' => $detail->quantity,
                'subtotal_price' => $detail->subtotal_price,
            ];
        }
        if (is_array($order)) {
            $json->push($order);
        }

        // JSON形式にシリアライズして送信
        $url = config('batch.import-orders-url');
        $this->guzzle->post($url, [
            'json' => $json
        ]);

        return $json->count();
    }
}
