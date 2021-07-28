<?php

namespace App\Console\Commands;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

/**
 * このファイルの生成コマンド
 * $ php artisan make:command SampleCommand --command=app:sample
 *
 * リスト 8.3.6.2
 */
class SampleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sample';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $now = CarbonImmutable::now()->toDateTimeString();
        file_put_contents('/tmp/sample.log', $now . PHP_EOL, FILE_APPEND);

        return 0;
    }
}
