<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\PublishProcessor;
use App\Listeners\MessageSubscriber;
use App\Listeners\RegisteredListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

/**
 * イベント登録
 *
 * イベントの登録はlistenプロパティで登録するか、
 * bootメソッド内でEventファサードなどを利用してlistenメソッドでイベントクラスとリスナークラスを登録
 * Eventファサードの代わりに、サービスコンテナ経由でインスタンスを取得するパターンでも大丈夫
 * 通常のアプリケーションに組み込んで利用する場合は、複雑なビジネスロジックのリファクタリングで対応することが一般的
 * 例えば、ユーザー登録処理と登録完了後に管理者にメールで通知する処理の場合では、イベントを使って処理を分離するのが一般的
 *
 * リスト 7.1.3.3
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            // 'App\Listeners\RegisteredListener', // ←を追加し、「php artisan event:generate」のコマンドでファイル生成
            RegisteredListener::class,
        ],
        /**
         * イベントの登録方法
         * デフォルトで用意されているlistenプロパティで指定する場合
         * リスト 7.1.3.3
         */
        PublishProcessor::class => [
            MessageSubscriber::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * イベントの登録方法
         * bootメソッドを使って登録する場合
         * リスト 7.1.3.3
         */
        parent::boot();

        // Facadeを利用した例
        // listenメソッドの第1引数には、イベント名やイベントクラスを文字列で指定
        // もしくは、配列でイベント名とイベントクラス名を複数指定できる
        // 第2引数には、リスナーとして作用させるクラスを文字列またはオブジェクトで指定
        Event::listen(
            PublishProcessor::class,
            MessageSubscriber::class
        );
        // リスナークラスで任意のメソッドを実行させたい場合は、
        // 「Listenerクラス名@任意のメソッド名」と指定できる
        // 複数のイベントに対して1角リスナークラスで対応可能だが、
        // 1つのリスナークラスに様々な実装コードが入り込む可能性があるため、
        // 大規模アプリケーションでの多用は避けた方がいい
        // リスト 7.1.3.4
        // Event::listen('name.friend', 'SubscribeListener@invoke');

        // フレームワークのDIコンテナにアクセスする場合
        $this->app['events']->listen(
            PublishProcessor::class,
            MessageSubscriber::class
        );
    }
}
