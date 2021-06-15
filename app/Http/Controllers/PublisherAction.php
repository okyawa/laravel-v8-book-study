<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PublishService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublisherAction extends Controller
{
    private PublishService $publisher;

    public function __construct(PublishService $publisher)
    {
        $this->publisher = $publisher;
    }

    /*
    CURLリクエスト例
        curl 'http://localhost/api/publishers' \
            --request POST \
            --data 'name=テスト出版社＆address=東京都千代田区神田猿楽町1丁目5-15'
    */
    public function create(Request $request)
    {
        // nameで指定された名前と同じ出版社が存在しないかを確認
        if ($this->publisher->exists($request->name)) {
            return response('', Response::HTTP_OK);
        }

        // 登録されていない場合は新規で登録
        $id = $this->publisher->store($request->name, $request->address);
        return response('', Response::HTTP_CREATED)
            ->header('Location', '/api/publishers/', $id);

    }
}
