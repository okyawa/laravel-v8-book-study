<?php

use App\Console\Kernel;
use App\Http\Controllers\AddPointAction;
use App\Http\Controllers\ArticlePayloadAction;
use App\Http\Controllers\PublisherAction;
use App\Http\Controllers\User\LoginAction;
use App\Http\Controllers\User\RetrieveAction;
use App\Http\Controllers\UserAction;
use App\Http\Middleware\TeaPotMiddleware;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/payload', ArticlePayloadAction::class);
Route::post('/publishers', [PublisherAction::class, 'create']);
Route::get('/users', UserAction::class);

/**
 * JWT認証 ルーティング作成例
 *
 * リスト 6.3.3.1
 */
Route::group(['middleware' => 'api'], function ($router) {
    // ログインを行わない、アクセストークンを発行するルート
    Route::post('/user/login', LoginAction::class);
    // アクセストークンを用いて、認証ユーザーの情報を取得するルート
    Route::post('/users/', RetrieveAction::class)
        ->middleware('auth:jwt');
});

/**
 * Laravelアプリケーション内部からCommandの実行
 *
 * リスト 8.1.5.1, 8.1.5.2
 */
// 引数なし
Route::get('/hello', function () {
    Artisan::call('hello:class');
});
// 引数あり
Route::get('/hello', function () {
    Artisan::call('hello:class', [
        'name' => 'Johann',
        '--switch' => true,
    ]);
});
// Artisanファサードを使わずにCommand実行
Route::get('/hello', function (Kernel $artisan) {
    $artisan->call('hello:class');
});


/**
 * 購入情報バッチ処理JSON出力の仮受信API
 *
 * リスト 8.3.3.4
 */
Route::post('/import-orders', function (Request $request) {
    $json = $request->getContent();
    file_put_contents('/tmp/orders', $json);

    return response('ok');
});


/**
 * ping/pong API
 *
 * curlコマンドによる実行例
 * $ curl -v http://localhost/api/ping -w "\n"
 *
 * リスト 9.3.1.1
 */
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

/**
 * WebAPIテスト
 *
 * リスト 9.3.2.5
 */
Route::put('/customers/add_point', AddPointAction::class);

/**
 * WebAPIテストに便利な機能
 *
 * 9-3-4
 */
Route::middleware(TeaPotMiddleware::class)->get(
    '/live',
    function () {
        return response()->json(['message' => 'working']);
    }
);
Route::middleware('auth:sanctum')->get(
    '/sanctum-user',
    function (Request $request) {
        return $request->user();
    }
);

/**
 * コンポーネントのモック(Fake) - アサーションメソッドで送信内容が検証できる送信例
 *
 * リスト 9.3.4.7
 */
Route::post('/send-email', function (Request $request, Mailer $mailer) {
    // App\Mail\Sampleは、Mailableインターフェースを実装したクラス
    $mail = new App\Mail\Sample();
    // sendメソッドにMailableインターフェースを実装したクラスを指定
    $mailer->to($request->get('to'))->send($mail);

    return response()->json('ok');
});
