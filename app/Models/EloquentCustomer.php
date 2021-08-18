<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 9-2-1 データベーステスト
 *
 * このファイルの生成コマンド
 * $ php artisan make:model EloquentCustomer
 *
 * factoryクラスの生成コマンド
 * $ php artisan make:factory EloquentCustomerFactory
 *
 * @property int $id
 * @property string $name
 */
class EloquentCustomer extends Model
{
    /**
     * リスト 9.2.2.4
     *
     * Factoryを利用するEloquentクラスでは、HasFactory をuseする
     */
    use HasFactory;

    protected $table = 'customers';
}
