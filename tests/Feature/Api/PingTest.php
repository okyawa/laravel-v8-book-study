<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * このファイルの生成コマンド
 * $ php artisan make:test Api/PingTest
 *
 * リスト 9.3.1.11
 */
class PingTest extends TestCase
{
    /**
     * 汎用的にHTTPリクエストを送信するcallメソッドの定義
     *
     * リスト 9.3.1.5
     */
    /*
    public function call(
        $method,            // HTTPメソッド
        $uri,               // URI
        $parameters = [],   // 送信パラメータ
        $cookies = [],      // cookie
        $files = [],        // アップロードファイル
        $server = [],       // サーバパラメータ
        $content = null     // RAWリクエストボディ
    ): \Illuminate\Testing\TestResponse
    */

    /**
     * callメソッドの実行例
     *
     * リスト 9.3.1.6
     */
    public function executeCall()
    {
        // GETリクエスト - クエリストリング
        $response = $this->call('GET', '/api/get?class=motogp&no=99');

        // GETリクエスト - $parameters
        $response = $this->call('GET', '/api/get', [
            'class' => 'motogp',
            'no' => '99'
        ]);

        // POSTリクエスト
        $response = $this->call('POST', '/api/post', [
            'email' => 'a@example.com',
            'password' => 'secret-password'
        ]);
    }

    /**
     * jsonメソッドの定義
     *
     * リスト 9.3.1.7
     */
    /*
    public function json(
        $method,
        $uri,
        array $data = [],
        array $headers = []
    ): \Illuminate\Testing\TestResponse;
    */

    /**
     * jsonメソッドで設定されているリクエストヘッダ
     *
     * Content-Length   JSONデータサイズ (byte)
     * Content-Type     application/json
     * Accept           application/json
     *
     * 表 9.3.1.8
     */

    /**
     * 主なHTTPリクエストシミュレートメソッド
     *
     * callメソッドやjsonメソッドには、HTTPメソッドごとにラップしたメソッド、ラッパーメソッドが用意されている
     * 通常はラッパメソッドを利用して、細かなパラメータ指定が必要な場合にはcallメソッドやjsonメソッドを利用するのが良い
     *
     * get($uri, array $headers = [])                           GETリクエスト
     * getJson($uri, array $headers = [])                       GETリクエスト (JSON)
     * post($uri, array $data = [], array $headers = [])        POSTリクエスト
     * postJson($uri, array $data = [], array $headers = [])    POSTリクエスト (JSON)
     * put($uri, array $data = [], array $headers = [])         PUTリクエスト
     * putJson($uri, array $data = [], array $headers = [])     PUTリクエスト (JSON)
     * patch($uri, array $data = [], array $headers = [])       PATCHリクエスト
     * patchJson($uri, array $data = [], array $headers = [])   PATCHリクエスト (JSON)
     * delete($uri, array $data = [], array $headers = [])      DELETEリクエスト
     * deleteJson($uri, array $data = [], array $headers = [])  DELETEリクエスト (JSON)
     *
     * 表 9.3.1.9
     */

    /**
     * HTTPレスポンスのアサーション (Illuminate\Testing\TestResponse)
     *
     * 送信したHTTPリクエストに対するHTTPレスポンスを検証するアサーションメソッドが用意されている
     * Tests\TestCaseクラスよりも、HTTPリクエスト送信メソッドの戻り値であるIlluminate\Testing\TestResponseの方が、
     * 送信したリクエストに特化したアサーションの記述が用意なので、こちらを利用する
     * HTTPステータスコードとレスポンスボディの検証を主に、必要であればヘッダやクッキーの検証を実施すると良い
     *
     * assertStatus($status)                    HTTPステータスコードが$statusに一致していれば成功
     * assertSuccessful()                       HTTPステータスコードが2xxなら成功
     * assertRedirect($uri = null)              HTTPステータスコードが201,301,302,303,307,308のいずれかで、かつLocationヘッダの値がapp('url')->to($url)の値と一致すれば成功
     * assertHeader($headerName, $value = null) レスポンスヘッダが存在($valueがnullの場合)、もしくは該当のレスポンスヘッダの値が$valueと一致すれば成功
     * assertHeaderMissing($headerName)         指定したレスポンスヘッダが存在しなければ成功
     * assertExactJson(array $data)             レスポンスボディのJSONをデコードした配列が$dataと一致すれば成功
     * assertJson($value, $strict = false)      レスポンスボディのJSONをデコードした配列に$dataが含まれていれば成功
     *
     * 表 9.3.1.10
     */

    /**
     * PingTestクラスにping APIのテストを実装
     *
     * リスト 9.3.1.11
     * @test
     */
    public function get_ping()
    {
        $response = $this->get('/api/ping');
        // HTTPステータスコードを検証
        $response->assertStatus(200);
        // レスポンスボディのJSONを検証
        $response->assertExactJson(['message' => 'pong']);
    }
}
