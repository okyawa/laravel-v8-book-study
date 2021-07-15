<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\PdfGenerator;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;

use function dispatch;

/**
 * コントローラクラスによるPDFファイル出力Job実行例
 *
 * リスト 7.2.4.6
 */
final class PdfGeneratorAction extends Controller
{
    private $dispatcher;

    public function __construct(
        Dispatcher $dispatcher
    ) {
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(): void
    {
        $generator = new PdfGenerator(storage_path('pdf/sample.pdf'));

        // コンストラクタインジェクションを利用して
        // Illuminate\Contracts\Bus\Dispatcherインターフェースの
        // dispatchメソッドで実行指示。Busファサードを使った記述も可能
        $this->dispatcher->dispatch($generator);
        // Illuminate\Foundation\Bus\DispatchesJobsトレイト経由でdispatchを利用可能
        $this->dispatch($generator);
        // dispatchヘルパ関数で実行指示
        dispatch($generator);

        /**
         * スタティックメソッドによるJob実行例
         *
         * JobクラスにIlluminate\Foundation\Bus\Dispatchableトレイトが記述されていれば、
         * 下記コード例に示す記述だけで実現可能
         * メソッドインジェクションでインスタンスを生成する記述であれば、
         * ユニットテストでもMockeryなどを使わずに簡単に振る舞いを変更できるのでおすすめ
         *
         * リスト 7.2.4.7
         */
        PdfGenerator::dispatch(storage_path('pdf/sample.pdf'));

        /**
         * ジョブキューの指定
         *
         * default以外のキューを指定する場合は、--queueオプションを利用してqueueを指定
         *
         * キューの起動コマンド
         * $ php artisan queue:work --queue pdf.generator
         *
         * リスト7.2.5.1
         */
        // dispatchヘルパ関数でどのqueueで処理を行うかを指定
        dispatch($generator)->onQueue('pdf.generator');
    }
}
