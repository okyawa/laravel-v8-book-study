<?php

declare(strict_types=1);

namespace App\Providers;

use App\Console\Commands\SendOrdersCommand;
use App\Services\ExportOrdersService;
use App\UseCases\SendOrdersUseCase;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;

class BatchServiceProvider extends ServiceProvider
{
    public function register()
    {
        /**
         * ログ出力先を変更
         *
         * リスト 8.3.5.5
         */
        // SendOrdersCommandクラスの生成方法をバインド
        $this->app->bind(
            SendOrdersCommand::class,
            function () {
                $useCase = app(SendOrdersUseCase::class);
                // send-ordersチャンネルを利用するように変更
                /** @var LogManager $logger */
                $logger = app(LogManager::class);
                return new SendOrdersCommand($useCase, $logger->channel('send-orders'));
            }
        );

        /**
         * Guzzleにログ出力用ミドルウェアを追加
         *
         * リスト 8.3.5.7
         */
        $this->app->bind(SendOrdersUseCase::class, function () {
            $service = $this->app->make(ExportOrdersService::class);
            // Guzzleにログ用ミドルウェアを追加
            $guzzle = new Client(
                [
                    'handler' => tap(
                        HandlerStack::create(),
                        function (HandlerStack $v) {
                            $logger = app(LogManager::class);
                            $v->push(
                                Middleware::log(
                                    $logger->driver('send-orders'),
                                    new MessageFormatter(
                                        ">>>\n{req_headers}\n<<<\n{req_headers}\n\n{res_body}"
                                    )
                                )
                            );
                        }
                    )
                ]
            );
            return new SendOrdersUseCase($service, $guzzle);
        });
    }
}
