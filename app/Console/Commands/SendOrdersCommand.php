<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * このファイルの生成コマンド
 * $ php artisan make:command SendOrdersCommand --command=app:send-orders
 *
 * make:commandでは、--commandオプションにコマンド名を指定すると、
 * 生成するCommandクラスの$signatureプロパティにその値が設定される
 *
 * このコマンドの実行
 * $ php artisan app:send-order
 *
 * リスト 8.3.2.1, .8.3.2.2
 */
class SendOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '購入情報を送信する';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Send Orders');
        return 0;
    }
}
