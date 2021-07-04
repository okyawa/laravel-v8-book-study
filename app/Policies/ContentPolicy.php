<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;
use stdClass;

/**
 * ポリシー
 *
 * ポリシーは、リソースに対する認可処理をまとめて記述する仕組み
 */

/**
 * ポリシークラス作成例
 *
 * リスト 6.2.5.6
 * ポリシークラスを作成するartisanコマンド
 *
 * $ php artisan make:policy ContentPolicy
 */

/**
 * Eloquentモデルを利用しないポリシー
 * PHPのビルトインクラスを使ったポリシー実装例
 *
 * リスト 6.5.2.12
 */
class ContentPolicy
{
    use HandlesAuthorization;

    public function edit(
        Authenticatable $authenticatable,
        stdClass $class
    ): bool {
        // stdClassのプロパティにidがあるかどうかを調べる
        if (property_exists($class, 'id')) {
            // 存在する場合は認証ユーザーのidと同じ値であるかを比較し、同じ値であれば実行可能とする例
            return intval($authenticatable->getAuthIdentifier() === intval($class->id));
        }
        return false;
    }
}
