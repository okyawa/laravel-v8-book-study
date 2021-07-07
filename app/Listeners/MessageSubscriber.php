<?php

namespace App\Listeners;

use App\Events\PublishProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * イベントリスナー
 *
 * このファイルの生成コマンド
 * $ php artisan make:listener MessageSubscriber --event PublishProcessor
 * ・コマンドの引数にイベントリスナークラス名
 * ・--eventオプションの引数にイベントクラス名
 *
 * リスト 7.1.2.7, 7.1.2.8
 */
class MessageSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PublishProcessor  $event
     * @return void
     */
    public function handle(PublishProcessor $event)
    {
        //
    }
}
