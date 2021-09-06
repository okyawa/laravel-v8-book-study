<?php

namespace App\Exceptions;

use Fluent\Logger\FluentLogger;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * アプリケーション内でハンドリングされなかった例外のエラーハンドリングを担うクラス
 */
class Handler extends ExceptionHandler
{
    /**
     * 記録処理から除外する例外クラス名を指定
     *
     * リスト 10.1.3.2
     *
     * @var array
     */
    protected $dontReport = [
        // \Carbon\Exceptions\InvalidDateException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Reportメソッドで処理されない例外
     *
     * 下記の例外クラスは、例外発生時にApp\Exceptions\Handlerクラスで補足されても、
     * reportメソッドでは記録する処理が実行されない
     *
     * \Illuminate\Auth\AuthenticationException
     * \Illuminate\Auth\Access\AuthorizationException
     * \Symfony\Component\HttpKernel\Exception\HttpException
     * \Illuminate\Http\Exceptions\HttpResponseException
     * \Illuminate\Database\Eloquent\ModelNotFoundException
     * \Illuminate\Database\MultipleRecordsFoundException
     * \Illuminate\Database\HttpFoundation\Exception\SuspiciousOperationException
     * \Illuminate\Session\TokenMismatchException
     * \Illuminate\Validation\ValidationException
     *
     * 表 10.1.3.1
     */

    /**
     * 発生した例外をログに書き込む
     *
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        /**
         * 例外をFluentdに送信する
         *
         * このクラスにはコンストラクタインジェクションでフレームワークのApplicationクラス自身が渡されるため、
         * 親クラスに記述されているcontainerプロパティを通じて、
         * サービスプロバイダに登録した\Fluent\Logger\FluentLoggerクラスのインスタンスを取得し、
         * postメソッドを利用してFluentdへ送信する
         *
         * リスト 10.1.4.3
         */
        // \Illuminate\Foundation\Exceptions\Handlerクラスのreportメソッドを実行
        /*
        parent::report($exception);
        $fluentLogger = $this->container->make(FluentLogger::class);
        $fluentLogger->post('report', ['error' => $exception->getMessage()]);
        */
    }

    /**
     * エラー発生時にレスポンスを生成
     *
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        /**
         * リスト 9.3.2.8 エラーレスポンスの設定
         */
        $this->renderable(function (PreconditionException $e) {
            return response()->json(
                ['message' => trans($e->getMessage())],
                Response::HTTP_BAD_REQUEST
            );
        });
    }
}
