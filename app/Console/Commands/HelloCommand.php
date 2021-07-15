<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * このファイルの生成コマンド
 * $ php artisan make:command HelloCommand
 *
 * 実行コマンド
 * $ php artisan hello:class
 *
 * artisanコマンド一覧表示
 * $ php artisan list
 * コマンド名にコロンを含めると、その左側はグループ化される
 *
 * リスト 8.1.2.1〜8.1.2.7
 */
class HelloCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:class'; // このCommandクラスで実行するコマンド名を指定

    /**
     * The console command description.
     *
     * artisan listや引数なしでartisanコマンドを実行したときに出力される
     *
     * @var string
     */
    protected $description = 'サンプルコマンド(クラス)'; // コマンド名の説明を記述

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
     * コマンドで実行する処理を記述
     *
     * @return int
     */
    public function handle()
    {
        $this->comment('Hello class command'); // 文字列出力
        return 0;
    }
}
