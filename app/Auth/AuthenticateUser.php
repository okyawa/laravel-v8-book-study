<?php

declare(strict_types=1);

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Laravel標準とテーブルと大きく異るテーブルを用いる場合の例
 *
 * 標準とは異なるテーブル定義
 * user_id    PRIMARY KEY
 * user_name  ユーザー名
 * email      UNIQUE
 * password   パスワード
 * created_at 作成日時
 * updated_at 更新日時
 */
class AuthenticateUer implements Authenticatable
{
    protected $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAuthIdentifierName(): string
    {
        return 'user_id';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes[$this->getAuthIdentifierName()];
    }

    public function getAuthPassword(): string
    {
        return $this->attributes['password'];
    }

    public function getRememberToken(): string
    {
        return $this->attributes[$this->getRememberTokenName()];
    }

    public function setRememberToken($value)
    {
        $this->attributes[$this->getRememberTokenName()] = $value;
    }

    public function getRememberTokenName(): string
    {
        // 自動ログインを利用しないケースなため、返却する文字列は不要
        return '';
    }
}
