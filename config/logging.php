<?php

use Monolog\Formatter\ElasticsearchFormatter;
use Monolog\Handler\ElasticsearchHandler;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    /**
     * Monologハンドラで利用する設定キー (一部抜粋)
     *
     * handler          Monologで利用するログハンドラクラスを文字列で指定し、ログドライバを介して利用される
     * handler_with     handlerで指定したログハンドラクラスのコンストラクタにわたす引数を配列で指定する
     * formatter        ログハンドラクラスに対応させたフォーマッタークラスを指定する
     * formatter_with   formatterで指定したフォーマッタクラスのコンストラクタにわたす引数を指定する
     *
     * 表 10.2.3.2: Monologハンドラで利用する設定キー
     *
     * Monologで提供されているログハンドラは、config/logging.phpでのログドライバ指定時に
     * handlerやhandler_withを使って記述することで利用できる
     * 上記のhandlerキーとformatterキーで指定するクラスのインスタンスは、サービスコンテナから取得する
     */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        /**
         * バッチ処理用ログチャンネルを追加
         *
         * リスト 8.3.5.4
         */
        'send-orders' => [
            'driver' => 'daily',
            'path' => storage_path('logs/send-orders.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        /**
         * elasticsearchドライバ設定
         *
         * Monolog\Handler\ElasticsearchHandlerを利用する場合、
         * フォーマッタークラスはMonolog\Formatter\ElasticsearchFormatterクラス、
         * またはその継承クラスである必要がある
         * このクラスの引数に必要なのは、Elasticsearchで利用するインデックス名とドキュメントタイプになる
         * formatterキーとformatter_withキーを利用することで対応付けることが可能
         *
         * Monolog\Handler\ElasticsearchHandlerは、シングルトンでサービスプロバイダに登録済みの状態
         *
         * リスト 10.2.3.4
         */
        'elasticsearch' => [
            'driver' => 'monolog',
            'handler' => ElasticsearchHandler::class,
            'formatter' => ElasticsearchFormatter::class,
            'formatter_with' => [
                'index' => 'app_log',
                'type' => '_doc',
            ]
        ],
    ],

];
