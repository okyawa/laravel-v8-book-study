<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 購入情報テーブル
 */
class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('order_code', 32); // 購入番号 (UNIQUE)
            $table->dateTime('order_date'); // 購入日時
            $table->string('customer_name', 100); // 購入者指名
            $table->string('customer_email', 255); // 購入者メールアドレス
            $table->string('destination_name', 100); // 送付先指名
            $table->string('destination_zip', 10); // 送付先郵便番号
            $table->string('destination_prefecture', 10); // 送付先都道府県
            $table->string('destination_address', 100); // 送付先住所
            $table->string('destination_tel', 20); // 送付先電話番号
            $table->integer('total_quantity'); // 購入件数
            $table->integer('total_price'); // 合計金額
            $table->timestamps();

            $table->unique('order_code');
            $table->index('order_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
