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
 * @property int $id
 * @property string $name
 */
class EloquentCustomer extends Model
{
    use HasFactory;

    protected $table = 'customers';
}
