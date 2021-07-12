<?php

namespace App\Providers;

use App\DataProvider\PublisherRepositoryInterface;
use App\Domain\Repository\PublisherRepository;
use App\Foundation\ViewComposer\PolicyComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;
use Knp\Snappy\Pdf;

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
            return new PDF('/usr/bin/wkhtmltopdf');
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
    }
}
