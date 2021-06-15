<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderAction extends Controller
{
    public function __invoke(Request $request)
    {
        /**
         * 書籍のISBNコードと書籍名、著者名、出版日をクエリビルダで取得
         *
         *   booksテーブルとbookddetailsテーブル、booksテーブルとauthorsテーブルをそれぞれLEFT JOINで結合し、
         *   書籍の価格(price)が1,000円以上、かつ出版日(published_date)が2011年1月1日以降のレコードを取得
         *
         *   各メソッドは全てクエリビルダのインスタンス(Illuminate\Database\Query\Builder)を戻り値として返すため、
         *   メソッドチェーンを使ってクエリを組み立てることができる
         *
         *   最後にget()やfirst()のメソッドが呼ばれるまでは、データベースに対する処理は実行されない
         *
         *   実行結果はstdClassオブジェクトのコレクションで返される
         */
        $result = DB::table('books')
            ->select([
                'bookdetails.isbn',
                'books.name as title',
                'authors.name as author',
                'booksdetails.price'
            ])
            ->leftJoin('booksdetails', 'books.id', '=', 'booksdetails.book_id')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->where('booksdetails.price', '>=', 1000)
            ->where('booksdetails.published_date', '>=', '2011-01-01')
            ->orderBy('bookdetails.published_date', 'desc')
            ->get();

        // 上記のクエリビルダを素のSQLで記載した場合
        $sql = "
            SELECT
                bookdetails.isbn,
                books.name as title,
                authors.name as author,
                bookdetails.price
            FROM
                books
            LEFT JOIN
                bookdetails ON books.id = bookdetails.book_id
            LEFT JOIN
                authors ON books.author_id = authors.id
            WHERE
                bookdetails.price >= 1000
            AND
                bookdetails.published_date >= '2011-01-01'
            ORDER BY bookdetails.published_date DESC
        ";
    }
}
