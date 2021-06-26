<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;

/**
 * 実行コマンド
 * $ php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // authorsテーブルにデータ登録を行う処理
        $this->call(AuthorsTableSeeder::class);

        // publishersテーブルに50件のレコードを作成する
        Publisher::factory(50)->create();
    }
}
