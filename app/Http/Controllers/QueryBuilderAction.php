<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
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

        /**
         * DBファサードからbooksテーブルのクエリビルダを取得
         */
        $query = DB::table('books');

        /**
         * Connectionオブジェクトからクエリビルダを取得
         *
         *   実際のデータ操作でクエリビルダを使う場合は、専用クラスを作成
         *   コンストラクタインジェクションを利用して、クエリビルダ提供元のクラスを外から与えると、
         *   拡張性やテスト容易性を保つことも可能
         */
        // サービスコンテナからDatabaseManagerクラスのインスタンスを取得
        $db = Application::getInstance()->make('db');
        // 上記インスタンスからConnectionクラスのインスタンスを取得
        $connection = $db->connection();
        // 上記インスタンスからクエリビルダを取得
        $query = $connection->table('books');

        /**
         * select系メソッド
         */
        // 取得対象カラム名を指定: select(カラム名配列)
        $result = DB::table('books')
            ->select('id', 'name as title')
            ->get();
        // selectの中身をSQLで直接指定: selectRaw(SQL文)
        $result = DB::table('books')
            ->selectRaw('id, name as title')
            ->get();

        /**
         * where系メソッド
         *
         *   where系メソッドは連続して呼ぶとAND条件となる
         *   OR条件を指定する場合は、メソッドの先頭にorを付与
         *
         *   whereBetween('カラム名', '範囲')     betweenを使用した範囲指定
         *   whereNotBetween('カラム名', '範囲')  not betweenを使用した範囲指定
         *   whereIn('カラム名', '条件値')        inを使用した条件指定
         *   whereNotIn('カラム名', '条件値')     not inを使用した条件指定
         *   whereNull('カラム名')               is nullを使用した条件指定
         *   whereNotNull('カラム名')            is not nullを使用した条件指定
         */
        $result = DB::table('books')
            ->where('id', '>=', 30)
            ->orWhere('created_at', '>=', '2018-01-01')
            ->get();

        /**
         * limitとoffsetメソッド
         *
         *   limit()メソッドとtake()メソッドは同じ処理
         *   offset()メソッドとskip()メソッドは同じ処理
         */
        $result = DB::table('books')
            ->limit(10)
            ->offset(6)
            ->get();

        /**
         * 集計系のメソッド
         *
         *   orderBy('カラム名', '方向')               ソート対象のカラムとソート方向を指定するorder by句に置き換わる
         *   groupBy('カラム名')                      カラムのグルーピングを行うgroup by句に置き換わる
         *   having('カラム名', '比較演算子', '条件値')  havingを利用した絞り込み
         *   havingRaw('SQL')                        having句の中身をSQLで直接指定する
         */
        $result = DB::table('books')
            ->orderBy('id')
            ->orderBy('updated_at', 'desc')
            ->get();

        /**
         * テーブル結合を行うメソッド
         *
         *   join('結合テーブル', '結合対象カラム', '演算子', '結合対象カラム')       テーブル間の内部結合で、inner join句に置き換わる
         *   leftJoin('結合テーブル', '結合対象カラム', '演算子', '結合対象カラム')   テーブル間の左外部結合で、left join句に置き換わる
         *   rightJoin('結合テーブル', '結合対象カラム', '演算子', '結合対象カラム')  テーブル間の右外部結合で、right join句に置き換わる
         */
        $result = DB::table('books')
            ->leftJoin('authors', 'books.author_id', '=', 'author.id')
            ->leftJoin('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->get();

        /**
         * クエリを実行して結果を得るメソッド
         *
         *   get()    全てのデータを取得 (stdClassオブジェクトのコレクション)
         *   first()  最初の1行を崇徳 (オブジェクト単体)
         */
        $result = DB::table('books')
            ->select('id', 'name')
            ->get();
        foreach ($result as $book) {
            echo $book->id;
            echo $book->name;
        }

        /**
         * レコード数の取得や計算を行うメソッド
         *
         *   count()         データの件数を取得
         *   max('カラム名')  カラムの最大値を取得
         *   min('カラム名')  カラムの最小値を取得
         *   avg('カラム名')  カラムの平均値を取得
         */
        $count = DB::table('books')
            ->count();
        echo $count;

        /**
         * データの登録、更新、削除
         *
         *   insert(['カラム' => '値', ...])  insertによるデータ登録
         *   update(['カラム' => '値', ...])  updateによるデータ登録
         *   delete()                        deleteによるデータ削除
         *   truncate()                      truncateによる全行削除
         */
        // 絞り込んだデータに対してい更新を実施
        DB::table('bookdetails')
            ->where('id', 1)
            ->update(['price' => 10000]);
        // update `bookdetails` set `price` = 10000 `id` = 1

        /**
         * トランザクションとテーブルロック
         *
         *   Eloquentを利用したデータ操作でも利用可能
         *
         *   トランザクション系のメソッド
         *     DB::beginTransaction()     手動でトランザクションを開始
         *     DB::rollback()             手動でロールバックを実行
         *     DB::commit()               手動でトランザクションをコミット
         *     DB::transaction(クロージャ)  クロージャ内でトランザクションを実施
         *
         *   悲観的テーブルロックのためのメソッド
         *     sharedLock()     selectされた行に共有ロックをかけ、トランザクションコミットまで更新を禁止
         *     lockForUpdate()  selectされた行に排他ロックをかけ、トランザクションコミットまで読み取りと更新を禁止
         */
    }
}
