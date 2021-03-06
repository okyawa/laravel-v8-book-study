<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 9-2-1 データベーステスト
 *
 * このファイルの生成コマンド
 * $ php artisan make:model EloquentCustomerPoint
 *
 * リスト 9.2.1.9
 *
 * @property int $customer_id
 * @property int $point
 */
class EloquentCustomerPoint extends Model
{
    use HasFactory;

    protected $table = 'customer_points';
    public $timestamps = false; // 自動設定されるタイムスタンプは不要

    public function addPoint(int $customerId, int $point): bool
    {
        return $this->newQuery()
                ->where('customer_id', $customerId)
                ->increment('point', $point) === 1;
    }

    public function findPoint(int $customerId): int
    {
        return $this->newQuery()
            ->where('customer_id', $customerId)
            ->value('point');
    }
}
