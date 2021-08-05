<?php

namespace Database\Seeders;

use App\Models\EloquentCustomer;
use App\Models\EloquentCustomerPoint;
use App\Models\Publisher;
use Carbon\CarbonImmutable;
use Illuminate\Database\Connection;
use Illuminate\Database\Seeder;
use Throwable;

/**
 * 実行コマンド
 * $ php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    /** @var Connection */
    private $db;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Throwable
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // authorsテーブルにデータ登録を行う処理
        $this->call(AuthorsTableSeeder::class);

        // publishersテーブルに50件のレコードを作成する
        Publisher::factory(50)->create();

        // usersとuser_tokensのテーブルにレコードを追加
        $this->call(
            [
                UserSeeder::class
            ]
        );

        // ordersとorder_detailsのテーブルにレコードを追加
        $this->db->transaction(
            function () {
                $this->orders();
                $this->orderDetails();
            }
        );

        $now = CarbonImmutable::now();
        // customersテーブルにレコードを追加
        EloquentCustomer::create(
            [
                'id' => 1,
                'name' => 'name1',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        // customer_pointsテーブルにレコードを追加
        EloquentCustomerPoint::create(
            [
                'customer_id' => 1,
                'point' => 100,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }

    private function orders()
    {
        $now = CarbonImmutable::now();

        $this->db->table('orders')->insert(
            [
                'order_code' => '1111-1111-1111-1111',
                'order_date' => '2021-04-10 00:00:00',
                'customer_name' => '大阪 太郎',
                'customer_email' => 'osaka@example.com',
                'destination_name' => '送付先 太郎',
                'destination_zip' => '1234567',
                'destination_prefecture' => '大阪府',
                'destination_address' => '送付先住所1',
                'destination_tel' => '06-0000-0000',
                'total_quantity' => 1,
                'total_price' => 1000,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        $this->db->table('orders')->insert(
            [
                'order_code' => '1111-1111-1111-1112',
                'order_date' => '2021-04-10 23:59:59',
                'customer_name' => '神戸 花子',
                'customer_email' => 'kobe@example.com',
                'destination_name' => '送付先 太郎',
                'destination_zip' => '1234567',
                'destination_prefecture' => '兵庫県',
                'destination_address' => '送付先住所2',
                'destination_tel' => '078-0000-0000',
                'total_quantity' => 3,
                'total_price' => 2500,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        $this->db->table('orders')->insert(
            [
                'order_code' => '1111-1111-1111-1113',
                'order_date' => '2021-04-11 00:00:00',
                'customer_name' => '奈良 次郎',
                'customer_email' => 'nara@example.com',
                'destination_name' => '送付先 次郎',
                'destination_zip' => '1234567',
                'destination_prefecture' => '奈良県',
                'destination_address' => '送付先住所3',
                'destination_tel' => '0742-0000-0000',
                'total_quantity' => 1,
                'total_price' => 2000,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }

    private function orderDetails()
    {
        $this->db->table('order_details')->insert(
            [
                'order_code' => '1111-1111-1111-1111',
                'detail_no' => 1,
                'item_name' => '商品1',
                'item_price' => 1000,
                'quantity' => 1,
                'subtotal_price' => 1000,
            ]
        );

        $this->db->table('order_details')->insert(
            [
                'order_code' => '1111-1111-1111-1112',
                'detail_no' => 1,
                'item_name' => '商品1',
                'item_price' => 1000,
                'quantity' => 2,
                'subtotal_price' => 2000,
            ]
        );
        $this->db->table('order_details')->insert(
            [
                'order_code' => '1111-1111-1111-1112',
                'detail_no' => 2,
                'item_name' => '商品2',
                'item_price' => 500,
                'quantity' => 1,
                'subtotal_price' => 500,
            ]
        );

        $this->db->table('order_details')->insert(
            [
                'order_code' => '1111-1111-1111-1113',
                'detail_no' => 1,
                'item_name' => '商品3',
                'item_price' => 2000,
                'quantity' => 1,
                'subtotal_price' => 2000,
            ]
        );
    }
}
