<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * 書籍と紐付く書籍詳細レコードを取得
     */
    public function detail()
    {
        // 一対一関係の定義
        // hasOne() メソッドの引数
        // 第1引数にモデル名
        // 第2引数に内部キー (省略可) (初期値は "モデル名_id")
        // 第3引数に外部キー (省略可) (初期値は "id")
        return $this->hasOne(Bookdetail::class);
    }

    /**
     * 書籍と紐付く著者レコードを取得
     */
    public function author()
    {
        // 一対多の逆向きの関係を定義 (一対一のリレーションと同様)
        // belongsTo() メソッドの引数
        // 第1引数にモデル名
        // 第2引数に内部キー (省略可) (初期値は "モデル名_id")
        // 第3引数に外部キー (省略可) (初期値は "id")
        return $this->belongsTo(Author::class);
    }
}
