<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\UseCase\ExportOrderUseCase;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

/**
 * 購入情報を出力するコマンド
 *
 * このファイルの生成コマンド
 * $ php artisan make:command ExportOrdersCommand
 *
 * 実行コマンド
 * $ php artisan app:export-orders
 *
 * リスト 8.2.2.2
 */
class ExportOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '購入情報を出力する';

    private ExportOrderUseCase $useCase;

    /**
     * Create a new command instance.
     *
     * Commandクラスのコンストラクタでは、サービスコンテナによるDIが行われるので、
     * ユースケースクラスのインスタンスがインジェクトされる
     *
     * @return void
     */
    public function __construct(ExportOrderUseCase $useCase)
    {
        parent::__construct();

        $this->useCase = $useCase;
    }

    /**
     * Execute the console command.
     *
     * リスト 8.2.4.2
     *
     * @return int
     */
    public function handle()
    {
        $tsv = $this->useCase->run(CarbonImmutable::today());
        echo $tsv, PHP_EOL;

        return 0;
    }
}
