<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * このマイグレーションファイルの生成コマンド
 * $ php artisan make:migration create_user_tokens_table
 */
class CreateUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tokens', function (Blueprint $table) {
            $table->integer('user_id', false, true);
            $table->string('api_token', 60)->unique();
            $table->timestamp('created_at')
                ->useCurrentOnUpdate();

            // 外部キー指定を加えると下記のエラーになるため、一旦コメントアウト
            // SQLSTATE[HY000]: General error: 3780 Referencing column 'user_id' and referenced column 'id' in foreign key constraint 'user_tokens_user_id_foreign' are incompatible.
            // (SQL: alter table `user_tokens` add constraint `user_tokens_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade on update cascade)
            /*
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade')->onUpdate('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_tokens');
    }
}
