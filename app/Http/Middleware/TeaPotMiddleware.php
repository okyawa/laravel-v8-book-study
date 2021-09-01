<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

/**
 * ミドルウェアの無効化テスト用
 *
 * 9-3-4
 */
class TeaPotMiddleware
{
    /**
     * @return never
     */
    public function handle($request, Closure $next)
    {
        abort(418);
    }
}
