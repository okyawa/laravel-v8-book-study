<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->string('order_code', 32); // 購入番号 (PK/FK)
            $table->integer('detail_no'); // 明細番号 (PK)
            $table->string('item_name', 100); // 商品名
            $table->integer('item_price'); // 商品価格
            $table->integer('quantity'); // 購入数
            $table->integer('subtotal_price'); // 小計

            $table->primary(['order_code', 'detail_no']);

            $table->index('order_code');
            $table->foreign('order_code')->references('order_code')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
