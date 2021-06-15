<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentAction extends Controller
{
    public function __invoke(Request $request)
    {
        /**
         * リレーション定義されたカラムの呼び出し
         */

        $book = Book::find(1);
        echo $book->detail->isbn;

        $author = Author::find(1);
        foreach ($author->books as $book) {
            echo $book->name;
        }

        /**
         * 実行されるSQLの確認
         */

        // 適用されるSQL文の取得 (SQLの生成のみで実行はされない)
        $sql = Author::where('name', '=', '著者A')->toSql();
        echo $sql; // select * from `authors` where `name` = ?

        /**
         * リクエスト内で実行された全てのSQLを取得
         */

        // SQLの保存を有効化
        DB::enableQueryLog();

        // データ操作実行
        $authors = Author::find([1, 3, 5]);

        // クエリを取得
        $queries = DB::getQueryLog();

        // SQL保存を無効化
        DB::disableQueryLog();

        // getQueryLog()メソッドにより取得できるSQL文
        var_dump($queries);
        // array:1 [
        //     0 => array:3 [
        //         "query" => "select * from `authors` where `authors`.`id` in (?, ?, ?)"
        //         "bindings" => array:3 [
        //             0 => 1
        //             1 => 3
        //             2 => 5
        //         ]
        //         "time" => 11.55
        //     ]
        // ]

        exit;
    }
}
