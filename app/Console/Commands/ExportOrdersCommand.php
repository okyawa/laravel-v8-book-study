<?php

declare(strict_types=1);

namespace App\Console\Commands;

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
        $this->info('Hello');
        return 0;
    }
}
