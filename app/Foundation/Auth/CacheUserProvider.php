<?php

declare(strict_types=1);

namespace App\Foundation\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

use function hash_equals;
use function is_null;
use function sprintf;

/**
 * キャッシュ併用認証ドライバの実装例
 *
 * providerのカスタマイズ (キャッシュ機能組み込みによるパフォーマンス改善)
 * リスト 6.1.5.1
 */
class CacheUserProvider extends EloquentUserProvider
{
    protected $cache;
    protected $cacheKey = "authentication:user:%s";
    protected $lifetime;

    public function __construct(
        HasherContract $hasher,
        string $model,
        CacheRepository $cache,
        int $lifetime = 120
    )
    {
        parent::__construct($hasher, $model);
        $this->cache = $cache;
        $this->lifetime = $lifetime;
    }

    /**
     * キャッシュが破棄されるまでキャッシュからユーザー情報を取得
     */
    public function retrieveById($identifier)
    {
        $cacheKey = sprintf($this->cacheKey, $identifier);
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        $result = parent::retrieveById($identifier);
        if (is_null($result)) {
            return null;
        }
        $this->cache->add($cacheKey, $result, $this->lifetime);
        return $result;
    }

    public function retrieveByToken($identifier, $token)
    {
        $model = $this->retrieveById($identifier);
        if (!$model) {
            return null;
        }
        $rememberToken = $this->model->getRememberToken();
        return $rememberToken && hash_equals($rememberToken, $token) ? $model : null;
    }
}
