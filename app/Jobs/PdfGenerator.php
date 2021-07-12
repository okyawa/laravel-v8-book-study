<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Knp\Snappy\Pdf;

/**
 * PDFファイル出力Jobクラス実装例
 *
 * 簡単な文字列をPDFファイルに出力する実装
 *
 * このファイルの生成コマンド
 * $ php artisan make:job PdfGenerator
 *
 * リスト 7.2.4.4
 */
class PdfGenerator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * handleメソッドの引数に型宣言を記述すると、
     * サービスコンテナで定義したオブジェクトが渡される
     *
     * .envのQUEUE_CONNECTIONがsyncではない場合、
     * 下記のコマンドで非同期Listenerを起動
     * $ php artisan queue:work
     *
     * @return void
     */
    public function handle(Pdf $pdf)
    {
        // html形式でPDF出力を指定する
        $pdf->generateFromHtml(
            '<h1>Laravel</h1><p>Sample PDF Output.</p>', $this->path
        );
    }
}
