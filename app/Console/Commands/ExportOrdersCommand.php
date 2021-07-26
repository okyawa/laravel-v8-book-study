<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\UseCases\ExportOrderUseCase;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

/**
 * 購入情報を出力するコマンド
 *
 * このファイルの生成コマンド
 * $ php artisan make:command ExportOrdersCommand
 *
 * 実行コマンド
 * 2021-04-10の購入情報
 * $ php artisan app:export-orders 20210410
 * 2021-04-11の購入情報
 * $ php artisan app:export-orders 20210411
 * --outputオプションを指定して出力ファイルパスを指定
 * $ php artisan app:export-orders 20210411 --output /tmp/orders.tsv
 *
 * リスト 8.2.2.2, 8.2.7.1, 8.2.7.4
 */
class ExportOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-orders {date} {--output=}';

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
     * リスト 8.2.4.2, 8.2.7.2, 8.2.7.5
     *
     * @return int
     */
    public function handle()
    {
        // 引数dateの値を取得する
        $date = $this->argument('date');
        // $dateの値(文字列)からCarbonImmutableインスタンスを生成
        $targetDate = CarbonImmutable::createFromFormat('Ymd', $date);
        // ユースケースクラスに日付を渡す
        $tsv = $this->useCase->run($targetDate);

        // outputオプションの値を取得
        $outputFIlePath = $this->option('output');
        // nullであれば未指定なので、標準出力に出力
        if (is_null($outputFIlePath)) {
            echo $tsv, PHP_EOL;
            return 0;
        }

        // ファイルに出力
        file_put_contents($outputFIlePath, $tsv);

        return 0;
    }
}
