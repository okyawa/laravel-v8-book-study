<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class Eloquent extends Controller
{
    public function index(Request $request)
    {
        // リレーション定義されたカラムの呼び出し

        $book = Book::find(1);
        echo $book->detail->isbn;

        $author = Author::find(1);
        foreach ($author->books as $book) {
            echo $book->name;
        }

        exit;
    }
}
