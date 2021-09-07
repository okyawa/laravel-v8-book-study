<?php

namespace App\Providers;

use App\DataProvider\PublisherRepositoryInterface;
use App\Domain\Repository\PublisherRepository;
use App\Foundation\ElasticsearchClient;
use App\Foundation\ViewComposer\PolicyComposer;
use Fluent\Logger\FluentLogger;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;
use Knp\Snappy\Pdf;
use Monolog\Handler\ElasticsearchHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PublisherRepositoryInterface::class,
            PublisherRepository::class
        );

        /**
         * Knp\Snappy\Pdfクラスをサービスプロバイダへ登録
         *
         * コンストラクタインジェクションおよびメソッドインジェクションで、
         * Knp\Snappy\Pdfと型宣言されていれば、無名関数で記述した通りにインスタンス生成が行われ、
         * 利用するクラスにオブジェクトが渡される
         *
         * リスト 7.2.4.2
         */
        $this->app->bind(Pdf::class, function() {
            return new PDF('/usr/local/bin/wkhtmltopdf');
        });

        /**
         * ElasticsearchClientクラスのインスタンス生成方法定義
         *
         * リスト 7.3.6.4
         */
        $this->app->singleton(ElasticsearchClient::class, function (Application $app) {
            $config = $app['config']->get('elasticsearch');
            return new ElasticsearchClient($config['hosts']);
        });

        /**
         * Fluent\Logger\FluentLoggerクラスの登録
         *
         * Fluent\Logger\FluentLoggerクラスをシングルトンでサービスプロバイダへ登録
         *
         * リスト 10.1.4.2
         */
        $this->app->singleton(FluentLogger::class, function () {
            // 実際に利用する場合は .envファイルなどでサーバのアドレスとportを指定
            return new FluentLogger('localhost', 24224);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Factory $factory)
    {
        /**
         * View Composerの登録例
         *
         * ViewComposerを登録する場合はbootメソッドを利用して記述
         * これで、テンプレートに認可処理等を使った記述をせずに実際の処理を分岐できる
         * リスト 6.5.3.4
         */
        $factory->composer('PolicyComposerを利用したいテンプレート名', PolicyComposer::class);

        /**
         * Monolog\Handler\ElasticSearchHandlerクラスのサービスプロバイダ登録例
         *
         * リスト 10.2.3.3
         */
        $this->app->singleton(
            ElasticsearchHandler::class,
            function (Application $app) {
                return new ElasticsearchHandler(
                    $app->make(ElasticsearchClient::class)->client()
                );
            }
        );
    }
}
