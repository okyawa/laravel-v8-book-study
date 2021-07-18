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
    // protected $signature = 'hello:class'; // このCommandクラスで実行するコマンド名を指定

    /**
     * コマンド引数
     *
     * 引数名を{foo}のようにカーリーブレイスで囲う
     *
     * コマンド引数の指定方法
     * {name}               引数を文字として取得。省略するとエラー
     * {name?}              引数を文字として取得。省略可能。
     * {name=default}       引数を文字として取得。省略すると=の右側がデフォルト値となる
     * {name*}              引数を配列として取得。省略するとエラー
     * {name : description} 「:」(コロン)以降に説明を記述できる。コロンの前後にスペースが必要。
     *
     * $php artisan hello:class name=laravel
     *
     * リスト 8.1.3.1, 8.1.3.5
     */
    /**
     * オプション引数
     *
     * オプション引数は、スイッチのように指定した項目を有効にする場合などに利用
     * コマンド引数と同様に、Commandクラスの$signatureプロパティに指定
     * {}でオプション引数名を囲み、引数名の先頭に--(ハイフン2個)を指定するとオプション引数となる
     *
     * $ php artisan hello:class --switch
     *
     * オプション引数の指定方法
     * {--switch}               引数を論理値として取得。指定するとtrue、省略するとfalseとなる。
     * {--switch=}              引数を文字列として取得。省略可能。
     * {--switch=default}       引数を文字列として取得。省略すると-の右編がデフォルト値となる。
     * {--switch=*}             引数を配列として取得。実行時に、--switch=1 --switch=2と指定すると、['1','2']といった配列になる
     * {--switch : description} :(コロン)以降に説明を記述できる。コロンの前後にスペースが必要。
     * {--S|--switch}           |(パイプ)の前にショートカットオプションを指定可能。
     *                          $signatureプロパティでは--S(ハイフン2個)だが、コマンド実行時には-S(ハイフン1個)で指定する。
     *
     * リスト 8.1.3.6, リスト8.1.3.10
     */
    protected $signature = 'hello:class {name=command} {--S|--switch}';

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
        // $this->comment('Hello class command'); // 文字列出力

        /**
         * コマンド引数の値を取得
         *
         * argumentメソッドの引数には、$signatureプロパティで設定した引数名を指定
         *
         * リスト 8.1.3.2
         */
        $name = $this->argument('name');

        /**
         * オプション引数が指定されたか確認
         *
         * コマンド実行時にオプション引数が指定されたかどうかは、optionメソッドで取得
         * optionメソッドの引数にオプション引数名を指定すると、
         * コマンド実行時にオプションが指定されていればtrue、そうでなければfalseを返す
         *
         * リスト 8.1.3.7
         */
        $switch = $this->option('switch');

        $this->comment('Hello ' . $name . ' ' .($switch ? 'ON' : 'OFF'));
        return 0;
    }
}
