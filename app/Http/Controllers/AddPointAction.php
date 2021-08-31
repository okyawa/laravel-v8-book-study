<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AddPointRequest;
use App\UseCases\AddPointUseCase;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * WebAPIのテスト用Action
 *
 * このファイルの生成コマンド
 * $ php artisan make:controller AddPointAction
 *
 * リスト 9.3.2.3
 */
class AddPointAction extends Controller
{
    private AddPointUseCase $useCase;

    public function __construct(AddPointUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param AddPointRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function __invoke(AddPointRequest $request): JsonResponse
    {
        // JSONからパラメータを取得
        $customerId = filter_var($request->json('customer_id'), FILTER_VALIDATE_INT);
        $addPoint = filter_var($request->json('add_point'), FILTER_VALIDATE_INT);

        // ポイント加算ユースケース実行
        $customerPoint = $this->useCase->run(
            $customerId,
            $addPoint,
            'ADD_POINT',
            CarbonImmutable::now()
        );

        // レスポンス生成
        return response()->json(['customer_point' => $customerPoint]);
    }
}

/**
 * curlコマンドによる実行例 - 正常パターン
 *
 * 送信したJSONに合致するcustomer_idの保有ポイントが加算され、
 * その結果がレスポンスとして返される
 *
 * リスト 9.3.2.9
 */
/*
curl -v -H "Accept: application/json" -H "Content-type: application/json" \
-X PUT -d '{"customer_id": 1, "add_point": 10}' \
http://localhost/api/customers/add_point -w "\n"
*/
// *   Trying 127.0.0.1:80...
// * TCP_NODELAY set
// * Connected to localhost (127.0.0.1) port 80 (#0)
// > PUT /api/customers/add_point HTTP/1.1
// > Host: localhost
// > User-Agent: curl/7.68.0
// > Accept: application/json
// > Content-type: application/json
// > Content-Length: 35
// >
// * upload completely sent off: 35 out of 35 bytes
// * Mark bundle as not supporting multiuse
// < HTTP/1.1 200 OK
// < Host: localhost
// < Date: Tue, 31 Aug 2021 20:23:01 GMT
// < Connection: close
// < X-Powered-By: PHP/8.0.5
// < Cache-Control: no-cache, private
// < Date: Tue, 31 Aug 2021 20:23:01 GMT
// < Content-Type: application/json
// < X-RateLimit-Limit: 60
// < X-RateLimit-Remaining: 59
// < Access-Control-Allow-Origin: *
// <
// * Closing connection 0
// {"customer_point":110}

/**
 * curlコマンドによる実行例 - 事前条件エラー
 *
 * add_pointを0で送信しているため、
 * 事前条件エラーが発生してエラーレスポンスが返される
 *
 * リスト 9.3.2.10
 */
/*
curl -v -H "Accept: application/json" -H "Content-type: application/json" \
-X PUT -d '{"customer_id": 1, "add_point": 0}' \
http://localhost/api/customers/add_point -w "\n"
*/
// *   Trying 127.0.0.1:80...
// * TCP_NODELAY set
// * Connected to localhost (127.0.0.1) port 80 (#0)
// > PUT /api/customers/add_point HTTP/1.1
// > Host: localhost
// > User-Agent: curl/7.68.0
// > Accept: application/json
// > Content-type: application/json
// > Content-Length: 34
// >
// * upload completely sent off: 34 out of 34 bytes
// * Mark bundle as not supporting multiuse
// < HTTP/1.1 400 Bad Request
// < Host: localhost
// < Date: Tue, 31 Aug 2021 20:28:20 GMT
// < Connection: close
// < X-Powered-By: PHP/8.0.5
// < Cache-Control: no-cache, private
// < Date: Tue, 31 Aug 2021 20:28:20 GMT
// < Content-Type: application/json
// < X-RateLimit-Limit: 60
// < X-RateLimit-Remaining: 59
// < Access-Control-Allow-Origin: *
// <
// * Closing connection 0
// {"message":"add_point should be equals or grater than 1"}
