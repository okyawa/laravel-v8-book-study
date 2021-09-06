<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * APIのJSONレスポンスと例外処理の組み合わせパターン例
 *
 * REST APIに採用されることも多いHypertext Application Languageと互換性を持つ
 * vnd.errorを採用する場合の例
 *
 * リスト 10.1.6.3
 */
class UserResourceException extends RuntimeException implements Responsable
{
    public function __construct(
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function toResponse($request): Response
    {
        return new JsonResponse([
            'message' => $this->message,
            'path' => $request->getRequestUri(),
            'logref' => 44,
            '_links' => [
                'about' => [
                    'href' => $request->getUri()
                ]
            ],
        ], Response::HTTP_NOT_FOUND, [
            'content-type' => 'application/vnd.error+json'
        ]);
    }
}

/**
 * vnd.errorレスポンス返却例
 *
 * JsonResponse上記の例外クラスをスローすると、次のレスポンスが返却される
 *
 * リスト 10.1.6.4
 */
/*
{
    "message": "resource not found",
    "path": "/home",
    "logref": 44,
    "_links": {
        "about": {
            "href": "http://localhost/home"
        }
    }
}
*/
