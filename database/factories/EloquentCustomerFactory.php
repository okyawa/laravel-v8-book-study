<?php

namespace Database\Factories;

use App\Models\EloquentCustomer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * このファイルの生成コマンド
 * $ php artisan make:factory EloquentCustomerFactory
 *
 * FactoryはEloquentのインスタンスを生成することになるので、
 * 「Eloquentクラス名+Factory」の名称にするのが良い
 *
 * リスト 9.2.2.5, 9.2.2.6
 */
class EloquentCustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EloquentCustomer::class; // Eloquentクラス名を指定

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 生成するレコードを指定
        return [
            'name' => $this->faker->name(),
        ];
    }

    /**
     * リスト 9.2.2.8 factoryメソッドの利用例
     *
     * // customersテーブルに1レコードを登録
     * EloquentCustomer::factory()->create();
     *
     * // customersテーブルに1レコードを登録 (nameを指定)
     * EloquentCustomer::factory()->create([
     *     'name' => '名前',
     * ]);
     *
     * // customersテーブルに3レコードを登録
     * EloquentCustomer::factory()->count(3)->create();
     */

    /**
     * リスト 9.2.2.9 データベースのアサーションメソッド例
     *
     * // customersテーブルにid=1のレコードが存在すれば成功
     * $this->assertDatabaseHas('customers', [
     *     'id' => 1,
     * ]);
     *
     * // customersテーブルにid=100のレコードが存在しなければ成功
     * $this->assertDatabaseMissing('customers', [
     *     'id' => 100,
     * ]);
     */

    /**
     * リスト 9.2.2.10 クエリビルダを利用したアサーション例
     *
     * アサーションメソッドでは検証できないケース
     * 指定した条件のレコード数を測りたい場合
     * Eloquentのクエリビルダを利用して検証
     *
     * // customersテーブルに5件のレコードがあれば成功
     * $this->assertSame(5, \DB::table('customers')->count());
     */
}
