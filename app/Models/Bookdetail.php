<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookdetail extends Model
{
    use HasFactory;

    /**
     * 書籍詳細と紐付く書籍レコードを取得
     */
    public function book()
    {
        // 一対一関係の定義
        // belongsTo() メソッドの引数
        // 第1引数にモデル名
        // 第2引数に内部キー (省略可) (初期値は "モデル名_id")
        // 第3引数に外部キー (省略可) (初期値は "id")
        return $this->belongsTo(Book::class);
    }
}
