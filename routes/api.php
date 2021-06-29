<?php

use App\Http\Controllers\ArticlePayloadAction;
use App\Http\Controllers\PublisherAction;
use App\Http\Controllers\UserAction;
use App\Http\Controllers\User\LoginAction;
use App\Http\Controllers\User\RetrieveAction;
use Illuminate\Http\Request;
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
