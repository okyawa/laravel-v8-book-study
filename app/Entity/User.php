<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Authenticatableインターフェース実装クラス
 *
 * リスト 6.2.3.3
 * データベースから取得した値を返却するgetterと
 * Illuminate\Contracts\Auth\Authenticatableインターフェースメソッドを記述しただけのクラス
 * データベースから取得したレコードを認証ユーザーとして扱うためのクラス
 */
class User implements Authenticatable
{
    private $id;
    private $apiToken;
    private $name;
    private $email;
    private $password;

    public function __construct(
        int $id,
        string $apiToken,
        string $name,
        string $email,
        string $password = ''
    ) {
        $this->id = $id;
        $this->apiToken = $apiToken;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getRememberToken()
    {
        return $this->apiToken;
    }

    public function getAuthIdentifierName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAuthIdentifier(): int
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function setRememberToken($value)
    {

    }

    public function getRememberTokenName(): string
    {
        return '';
    }
}
