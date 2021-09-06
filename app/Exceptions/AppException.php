<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Bladeテンプレートと例外処理組み合わせパターン例
 *
 * 例外処理とレスポンスを結びつける例 (※controller等で呼び出し)
 * 第1引数に指定したテンプレート、第2引数に指定したメッセージがAppExceptionクラスに渡される
 * throw new \App\Exceptions\AppException(view('errors.page), 'error.');
 *
 * リスト 10.1.6.1
 */
class AppException extends RuntimeException implements Responsable
{
    protected $error = 'error';
    private View $factory;

    public function __construct(
        View $factory,
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->factory = $factory;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Illuminate\Contracts\Support\ResponsableのtoResponseメソッドを実装すると、
     * App\Exceptions\Handlerの親クラスである
     * \Illuminate\Foundation\Exceptions\Handlerクラスのrenderメソッドで
     * 例外クラスに合わせたレスポンスを返却する
     *
     * @param $request
     * @return Response
     */
    public function toResponse($request): Response
    {
        return new Response(
            $this->factory->with($this->error, $this->message)->render()
        );
    }
}
