<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 出力レベルごとの出力を確認するOutputCommand
 *
 * このファイルの生成コマンド
 * $ php artisan make:command OutputCommand
 *
 * リスト 8.1.4.3
 */
class OutputCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'output';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '出力テスト';

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
     * 主な出力用メソッド
     * line()     スタイルなし
     * info()     infoスタイル (文字色: 緑)
     * comment()  commentスタイル (文字色: 黄)
     * question() questionスタイル (文字色: 黒, 背景色: シアン)
     * error()    errorスタイル (文字色: 白, 背景色: 赤)
     * warn()     warnスタイル (文字色: 黄)
     * 表 8.1.4.1
     *
     * 実行コマンド
     * $ php artisan output --quiet
     * $ php artisan output
     * $ php artisan output -v
     * $ php artisan output -vv
     * $ php artisan output -vvv
     *
     * @return int
     */
    public function handle()
    {
        $this->error('quiet', OutputInterface::VERBOSITY_QUIET); // 常に出力
        $this->warn('normal', OutputInterface::VERBOSITY_NORMAL); // デフォルトの出力レベル。--quiet以外で出力
        $this->question('verbose', OutputInterface::VERBOSITY_VERBOSE); // -v, -vv, -vvvで出力
        $this->comment('very_verbose', OutputInterface::VERBOSITY_VERY_VERBOSE); // -vv, -vvvで出力
        $this->info('debug', OutputInterface::VERBOSITY_DEBUG); // -vvvでのみ出力

        /**
         * CommandクラスからたのCommandを実行
         *
         * Commandクラスから他のコマンドを実行する場合は、Commandクラスのcallメソッドでも代用可能
         * リスト 8.1.5.3
         */
        $ret = $this->call('hello:class', [
            'name' => 'Johann',
            '--switch' => true,
        ]);

        return 0;
    }
}
