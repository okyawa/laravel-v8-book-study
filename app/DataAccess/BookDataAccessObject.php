<?php

declare(strict_types=1);

namespace App\DataAccess;

use Illuminate\Database\DatabaseManager;

/**
 * booksテーブルのデータ操作を担う専用クラス
 *
 *   データ操作専用クラスを作ってクエリビルダを利用する例
 */
class BookDataAccessObject
{
    protected DatabaseManager $db;
    protected string $table = 'books';

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    public function find($id)
    {
        $query = $this->db->connection()
            ->table($this->table)
            ->where('id', '=', $id)
            ->first();
    }
}
