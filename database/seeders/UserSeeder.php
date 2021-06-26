<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * このクラスの生成コマンド
 * $ php artisan make:seeder UserSeeder
 *
 * このSeederクラスだけ個別に実行するコマンド
 * $ php artisan db:seed --class=UserSeeder
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(DatabaseManager $manager, Hasher $hasher): void
    {
        $datetime = Carbon::now()->toDateTimeString();
        // usersテーブルにレコードをインサートし、インサート時に発行されたプライマリーキーを取得
        $userId = $manager->table('users')
            ->insertGetId(
                [
                    'name' => 'laravel user',
                    'email' => 'mail@example.com',
                    'password' => $hasher->make('password'),
                    'created_at' => $datetime,
                ]
            );
        // usersテーブルのプライマリーキーを使ってuser_tokensにレコードをインサート
        $manager->table('user_tokens')
            ->insert(
                [
                    'user_id' => $userId,
                    'api_token' => Str::random(60),
                    'created_at' => $datetime,
                ]
            );
    }
}
