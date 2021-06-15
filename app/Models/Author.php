<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;

    // 論理削除を有効にするSoftDeletesトレイトを定義
    // (予め、テーブルにdeleted_atカラムが追加されている必要あり)
    use SoftDeletes;

    // t_authorテーブルを関連付ける
    # protected $table = 't_author';

    // テーブルの主キーを id ではなく author_id とする
    # protected $primaryKey = 'author_id';

    // タイムスタンプを記録しない (デフォルトはtrue)
    # protected $timestamps = false;

    // $connection →データベース接続 (default: 設定ファイルdatabase.phpで設定されたデフォルト)
    // $dateFormat →タイムスタンプのフォーマット (default: "Y-m-d H:i:s")
    // $incrementing →プライマリーキーが自動増加化 (default: true)

    /**
     * Mass Assignmentによる脆弱性への対策
     *
     * (デフォルトでは全てのフィールドでMass Assignmentが無効)
     * ($fillableと$guardedは、同時には利用できない)
     */

    // nameとkanaカラムを指定可能にする
    protected $fillable = [
        'name',
        'kana',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];


    /**
     * アクセサとミューテータの定義
     */

    // アクセサはEloquentクラスに「get(カラム名)Attribute」の名前でメソッドを追加
    public function getKanaAttribute(string $value): string
    {
        // kanaカラムの値を半角カナに変換
        return mb_convert_kana($value, 'k');
    }

    // ミューテータはEloquentクラスに「set(カラム名)Attribute」の名前でメソッドを追加
    public function setKanaAttribute(string $value): void
    {
        // kanaカラムの値を全角カナに変換
        $this->attributes['kana'] = mb_convert_kana($value, 'KV');
    }

    /**
     * 著者と紐付く書籍レコードを取得
     */
    public function books()
    {
        // 一対多関係の定義
        // hasMany() メソッドの引数
        // 第1引数にモデル名
        // 第2引数に内部キー (省略可) (初期値は "モデル名_id")
        // 第3引数に外部キー (省略可) (初期値は "id")
        return $this->hasMany(Book::class);
    }
}
