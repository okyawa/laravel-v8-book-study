<?php

namespace App\Console;

use App\Console\Commands\HelloCommand;
use App\Console\Commands\SampleCommand;
use App\Console\Commands\SendOrdersCommand;
use Carbon\CarbonImmutable;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         * リスト 8.3.6.3 毎分文字列を出力する
         *
         * scheduleメソッド内で設定したタスクを表形式で表示
         * $ php artisan schedule:list
         */
        $schedule->command(SampleCommand::class) // 実行Commandクラス
            ->description('サンプルタスク')        // タスクの説明 (schedule:listコマンド実行時に表示される)
            ->everyMinute();                     // 実行する時間

        /**
         * リスト 8.3.6.5 schedule:testによる実行
         *
         * このコマンドを実行するとScheduleクラスで設定された一覧表示される
         * 各スケジュールタスクには番号が振られているので、
         * 実行する番号を入力してenterキーを押すと、該当のタスクが実行される
         * $ php artisan schedule:test
         */

        /**
         * リスト 8.3.6.6 callメソッドとexecメソッドによる実行タスクの実装例
         */
        // callメソッドはcallable型の値で実行コードを指定できる
        $schedule->call(function () {
            // 実行コード
            return 0;
        })->description('callメソッド')
            ->everyMinute();
        // execメソッドはコマンドラインで実行可能なコマンドを文字列で指定できる
        $schedule->exec('/usr/bin/date >> /tmp/sample.log')
            ->description('execメソッド')
            ->everyMinute();

        /**
         * リスト 8.3.6.8 cronメソッドによる指定
         *
         * 実行頻度のメソッドが数多くあるが、汎用的に使用できるのがcronメソッド
         */
        // 毎分実行
        $schedule->command(HelloCommand::class)
            ->description('毎分実行')
            ->cron('* * * * *');
        // 午前01:00に実行
        $schedule->command(HelloCommand::class)
            ->description('午前01:00に実行')
            ->cron('* 1 * * *');

        /**
         * 表 8.3.6.8 実行頻度を指定する主なメソッド
         *
         * 分:   everyMinute(), everyTwoMinutes(), everyTenMinutes()
         * 時:   hourly(), hourlyAt(1), everyTwoHours()
         * 日:   daily(), dailyAt('13:00'), twiceDaily(1, 13)
         * 曜日: weekly(), sundays(), weekdays(), weekends(), weeklyOn(1, '8:00')
         * 月:   monthly(), monthlyOn(4, '15:00'), lastDayOfMonth('15:00')
         * 年:   yearly(), yearlyOn(6, 1, '17:00')
         */

        /**
         * リスト 9.3.6.9 SendOrderCommandをスケジュールタスクに設定
         *
         * Commandメソッドの第1引数で実行するクラス名を指定
         * Commandメソッドの第2引数には、Commandクラス実行時に与える引数を指定できる
         */
        $schedule
            ->command(
                SendOrdersCommand::class,
                [CarbonImmutable::yesterday()->format('Ymd')]
            )
            ->dailyAt('05:00')
            ->description('購入情報の送信')
            ->withoutOverlapping(); // 該当タスクが既に起動中の場合は再実行しないように制御

        /**
         * リスト 8.3.6.11 cronによるartisan schedule:runコマンドの実行
         *
         * crontabで下記の設定をすると、毎分artisan schedule:runコマンドが実行される
         * このコマンドはスケジュールタスクの設定を確認し、タスクが実行されるタイミングであれば該当タスクを実行する
         * 実行頻度を下げても問題なければ、毎分実行ではくても大丈夫
         */
        # * * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
