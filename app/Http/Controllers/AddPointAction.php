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
 * curlコマンドによる実行例
 *
 * リスト 9.3.2.9
 */
// TODO: 下記を実行するとNotFoundHttpExceptionになる点の対応
/*
curl -v -H "Accept: application/json" -H "Content-type: application/json" \
-X PUT -d '{"customer_id": 1, "add_point": 10}' \
http://localhost/api/customers/add_point -w "\n"
*/

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
