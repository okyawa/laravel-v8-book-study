<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\UseCases\SendOrdersUseCase;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

/**
 * このファイルの生成コマンド
 * $ php artisan make:command SendOrdersCommand --command=app:send-orders
 *
 * make:commandでは、--commandオプションにコマンド名を指定すると、
 * 生成するCommandクラスの$signatureプロパティにその値が設定される
 *
 * このコマンドの実行
 * $ php artisan app:send-order 20210410
 *
 * 実行後、/tmp/orders にJSONが出力される
 * $ cat /tmp/orders
 *
 * リスト 8.3.2.1, .8.3.2.2, 8.3.4.1, 8.3.4.2
 */
class SendOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-orders {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '購入情報を送信する';

    private SendOrdersUseCase $useCase;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SendOrdersUseCase $useCase)
    {
        parent::__construct();

        $this->useCase = $useCase;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // コマンド引数dateの値を取得する
        $date = $this->argument('date');

        // $dateの値(文字列)からCarbonインスタンスを生成
        $targetDate = CarbonImmutable::createFromFormat('Ymd', $date);

        // ユースケースクラスに日付を渡して実行
        $this->useCase->run($targetDate);

        $this->info('ok');

        return 0;
    }
}
