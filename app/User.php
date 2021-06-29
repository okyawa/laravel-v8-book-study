<?php

declare(strict_types=1);

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Tymon\JWTAuth\Contracts\JWTSubjectインターフェース実装例
 *
 * リスト 6.3.2.1
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * ユーザーを特定できる一意な値を返却
     *
     * Eloquentモデルであればプライマリーキーなどが返却される
     */
    public function getJWTIdentifier(): int
    {
        return $this->getKey();
    }

    /**
     * JWTで利用するクレーム情報で、追加したいクレーム情報があれば配列で指定
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
