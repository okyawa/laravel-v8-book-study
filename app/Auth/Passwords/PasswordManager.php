<?php

declare(strict_types=1);

namespace App\Auth\Passwords;

use App\Auth\Passwords\CustomTokenRepository;
use Illuminate\Support\Str;
use Illuminate\Auth\Passwords\PasswordBrokerManager;

/**
 * パスワードリセットの拡張例
 *
 * リスト 6.1.6.1
 */
class PasswordManager extends PasswordBrokerManager
{
    // --[略]--

    protected function createTokenRepository(array $config)
    {
        $key = $this->app['config']['app.key'];

        if (Str::startsWith($key, 'base64')) {
            $key = base64_decode(substr($key, 7));
        }

        $connection = $config['connection'] ?? null;

        return new CustomTokenRepository(
            $this->app['db']->connection($connection),
            $this->app['hash'],
            $config['table'],
            $key,
            $config['expire'],
            $config['throttle'] ?? 0
        );
    }
}
