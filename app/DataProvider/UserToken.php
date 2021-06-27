<?php

declare(strict_types=1);

namespace App\DataProvider;

use Illuminate\Database\DatabaseManager;
use stdClass;

/**
 * tokenからユーザー情報を検索する処理例
 *
 * リスト 6.2.3.2
 */
final class UserToken implements UserTokenProviderInterface
{
    private $manager;
    private $table = 'user_tokens';

    public function __construct(
        DatabaseManager $manager
    ) {
        $this->manager = $manager;
    }

    /**
     * user_tokensテーブルからレコードを検索
     */
    public function retrieveUserByToken(string $token): ?stdClass
    {
        return $this->manager->connection()
            ->table($this->table)
            ->join('users', 'users.id', '=', 'user_tokens.user_id')
            ->where('api_token', $token)
            ->first(['user_id', 'api_token', 'name', 'email']);
    }
}
