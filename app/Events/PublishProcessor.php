<?php

declare(strict_types=1);

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

    private $int;

    /**
     * イベントは発火した事実を伝えるものであるため、不要な状態変化を防ぐため
     * イミュータブルオブジェクト(インスタンス生成後に値を変更できないオブジェクト)として作成
     * このクラスはイベント名とデータ送信両方の役割を担うことになる
     * イベントに反応するリスナーとして、App\Listeners\MessageSubscriberクラスをイベントに反応させるクラスとして利用
     *
     * リスト: 7.1.3.1
     */
    public function __construct(int $int)
    {
        $this->int = $int;
    }

    public function getInt(): int
    {
        return $this->int;
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
