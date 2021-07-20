<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Database\Connection;
use Illuminate\Support\LazyCollection;

/**
 * ExportOrdersのサービスクラス
 *
 * リスト 8.2.5.1
 */
final class ExportOrdersService
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * 対象日の購入情報を取得
     *
     * getメソッド異なり、cursorメソッドは呼び出し時点ではレコード内容を読み取らない
     * このメソッドはジェネレータを内包したLazyCollectionを返すので、
     * 以降の処理でforeach分を使い各レコード順次読み込むことになる
     * こう記述することで、大量のレコードを扱う際にもメモリの使用量を最小限に抑えることが可能
     * コンソールアプリケーションでは、大量のデータを処理するケースがあるので、
     * こうした方法を知っておくと良い
     *
     * @param CarbonImmutable $date
     * @return LazyCollection
     */
    public function findOrders(CarbonImmutable $date): LazyCollection
    {
        // クエリビルダを使って購入者情報の取得
        return $this->connection
            ->table('orders')
            ->join('order_details', 'order.order_code', '=', 'order_details.order_code')
            ->select(
                [
                    'orders.order_code',
                    'orders.order_date',
                    'orders.total_price',
                    'orders.total_quantity',
                    'orders.customer_name',
                    'orders.customer_email',
                    'orders.destination_name',
                    'orders.destination_zip',
                    'orders.destination_prefecture',
                    'orders.destination_address',
                    'orders.destination_tel',
                    'order_details.*',
                ]
            )
            ->where('order_date', '>=', $date->toString())
            ->where('order_date', '<', $date->addDay()->toDateString())
            ->orderBy('orders.order_date')
            ->orderBy('orders.order_code')
            ->orderBy('order_details.detail_no')
            ->cursor(); // LazyCollectionとして取得
    }
}
