<?php

namespace App\Providers;

use App\DataProvider\PublisherRepositoryInterface;
use App\Domain\Repository\PublisherRepository;
use App\Foundation\ViewComposer\PolicyComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;

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
