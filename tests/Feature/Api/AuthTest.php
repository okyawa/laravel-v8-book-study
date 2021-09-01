<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * 認証のテスト
 *
 * 認証が必要なAPIをテストするには2つの方法がある
 * - ミドルウェアを無効にする方法
 * - 認証を担うファサードのテスト用機能を利用する方法
 *
 * 9-3-4
 */
class AuthTest extends TestCase
{
    /**
     * ミドルウェアを無効にしたテスト例
     *
     * withoutMiddlewareメソッドでミドルウェアを無効にし、
     * Factoryで生成したユーザーをactingAsメソッドで設定する
     *
     * テストを実行すると、コントローラやアクションでは Auth::user() などでこのユーザを取得できる
     *
     * リスト9.3.4.4
     *
     * @test
     */
    public function ミドルウェアを無効にしてactingAsで認証ユーザ設定()
    {
        $user = User::factory()->create(
            [
                'name' => 'Mike',
            ]
        );

        // ミドルウェアを無効にして、認証ユーザーを設定
        $response = $this->withoutMiddleware()
            ->actingAs($user)
            ->getJson('/api/user');

        $response->assertStatus(200);
        $response->assertJson(
            [
                'name' => 'Mike',
            ]
        );
    }

    /**
     * Sanctum::actingAsメソッドを利用したテスト例
     *
     * 認証を担うファサードのテスト用機能を利用する方法の場合、
     * 認証にはSanctumやPassportを利用している場合の方法になる
     *
     * SanctumにはSanctumファサードが用意されており、このファサードにはactingAsメソッドがある
     * これを実行すると認証処理をテスト用に置き換えて、
     * アプリケーションでは指定した認証ユーザを取得できるようになる
     *
     * Sanctum::actingAsメソッドの第1引数にはUserインスタンスを指定する
     * 第2引数には付与するアビリティを指定する
     * 全てのアビリティを指定する場合は '*' を含める
     *
     * @test
     */
    public function sanctum_actingAs()
    {
        Sanctum::actingAs(
            User::factory()->create(
                [
                    'name' => 'Mike',
                ]
            ),
            ['*']
        );

        $response = $this->getJson('/api/sanctum-user');

        $response->assertStatus(200);
        $response->assertJson(
            [
                'name' => 'Mike',
            ]
        );
    }
}
