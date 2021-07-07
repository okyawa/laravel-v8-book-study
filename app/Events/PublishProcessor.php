<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * イベントクラス
 *
 * このファイルの生成コマンド
 * $ php artisan make:event PublishProcessor
 * 任意のディレクトリと名前空間を利用する場合
 * $ php artisan make:event App\\CustomNamespace\\PublishProcessor
 *
 * リスト 7.1.2.4, 7.1.2.5
 */
class PublishProcessor
{
    /**
     * イベントクラスの雛形に含まれるトレイト
     *
     * Illuminate\Queue\SerializesModels
     * Queueと組み合わせて非同期イベントを実行するときに利用
     *
     * Illuminate\Foundation\Events\Dispatchable
     * イベンtのクラスにDispatcherとして作用させるときに利用
     *
     * Illuminate\Broadcasting\InteractsWithSockets
     * socket.ioを使ってブラウザにイベントを通知するときに利用
     *
     * 表 7.1.2.6
     */
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
