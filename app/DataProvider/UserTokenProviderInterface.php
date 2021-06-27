<?php

declare(strict_types=1);

namespace App\DataProvider;

use stdClass;

/**
 * tokenを引数に利用するユーザー情報取得インターフェース作成例
 *
 * リスト 6.2.3.1
 */
interface UserTokenProviderInterface
{
    /**
     * @param string $token
     * @return stdClass|null
     */
    public function retrieveUserByToken(
        string $token
    ): ?stdClass;
}
