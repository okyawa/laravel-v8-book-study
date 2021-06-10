<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Authorsテーブルにレコードを10件登録する
        $faker = Factory::create('ja_JP');
        for ($i = 1; $i <= 10; $i++) {
            $author = [
                'name' => $faker->name,
                'kana' => $faker->kanaName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('authors')->insert($author);
        }
    }
}
