<?php

namespace App\Http\Controllers;

use App\Events\PublishProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class EventController extends Controller
{
    public function __invoke(Request $request)
    {
        $view = View('welcome');
        /**
         * イベントを発行する例
         * リスト 7.1.3.5
         */
        // Dispatcherクラス経由でEventを実行する場合
        Event::dispatch(new PublishProcessor(1));
        return $view;
    }
}
