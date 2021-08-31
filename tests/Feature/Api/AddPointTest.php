<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\EloquentCustomer;
use App\Models\EloquentCustomerPoint;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * リスト 9.3.3.1
 *
 * このファイルの生成コマンド
 * $ php artisan make:test Api/AddPointTest
 */
class AddPointTest extends TestCase
{
    // データベースを利用するので、RefreshDatabaseトレイトをuseする
    use RefreshDatabase;

    const CUSTOMER_ID = 1;

    protected function setup(): void
    {
        parent::setUp();

        CarbonImmutable::setTestNow();

        // テストに必要なレコードを登録
        EloquentCustomer::factory()->create(
            [
                'id' => self::CUSTOMER_ID,
            ]
        );
        EloquentCustomerPoint::unguard();
        EloquentCustomerPoint::create(
            [
                'customer_id' => self::CUSTOMER_ID,
                'point' => 100,
            ]
        );
        EloquentCustomerPoint::reguard();
    }

    /**
     * 100ポイント保持している会員に対して、10ポイントを加算するシナリオをテスト
     *
     * @test
     */
    public function put_add_point()
    {
        // API実行
        $response = $this->putJson(
            '/api/customers/add_point',
            [
                'customer_id' => self::CUSTOMER_ID,
                'add_point' => 10,
            ]
        );

        // HTTPレスポンスアサーション
        $response->assertStatus(200);
        $expected = ['customer_point' => 110];
        $response->assertExactJson($expected);

        // データベースアサーション
        $this->assertDatabaseHas(
            'customer_points',
            [
                'customer_id' => self::CUSTOMER_ID,
                'point' => 110,
            ]
        );
        $this->assertDatabaseHas(
            'customer_point_events',
            [
                'customer_id' => self::CUSTOMER_ID,
                'event' => 'ADD_POINT',
                'point' => 10,
                'created_at' => CarbonImmutable::now()->toDateTimeString(),
            ]
        );
    }

    /**
     * 空のパラメータを送信してバリデーションエラーのテストメソッド
     *
     * レスポンスボディのJSON全体が期待値と一致するかを検証するには、
     * assertExactJsonメソッドを利用
     *
     * リスト 9.3.3.2
     *
     * @test
     */
    public function put_add_point_バリデーションエラー()
    {
        $response = $this->putJson('/api/customers/add_point', []);

        $response->assertStatus(422);

        // レスポンスボディ全体を検証
        $expected = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'customer_id' => [
                    'The customer id field is required.',
                ],
                'add_point' => [
                    'The add point field is required.',
                ],
            ],
        ];
        $response->assertExactJson($expected);
    }

    /**
     * バリデーションエラー時に、レスポンスのerrorsプロパティのみを検証
     *
     * ランダムな値を含んでいて全体の一致が難しい場合や、
     * レスポンスボディの一部のみを検証したいケースは、
     * assertJsonメソッドを利用
     *
     * リスト 9.3.3.3
     *
     * @test
     */
    public function put_add_point_バリデーションエラー_errorsのみ検証()
    {
        $response = $this->putJson('/api/customers/add_point', []);

        $response->assertStatus(422);

        // errorsキーのみ検証
        $expected = [
            'errors' => [
                'customer_id' => [
                    'The customer id field is required.',
                ],
                'add_point' => [
                    'The add point field is required.',
                ],
            ],
        ];
        $response->assertJson($expected);
    }

    /**
     * バリデーションエラー時に、レスポンスボディのJSONがを配列に変換して検証
     *
     * jsonメソッドでレスポンスボディのJSONを配列に変換する方法もある
     * 配列に変換すれば、配列を検証するアサーションメソッドが利用できる
     *
     * 検証内容
     * - errorsキーが存在するか
     * - errorsキーの値である配列にcustomer_idキーとadd_pointキーが存在するか
     *
     * リスト 9.3.3.4
     *
     * @test
     */
    public function put_add_point_バリデーションエラー_キーのみ検証()
    {
        $response = $this->putJson('/api/customers/add_point', []);

        $response->assertStatus(422);

        // レスポンスボディJSONを配列に変換して検証
        $jsonValues = $response->json();
        $this->assertArrayHasKey('errors', $jsonValues);

        $errors = $jsonValues['errors'];
        $this->assertArrayHasKey('customer_id', $errors);
        $this->assertArrayHasKey('add_point', $errors);
    }

    /**
     * add_pointが事前条件でエラーになるケース
     *
     * add_pointが1未満の場合、つまり、0もしくは負数の場合に事前条件エラーが発生することを確認
     *
     * リスト 9.3.3.5
     *
     * @test
     * @dataProvider dataProvider_put_add_point_add_point事前条件エラー
     */
    public function put_add_point_add_point事前条件エラー(int $addPoint)
    {
        $response = $this->putJson('/api/customers/add_point', [
            'customer_id' => self::CUSTOMER_ID,
            'add_point' => $addPoint, // データプロバイダの値を指定
        ]);

        // HTTPレスポンスアサーション
        $response->assertStatus(400);
        $expected = [
            'message' => 'add_point should be equals or greater than 1',
        ];
        $response->assertExactJson($expected);
    }

    public function dataProvider_put_add_point_add_point事前条件エラー(): array
    {
        return [
            [0],
            [-1],
        ];
    }

    /**
     * customer_idが事前条件エラーとなるケース
     *
     * customer_idがcustomersテーブルに存在しない場合に事前エラーが発生することを確認
     *
     * リスト 9.3.3.6
     *
     * @test
     */
    public function put_add_point_customer_id事前条件エラー()
    {
        $response = $this->putJson('/api/customers/add_point', [
            'customer_id' => 999, // 存在しないcustomer_id
            'add_point' => 10,
        ]);

        // HTTPレスポンスアサーション
        $response->assertStatus(400);
        $expected = [
            'message' => 'customers.id:999 does not exists',
        ];
        $response->assertExactJson($expected);
    }
}
