<?php

namespace App\Listeners;

use App\Events\PublishProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

/**
 * 非同期イベントを利用する分離パターン
 *
 * このファイルの生成コマンド
 * $ php artisan make:listener MessageQueueSubscriber --event PublishProcessor
 *
 * イベントに対応するリスナークラスを非同期で実行させたい場合は、Laravelのキュート組み合わせて実装
 * 非同期で実行するには、リスナークラスにIlluminate\Contracts\Queue\ShouldQueueインターフェースを実装
 * このインターフェースはマーカーインターフェース(メソッドやフィールドが一切定義されていないインタフェース)となっているので、メソッドを追加する必要はなし
 *
 * リスト 7.1.5.2
 */
class MessageQueueSubscriber implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  PublishProcessor  $event
     * @return void
     */
    public function handle(PublishProcessor $event)
    {
        // 非同期イベントでリスナークラスが実行されたら、
        // storage/logs/laravel.logにイベント実行時にしていした数値が出力される
        Log::info($event->getInt());
    }
}
