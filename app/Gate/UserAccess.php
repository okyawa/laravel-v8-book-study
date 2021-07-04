<?php

declare(strict_types=1);

namespace App\Gate;

use App\Models\User;
use function intval;

/**
 * 1つの認可処理を1つのクラスとして表現する例
 *
 * リスト 6.5.2.3
 */
final class UserAccess
{
    public function __invoke(User $user, string $id): bool
    {
        return intval($user->getAuthIdentifier()) === intval($id);
    }
}
